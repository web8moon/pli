<?php

function dbConnector($conf) {
    if (is_array($conf)) {
        return mysqli_connect($conf['dbhost'], $conf['dbuser'], $conf['dbpass'], $conf['dbname']);
    } else {
        return false;
    }
}

function loadConfig($file){
	if(file_exists($file)) $conf = include_once ($file);
	if (is_array($conf)) return $conf;
}

function loadLang($Conf){
	$file = 'config'.DIRECTORY_SEPARATOR.'lang_' . $Conf['currentLang'] . '.php';
	
	if(file_exists($file)) {
		$lang = include_once ($file);
	} else {
		$file = 'config'.DIRECTORY_SEPARATOR.'lang_' . $Conf['defaultLang'] . '.php';
        if(file_exists($file)) {
            $lang = include_once ($file);
        } else {
            die("Error loading language file");
        }
	}
	
	return $lang;
}

function parseQueryUrl($queryString){
	if(!empty($queryString)){
		$queryString = urldecode($queryString);
		$query_params = explode("/",$queryString);
		foreach ($query_params as $query_param)
		if ($query_param != "")
			$query[] = strtolower($query_param);
		return $query;
	}
}

function render($pathToTemplate, $data){
	extract($data);
	ob_start();
	require $pathToTemplate;
	return trim(ob_get_clean());
}

function setLang($oldLang, $newLang, $allowLang){
    if(!empty($newLang) and !empty($allowLang) and in_array($newLang, $allowLang)){
        return $newLang;
    }
    else {
        return $oldLang;
    }
}

function startUserSession(){
	// $_SESSION['start'] = md5($_SERVER['HTTP_USER_AGENT']+date("z"));
    $_SESSION['start'] = $_SERVER['HTTP_USER_AGENT']+date("z");
}

function controler($conf, $lang) {

// LOGOUT
	if ($conf['currentAction'] == 'logout') {
		$_SESSION = array();
		session_destroy();
		$path = $conf['defaultAction'] . '/' . $conf['currentLang'];
		header('Location: /' . $path);
	}

// REGISTER
    if ($conf['currentAction'] == 'register') {
		$success = false;
		$errorMSG = $lang['siteRegisterConnErr'];
		if (is_array($conf)) {
            $link = dbConnector($conf);
			if ($link) {
				$errorMSG = '';
				// EMAIL
				if (empty($_POST["name"])) {
					$errorMSG = $lang['siteRegisterLoginErr'];
				} else {
					$name = mysqli_real_escape_string ($link, $_POST["name"]);
				}
				// PASWORD
				if (empty($_POST["passw"]) or empty($_POST["passw2"])) {
					$errorMSG .= $lang['siteRegisterPasswErr'];
				} else {
					if($_POST["passw"] == $_POST["passw2"]) {
						$password = mysqli_real_escape_string ($link, $_POST["passw"]);
					} else {
						$errorMSG .= $lang['siteRegisterPassw2Err'];
					}
				}

				if ($errorMSG == ''){
					$select = 'SELECT `UserEmail` FROM `users` WHERE `UserEmail` like \'' . $name . '\' LIMIT 1';
					if($result = mysqli_query($link, $select)) {
                        if (mysqli_num_rows($result) > 0) {
                            $errorMSG .= $lang['siteRegisterDublicateErr'];
                        } else {
                            $select = 'INSERT INTO `users` SET `UserEmail`=\'' . $name . '\', `UserPsw`=\'' . md5($password) . '\', `Active`=0, `UserPlan`=1';
                            if (mysqli_query($link, $select)) {
                                $success = true;
                            } else {
                                $errorMSG .= $lang['siteRegisterAddErr'];
                            }
                        }
                        mysqli_free_result($result);
                    }
				}
				mysqli_close($link);
			}
		}

		// redirect to success page
		if ($success && $errorMSG == '') {
			startUserSession();
			echo 'success';
		} else {
			if ($errorMSG == '') {
			echo $lang['siteRegisterWrongErr'];
			} else {
				echo $errorMSG;
			}
		}
		

    }
	
	
	
	
// LOGIN
    if ($conf['currentAction'] == 'login') {
		$success = false;
        $errorMSG = $lang['siteRegisterConnErr'];
        if (is_array($conf)) {
            $link = dbConnector($conf);
            if ($link) {
                $errorMSG = '';
                // EMAIL
                if (empty($_POST["name"])) {
                    $errorMSG = $lang['siteRegisterLoginErr'];
                } else {
                    $name = mysqli_real_escape_string ($link, $_POST["name"]);
                }
                // PASWORD
                if (empty($_POST["passw"])) {
                    $errorMSG .= $lang['siteRegisterPasswErr'];
                } else {
                    $password = mysqli_real_escape_string ($link, $_POST["passw"]);

                }

                if ($errorMSG == ''){
                    $select = 'SELECT `UserEmail`, `Active`, `UserPsw` FROM `users` WHERE `UserEmail` like \'' . $name . '\' LIMIT 1';
                    if($result = mysqli_query($link, $select)) {
                        if (mysqli_num_rows($result) == 1) {
                            $users = mysqli_fetch_assoc($result);
                            if ($users['UserPsw'] == md5($password)) {
                                if($users['Active'] >= 0) {
                                    $success = true;
                                } else {
                                    $errorMSG .= $lang['siteLoginAccountErr'];
                                }
                            } else {
                                $errorMSG .= $lang['siteLoginPasswErr'];
                            }
                        } else {
                            $errorMSG .= $lang['siteLoginUserNot'];
                        }
                        mysqli_free_result($result);
                    }
                }
                mysqli_close($link);
            }
        }

        // redirect to success page
        if ($success && $errorMSG == '') {
            startUserSession();
            echo 'success';
        } else {
            if ($errorMSG == '') {
                echo $lang['siteRegisterWrongErr'];
            } else {
                echo $errorMSG;
            }
        }
	}
}