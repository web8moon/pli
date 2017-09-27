<?php

function loadConfig($file){
	if(file_exists($file)) $conf = include_once ($file);
	return $conf;
}

function loadLang($Conf){
	$file = 'config'.DIRECTORY_SEPARATOR.'lang_' . $Conf['currentLang'] . '.php';
	
	if(file_exists($file)) {
		$lang = include_once ($file);
	} else {
		$file = 'config'.DIRECTORY_SEPARATOR.'lang_' . $Conf['defaultLang'] . '.php';
        if(file_exists($file)) $lang = include_once ($file);
	}
	
	return $lang;
}

function parseQueryUrl($queryString){
	if(!empty($queryString)){
		$queryString = urldecode($queryString);
		$query_params = explode("/",$queryString);
		foreach ($query_params as $query_param)
		if ($query_param != "")
			$query[] = $query_param;
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

function controler($conf) {

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
		$errorMSG = 'Data connection Error';
		if (is_array($conf)) {
			$link = mysqli_connect($conf['dbhost'], $conf['dbuser'], $conf['dbpass'], $conf['dbname']);
			if ($link) {
				$errorMSG = '';
				// NAME
				if (empty($_POST["name"])) {
					$errorMSG = 'Login is required ';
				} else {
					$name = $_POST["name"];
				}
				// EMAIL
				if (empty($_POST["passw"])) {
					$errorMSG .= 'Password is required ';
				} else {
					$password = $_POST["passw"];
				}

				if ($errorMSG == ''){
					$select = 'SELECT `UserEmail` FROM `users` WHERE `UserEmail` like \'' .  mysqli_real_escape_string ($link, $name) . '\' LIMIT 1';
					if($result = mysqli_query($link, $select)) {
                        if (mysqli_num_rows($result) > 0) {
                            $errorMSG .= 'Entered Email is already registred';
                        } else {
                            $select = 'INSERT INTO `users` SET `UserEmail`=\'' .  mysqli_real_escape_string ($link, $name) . '\', `UserPsw`=\'' . mysqli_real_escape_string ($link, $password) . '\', `Active`=0 ';
                            if (mysqli_query($link, $select)) {
                                $success = true;
                            } else {
                                $errorMSG .= 'Error adding new user';
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
			//session_start();
			//$_SESSION['start'] = md5($_SERVER['HTTP_USER_AGENT']);
			echo "success";
		} else {
			if ($errorMSG == '') {
			echo 'Something went wrong :(';
			} else {
				echo $errorMSG;
			}
		}
		

		
		
		
		
		
		
		
    }
}