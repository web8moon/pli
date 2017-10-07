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

function startUserSession($el1, $el2){
	$_SESSION['start'] = $el1 . md5($_SERVER['HTTP_USER_AGENT'] + date("z")) . $el2;
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
						$password = md5(mysqli_real_escape_string ($link, $_POST["passw"]));
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
                            $select = 'INSERT INTO `users` SET `UserEmail`=\'' . $name . '\', `UserPsw`=\'' . $password . '\', `Active`=0, `UserPlan`=1';
                            if (mysqli_query($link, $select)) {
								$userID = mysqli_insert_id($link);
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
			startUserSession($userID, $password);
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
                    $select = 'SELECT `UserID`, `UserEmail`, `Active`, `UserPsw` FROM `users` WHERE `UserEmail` like \'' . $name . '\' LIMIT 1';
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
            startUserSession($users['UserID'], $users['UserPsw']);
            echo 'success';
        } else {
            if ($errorMSG == '') {
                echo $lang['siteRegisterWrongErr'];
            } else {
                echo $errorMSG;
            }
        }
	}
	
	
// UPDATE PROFILE
    if ($conf['currentAction'] == 'save-profile') {
		$success = false;
        $errorMSG = $lang['siteRegisterConnErr'];
		if (is_array($conf)) {
            $link = dbConnector($conf);
            if ($link) {
				$errorMSG = '';
				
				// gather data
				if (empty($_POST["formid"])) {
                    $errorMSG = $lang['siteRegisterWrongErr'];
                } else {
                    $formid = mysqli_real_escape_string ($link, $_POST["formid"]);
                }
				if (empty($_POST["active"])) {
                    $errorMSG = $lang['siteRegisterWrongErr'];
                } else {
					if (strtolower(mysqli_real_escape_string ($link, $_POST["active"])) == 'true'){
						$active = 1;
					} else {
						$active = 0;
					}
                }
				/*
				if (empty($_POST["plan"])) {
                    $errorMSG = $lang['siteRegisterWrongErr'];
                } else {
                    $plan = mysqli_real_escape_string ($link, $_POST["plan"]);
                }
				*/
				if (!empty($_POST["name"]) and strlen($_POST["name"])<25) {
                    $name = mysqli_real_escape_string ($link, $_POST["name"]);
                } else {
					$name = '';
				}

				if (empty($_POST["mail"]) or strlen($_POST["mail"])<6 or strlen($_POST["mail"])>49) {
                    $errorMSG = $lang['siteRegisterLoginErr'];
                } else {
                    $mail = mysqli_real_escape_string ($link, $_POST["mail"]);
                }
				if (empty($_POST["passw"]) or strlen($_POST["passw"])<2 or strlen($_POST["passw"])>50) {
                    $errorMSG = $lang['siteRegisterWrongErr'];
                } else {
                    $passwnew = mysqli_real_escape_string ($link, $_POST["passw"]);
                }
				if (empty($_POST["passwconf"])) {
                    $errorMSG = $lang['siteRegisterWrongErr'];
                } else {
                    $passwconfirm = mysqli_real_escape_string ($link, $_POST["passwconf"]);
                }
				if (empty($_POST["uri1"])) {
                    $errorMSG = $lang['siteRegisterWrongErr'];
                } else {
                    $uri1 = mysqli_real_escape_string ($link, $_POST["uri1"]);
                }
			
				if ($uri1 == $conf['profileLink']) {
					if ($errorMSG == ''){
						$select = 'SELECT `UserPsw`,`Active` FROM `users` WHERE `UserID`=\'' . $formid . '\' LIMIT 1';
						if($result = mysqli_query($link, $select)) {
							if (mysqli_num_rows($result) == 1) {
								$users = mysqli_fetch_assoc($result);
								if ($users['UserPsw'] == md5($passwconfirm)) {
									if($users['Active'] >= 0) {
									
										$select = 'UPDATE `users` SET `UserName`=\'' . $name . '\', `UserPsw`=\'' . md5($passwnew) . '\', `UserEmail`=\'' . $mail . '\', `Active`=' . $active . ', `UserPlan`=1 WHERE `UserID`=\'' . $formid . '\' AND `UserPsw`=\'' . md5($passwconfirm) . '\' LIMIT 1';
									
										//$errorMSG .= var_dump($_POST);
									
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
				} else {
					$errorMSG = $lang['siteLoginAccountErr'];
				}
				
				
				
				
				
				
				
			
			}
			mysqli_close($link);
		}

		// redirect to success page
		if ($success && $errorMSG == '') {
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