<?php

function dbConnector($conf)
{
    $ok = false;
    if (is_array($conf)) {
        $link = @mysqli_connect($conf['dbhost'], $conf['dbuser'], $conf['dbpass'], $conf['dbname'], $conf['dbhostport']);
        if (mysqli_connect_errno() == 0) {
            if ($link and mysqli_set_charset($link, "utf8")) $ok = true;
        }
    }
    if ($ok) {
        return $link;
    } else {
        return false;
    }
}

function loadConfig($file)
{
    if (file_exists($file))
        $conf = include_once($file);
    if (is_array($conf))
        return $conf;
}

function loadLang($Conf)
{
    $file = 'config' . DIRECTORY_SEPARATOR . 'lang_' . $Conf['currentLang'] . '.php';

    if (file_exists($file)) {
        $lang = include_once($file);
    } else {
        $file = 'config' . DIRECTORY_SEPARATOR . 'lang_' . $Conf['defaultLang'] . '.php';
        if (file_exists($file)) {
            $lang = include_once($file);
        } else {
            die("Error loading language file");
        }
    }

    return $lang;
}

function parseQueryUrl($queryString)
{
    if (!empty($queryString)) {
        $queryString = urldecode($queryString);
        $query_params = explode("/", $queryString);
        foreach ($query_params as $query_param)
            if ($query_param != "")
                $query[] = strtolower($query_param);
        return $query;
    }
}

function render($pathToTemplate, $data)
{
    extract($data);
    ob_start();
    require $pathToTemplate;
    return trim(ob_get_clean());
}

function setLang($oldLang, $newLang, $allowLang)
{
    if (!empty($newLang) and !empty($allowLang) and in_array($newLang, $allowLang)) {
        return $newLang;
    } else {
        return $oldLang;
    }
}

function startUserSession($el1, $el2)
{
    if (is_numeric($el1) && $el1 > 0) {
        $link = dbConnector($GLOBALS['Conf']);
        if ($link) {
            $select = 'SELECT `ID` FROM `pli_userstoks` WHERE `UserID`=\'' . $el1 . '\' LIMIT 1';
            if ($result = mysqli_query($link, $select)) {
                if (mysqli_num_rows($result) > 0) {
                    $_SESSION['start'] = $el1 . md5($_SERVER['HTTP_USER_AGENT'] + date("z")) . $el2;
                }
                mysqli_free_result($result);
            }
            unset($select);
            mysqli_close($link);
        }
    }
}

function checkUserSession($sesVarName)
{
    $ok = false;
    if (!empty($sesVarName)) {
        if (isset($_SESSION[$sesVarName])) {
            $a = strpos($_SESSION[$sesVarName], md5($_SERVER['HTTP_USER_AGENT'] + date("z")));
            if ($a > 0) {
                $ok = substr($_SESSION[$sesVarName], 0, $a);
            }
        }
    }
    // Return KundenNumer
    return $ok;
}

function getUserParams()
{
    $ok = false;
    $userParams = array();
    $userParams['stokNumbers'] = 0;
    $userID = checkUserSession('start');

    if (is_numeric($userID) and $userID > 0) {
        $link = dbConnector($GLOBALS['Conf']);
        if ($link) {
            $select = 'SELECT 
						pli_stockphones.ID P_ID,
						pli_stockphones.StockID P_SiD,
						pli_stockphones.CountryCode P_CC,
						pli_stockphones.Phone P_Ph,
						pli_stockphones.IsViber P_iV,
						pli_stockphones.IsWatsapp P_iW,
    
						pli_userstoks.ID S_ID, 
						pli_userstoks.StockName S_Name,
						pli_userstoks.StockCountry S_Country,
						pli_userstoks.StockCity S_City,
						pli_userstoks.StockAdress S_Adr,
						pli_userstoks.StockEmail S_mail,
						pli_userstoks.ShipsInfo S_Shi,
						pli_userstoks.Currency S_Cur,
						pli_userstoks.Active S_Act,
						
						pli_users.UserName U_Name,
						pli_users.UserPsw U_Pwd,
						pli_users.UserEmail U_mail,
						pli_users.UserPlan U_Plan,
						pli_users.Active U_Act
						
					FROM pli_stockphones
						RIGHT JOIN pli_userstoks ON pli_userstoks.ID=pli_stockphones.StockID
						JOIN pli_users ON pli_users.UserID=pli_userstoks.UserID
					WHERE
						pli_users.UserID=' . $userID . ' ORDER by S_ID';
            if ($result = mysqli_query($link, $select)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($Mas = mysqli_fetch_assoc($result)) {
                        $userParams[$userParams['stokNumbers']] = $Mas;
						$userParams['stokNumbers']++;
                    }
                    unset ($Mas);
$userParams['stokNumbers']--;

                    $userParams['User']['UserName'] = $userParams[$userParams['stokNumbers']]['U_Name'];
                    $userParams['User']['UserPsw'] = $userParams[$userParams['stokNumbers']]['U_Pwd'];
                    $userParams['User']['UserEmail'] = $userParams[$userParams['stokNumbers']]['U_mail'];
                    $userParams['User']['UserPlan'] = $userParams[$userParams['stokNumbers']]['U_Plan'];
                    $userParams['User']['Active'] = $userParams[$userParams['stokNumbers']]['U_Act'];

                    for ($i = 0; $i <= $userParams['stokNumbers']; $i++) {

                        $userParams['Stock'][$i]['ID'] = $userParams[$i]['S_ID'];
                        $userParams['Stock'][$i]['StockName'] = $userParams[$i]['S_Name'];
                        $userParams['Stock'][$i]['StockCountry'] = $userParams[$i]['S_Country'];
                        $userParams['Stock'][$i]['StockCity'] = $userParams[$i]['S_City'];
                        $userParams['Stock'][$i]['StockAdress'] = $userParams[$i]['S_Adr'];
                        $userParams['Stock'][$i]['StockEmail'] = $userParams[$i]['S_mail'];
                        $userParams['Stock'][$i]['ShipsInfo'] = $userParams[$i]['S_Shi'];
                        $userParams['Stock'][$i]['Currency'] = $userParams[$i]['S_Cur'];
                        $userParams['Stock'][$i]['Active'] = $userParams[$i]['S_Act'];

                        $userParams['Phone'][$i]['ID'] = $userParams[$i]['P_ID'];
                        $userParams['Phone'][$i]['StockID'] = $userParams[$i]['P_SiD'];
                        $userParams['Phone'][$i]['CountryCode'] = $userParams[$i]['P_CC'];
                        $userParams['Phone'][$i]['Phone'] = $userParams[$i]['P_Ph'];
                        $userParams['Phone'][$i]['IsViber'] = $userParams[$i]['P_iV'];
                        $userParams['Phone'][$i]['IsWatsapp'] = $userParams[$i]['P_iW'];

                        unset ($userParams[$i]);
                    }

                    unset ($userParams['stokNumbers']);

                    $userParams['Stock'] = array_unique($userParams['Stock'], 0);
                    sort($userParams['Stock'], 0);

                    $userParams['Phone'] = array_unique($userParams['Phone'], 0);
                    sort($userParams['Phone'], 0);


                    $ok = true;

                }
                mysqli_free_result($result);
            }

            mysqli_close($link);


        }
    }


    /*
    if ($userID > 0) {
        $link = dbConnector($GLOBALS['Conf']);
        if ($link) {
            $select = 'SELECT `UserID`,`UserName`,`UserPsw`,`UserPlan`,`Active` FROM `pli_users` WHERE `UserID`=' . $userID . ' LIMIT 2';
            if ($result = mysqli_query($link, $select)) {
                if (mysqli_num_rows($result) == 1) {
                    $userParams['User'] = mysqli_fetch_assoc($result);
                    mysqli_free_result($result);

                    $select = 'SELECT * FROM `pli_userstoks` WHERE `UserID`=' . $userID . ' ORDER BY `DateCreated` ASC';
                    if ($result = mysqli_query($link, $select)) {
                        unset($select);
                        if (mysqli_num_rows($result) > 0) {
                            while ($Mas = mysqli_fetch_assoc($result)) {
                                $userParams['stokNumbers'] ++;
                                $userParams[$userParams['stokNumbers']] = $Mas;
                            }
                            unset($Mas);
                            mysqli_free_result($result);

                            $select = 'SELECT * FROM `pli_stockphones` WHERE ';
                            $ok = true;



                        }
                    }
                }
            }
            mysqli_close($link);
        }
    }
    */

    if ($ok) {
        return $userParams;
    } else {
        return false;
    }
}

function getTableList($dbTable)
{
    $link = dbConnector($GLOBALS['Conf']);
    if ($link) {
        $select = 'SELECT `ID`,`Name` FROM `' . $dbTable . '` ORDER BY `Name` ASC';
        if ($result = mysqli_query($link, $select)) {
            if (mysqli_num_rows($result) > 0) {
                while ($Mas = mysqli_fetch_assoc($result)) {
                    $M[] = $Mas;
                }
            }
            mysqli_free_result($result);
        }
        mysqli_close($link);
        unset($Mas, $select);
    }
    if (isset($M) and is_array($M)) {
        return $M;
    } else {
        return false;
    }
}

function checkTemplateExist($pattern)
{
    $template = 'views' . DIRECTORY_SEPARATOR . $pattern . 'Template.php';
    if (file_exists($template)) {
        return $template;
    } else {
        return false;
    }
}

/**
 *
 * @param
 *            $conf
 * @param
 *            $lang
 */
function controler($conf, $lang)
{

    // LOGOUT
    if ($conf['currentAction'] == $conf['serviceLinks']['logout']) {
        if (isset($_SESSION['start'])) {
            $_SESSION = array();
            session_destroy();
            $path = $conf['defaultAction'] . '/' . $conf['currentLang'];
            header('Location: /' . $path);
        }
    }

    // REGISTER
    if ($conf['currentAction'] == $conf['serviceLinks']['register']) {
        if (!empty($_POST)) {
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
                        $name = mysqli_real_escape_string($link, $_POST["name"]);
                    }
                    // PASWORD
                    if (empty($_POST["passw"]) or empty($_POST["passw2"])) {
                        $errorMSG .= $lang['siteRegisterPasswErr'];
                    } else {
                        if ($_POST["passw"] == $_POST["passw2"]) {
                            $password = md5(mysqli_real_escape_string($link, $_POST["passw"]));
                        } else {
                            $errorMSG .= $lang['siteRegisterPassw2Err'];
                        }
                    }

                    if ($errorMSG == '') {

                        $select = 'SELECT `UserEmail` FROM `pli_users` WHERE `UserEmail` like \'' . $name . '\' LIMIT 1';
                        if ($result = mysqli_query($link, $select)) {
                            if (mysqli_num_rows($result) > 0) {
                                $errorMSG = $lang['siteRegisterDublicateErr'];
                            } else {

                                $select = 'INSERT INTO `pli_users` SET `UserEmail`=\'' . $name . '\', `UserPsw`=\'' . $password . '\', `Active`=1, `UserPlan`=1';
                                if (mysqli_query($link, $select)) {
                                    $userID = mysqli_insert_id($link);
                                    $select = 'SELECT `ID` FROM `pli_userstoks` WHERE `UserID`=\'' . $userID . '\' LIMIT 1';
                                    if ($result = mysqli_query($link, $select)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            $errorMSG = $lang['siteRegisterAddErr'];
                                        } else {

                                            // INITIALISING THE STOCK
                                            $select = 'INSERT INTO `pli_userstoks` SET `UserID`=\'' . $userID . '\', `Active`=0';
                                            if (mysqli_query($link, $select)) {
                                                $stockID = mysqli_insert_id($link);
                                                if ($stockID > 0) {
                                                    // INITIALISING THE PHONE
                                                    $select = 'INSERT INTO `pli_stockphones` SET `StockID`=\'' . $stockID . '\', `CountryCode`=\'00\'';
                                                    if (mysqli_query($link, $select)) {
                                                        $success = true;
                                                    } else {
                                                        $errorMSG = $lang['siteRegisterAddErr'];
                                                    }
                                                }
                                            } else {
                                                $errorMSG = $lang['siteRegisterAddErr'];
                                            }
                                        }
                                    }
                                } else {
                                    $errorMSG = $lang['siteRegisterAddErr'];
                                }
                            }
                            mysqli_free_result($result);
                        }
                        unset($select);

                        /*
                         * $select = 'SELECT `UserEmail` FROM `pli_users` WHERE `UserEmail` like \'' . $name . '\' LIMIT 1';
                         * if ($result = mysqli_query($link, $select)) {
                         * if (mysqli_num_rows($result) > 0) {
                         * mysqli_free_result($result);
                         * $errorMSG .= $lang['siteRegisterDublicateErr'];
                         * } else {
                         *
                         * $select = 'INSERT INTO `pli_users` SET `UserEmail`=\'' . $name . '\', `UserPsw`=\'' . $password . '\', `Active`=1, `UserPlan`=1';
                         * if (mysqli_query($link, $select)) {
                         * $userID = mysqli_insert_id($link);
                         *
                         * $select = 'SELECT `ID` FROM `pli_userstoks` WHERE `UserID`=\'' . $userID . '\' LIMIT 1';
                         *
                         * if (!$result = mysqli_query($link, $select)) {
                         *
                         * $select = 'INSERT INTO `pli_userstoks` SET `UserID`=\'' . $userID . '\', `Active`=0';
                         * if (mysqli_query($link, $select)) {
                         * $success = true;
                         * } else {
                         * $errorMSG = $lang['siteRegisterAddErr'];
                         * }
                         * } else {
                         * mysqli_free_result($result);
                         * }
                         *
                         * }
                         * }
                         *
                         * }
                         */
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
                    mysqli_close($link);
                } else {
                    echo $lang['siteRegisterConnErr'];
                    //header("Location: /" . $conf['defaultAction'] . "/" . $conf['currentLang']);
                    exit();
                }
            }
        }
    }

    // LOGIN
    if ($conf['currentAction'] == $conf['serviceLinks']['login']) {
        if (!empty($_POST)) {

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
                        $name = mysqli_real_escape_string($link, $_POST["name"]);
                    }
                    // PASWORD
                    if (empty($_POST["passw"])) {
                        $errorMSG .= $lang['siteRegisterPasswErr'];
                    } else {
                        $password = mysqli_real_escape_string($link, $_POST["passw"]);
                    }

                    if ($errorMSG == '') {
                        $select = 'SELECT `UserID`, `UserEmail`, `Active`, `UserPsw` FROM `pli_users` WHERE `UserEmail` like \'' . $name . '\' LIMIT 1';
                        if ($result = mysqli_query($link, $select)) {
                            if (mysqli_num_rows($result) == 1) {
                                $users = mysqli_fetch_assoc($result);
                                if ($users['UserPsw'] == md5($password)) {
                                    if ($users['Active'] >= 0) {
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
                } else {
                    $errorMSG = $lang['siteRegisterConnErr'];
                }
            }

            // redirect to success page
            if ($success && $errorMSG == '') {
                startUserSession($users['UserID'], $users['UserPsw']);
                if (checkUserSession('start') == $users['UserID']) {
                    echo 'success';
                } else {
                    echo $lang['siteRegisterWrongErr'];
                }
            } else {
                if ($errorMSG == '') {
                    echo $lang['siteRegisterWrongErr'];
                } else {
                    echo $errorMSG;
                }
            }
        } else {
            header("Location: /" . $conf['defaultAction'] . "/" . $conf['currentLang']);
            exit();
        }
    }

    // UPDATE PROFILE
    if ($conf['currentAction'] == $conf['serviceLinks']['save-profile']) {
        if ($startID = checkUserSession('start')) {
            $success = false;
            $errorMSG = $lang['siteRegisterConnErr'];
            if (is_array($conf)) {
                $link = dbConnector($conf);
                if ($link) {
                    $errorMSG = '';

                    // gather data
                    if (empty($_POST["formid"]) && $startID == $_POST["formid"]) {
                        $errorMSG = $lang['siteRegisterWrongErr'];
                    } else {
                        $formid = mysqli_real_escape_string($link, $_POST["formid"]);
                    }
                    if (empty($_POST["active"])) {
                        $errorMSG = $lang['siteRegisterWrongErr'];
                    } else {
                        if (strtolower(mysqli_real_escape_string($link, $_POST["active"])) == 'true') {
                            $active = 1;
                        } else {
                            $active = 0;
                        }
                    }
                    /*
                     * if (empty($_POST["plan"])) {
                     * $errorMSG = $lang['siteRegisterWrongErr'];
                     * } else {
                     * $plan = mysqli_real_escape_string ($link, $_POST["plan"]);
                     * }
                     */
                    if (!empty($_POST["name"]) and strlen($_POST["name"]) < 25) {
                        $name = mysqli_real_escape_string($link, $_POST["name"]);
                    } else {
                        $name = '';
                    }

                    if (empty($_POST["mail"]) or strlen($_POST["mail"]) < 6 or strlen($_POST["mail"]) > 49) {
                        $errorMSG = $lang['siteRegisterLoginErr'];
                    } else {
                        $mail = mysqli_real_escape_string($link, $_POST["mail"]);
                    }
                    if (empty($_POST["passw"]) or strlen($_POST["passw"]) < 2 or strlen($_POST["passw"]) > 50) {
                        $errorMSG = $lang['siteRegisterWrongErr'];
                    } else {
                        $passwnew = mysqli_real_escape_string($link, $_POST["passw"]);
                    }
                    if (empty($_POST["passwconf"])) {
                        $errorMSG = $lang['siteRegisterWrongErr'];
                    } else {
                        $passwconfirm = mysqli_real_escape_string($link, $_POST["passwconf"]);
                    }
                    if (empty($_POST["uri1"])) {
                        $errorMSG = $lang['siteRegisterWrongErr'];
                    } else {
                        $uri1 = mysqli_real_escape_string($link, $_POST["uri1"]);
                    }

                    if (isset($uri1) && $uri1 == $conf['pageLinks']['profile']) {
                        if ($errorMSG == '') {
                            $select = 'SELECT `UserPsw`,`Active` FROM `pli_users` WHERE `UserID`=\'' . $formid . '\' LIMIT 1';
                            if ($result = mysqli_query($link, $select)) {
                                if (mysqli_num_rows($result) == 1) {
                                    $users = mysqli_fetch_assoc($result);
                                    if ($users['UserPsw'] == md5($passwconfirm)) {
                                        if ($users['Active'] >= 0) {
                                            if ($users['UserPsw'] == $passwnew) {
                                                $select = 'UPDATE `pli_users` SET `UserName`=\'' . $name . '\', `UserEmail`=\'' . $mail . '\', `Active`=' . $active . ', `UserPlan`=1 WHERE `UserID`=\'' . $formid . '\' AND `UserPsw`=\'' . md5($passwconfirm) . '\' LIMIT 1';
                                            } else {
                                                $select = 'UPDATE `pli_users` SET `UserName`=\'' . $name . '\', `UserPsw`=\'' . $passwnew . '\', `UserEmail`=\'' . $mail . '\', `Active`=' . $active . ', `UserPlan`=1 WHERE `UserID`=\'' . $formid . '\' AND `UserPsw`=\'' . md5($passwconfirm) . '\' LIMIT 1';
                                            }
                                            if (mysqli_query($link, $select)) {
                                                unset($select, $users);
                                                if (mysqli_affected_rows($link) != -1) {
                                                    $success = true;
                                                } else {
                                                    $errorMSG = $lang['profileUpdateErr'];
                                                }
                                            } else {
                                                $errorMSG = $lang['profileUpdateErr'];
                                            }
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


    // UPDATE STOCK INFO
    if ($conf['currentAction'] == $conf['serviceLinks']['save-stock']) {

        $data = array();
        $success = true;
        $errorMSG = $lang['siteRegisterConnErr'];

        if (!empty($_POST)) {


            $data = json_decode($_POST['json'], true);
            //Check data
            if (!is_numeric($data['Ntels']) && $data['Ntels'] < 1) $success = false;
            if ($success && strlen($data['stname']) > 24) $success = false;
            if ($success && !is_numeric($data['currencyId']) && $data['currencyId'] < 1) $success = false;
            if ($success && !is_bool($data['stactive'])) $success = false;
            if ($success && !is_numeric($data['countryId']) && $data['countryId'] < 1) $success = false;
            if ($success && strlen($data['stcity']) > 19) $success = false;
            if ($success && strlen($data['stadres']) > 49) $success = false;
            if ($success && strlen($data['stmail']) > 49) $success = false;
            if ($success && strlen($data['stmail']) > 5 && preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $data['stmail']) !== 1) $success = false;
            if ($success && strlen($data['ships']) > 240) $success = false;
            if ($success && is_bool($data['stactive'])) {
                if ($data['stactive']) {
                    $data['stactive'] = 1;
                } else {
                    $data['stactive'] = 0;
                }
            } else {
                $success = false;
            }
            if ($success) {
                for ($i = 0; $i < $data['Ntels']; $i++) {
                    if (is_bool($data['phone'][$i + $data['Ntels'] * 3]) && is_bool($data['phone'][$i + $data['Ntels'] * 4])) {
                        if ($data['phone'][$i + $data['Ntels'] * 3]) {
                            $data['phone'][$i + $data['Ntels'] * 3] = 1;
                        } else {
                            $data['phone'][$i + $data['Ntels'] * 3] = 0;
                        }
                        if ($data['phone'][$i + $data['Ntels'] * 4]) {
                            $data['phone'][$i + $data['Ntels'] * 4] = 1;
                        } else {
                            $data['phone'][$i + $data['Ntels'] * 4] = 0;
                        }
                    } else {
                        $success = false;
                        break;
                    }
                }
            }
            $startID = checkUserSession('start');
            $link = dbConnector($conf);
            if ($success && $startID > 0 && $link) {
                $success = false;
                $select = 'SELECT `pli_userstoks`.`ID` FROM `pli_userstoks`,`pli_users` WHERE `pli_users`.`UserID`=' . $startID . ' AND `pli_users`.`UserPsw` LIKE \'' . md5($data['pwd']) . '\' AND `pli_userstoks`.`UserID`=' . $startID . ' ORDER BY `pli_userstoks`.`ID` ASC';
                if ($result = mysqli_query($link, $select)) {
                    // We take ONLY THE FIRST registered Warehouse here (ORDER BY `ID`)
                    if (mysqli_num_rows($result) > 0) {
                        $res = mysqli_fetch_assoc($result);
                        mysqli_free_result($result);
                        $select = 'UPDATE `pli_userstoks` SET `StockName`=\'' . $data['stname'] . '\', `StockCountry`=' . $data['countryId'] . ', `StockCity`=\'' . $data['stcity'] . '\', `StockAdress`= \'' . $data['stadres'] . '\', `StockEmail`=\'' . $data['stmail'] . '\', `ShipsInfo`=\'' . $data['ships'] . '\', `DateModify`=\'' . date('Y-m-d H:i:s') . '\', `Currency`=' . $data['currencyId'] . ', `Active`=' . $data['stactive'] . ' WHERE `UserID`=' . $startID . ' AND `ID`=' . $res['ID'] . ' LIMIT 1';
                        if ($result = mysqli_query($link, $select)) {
                            if (mysqli_affected_rows($link) != -1) {
                                $select = 'UPDATE `pli_stockphones` SET ';
                                $select .= ' `CountryCode`=(CASE `ID` ';
                                for ($i = 0; $i < $data['Ntels']; $i++) {
                                    $select .= 'WHEN \'' . $data['phone'][$i] . '\' THEN \'' . $data['phone'][$i + $data['Ntels']] . '\' ';
                                    //$success = true;
                                }
                                $select .= ' END), ';
                                $select .= ' `Phone`=(CASE `ID` ';
                                for ($i = 0; $i < $data['Ntels']; $i++) {
                                    $select .= 'WHEN \'' . $data['phone'][$i] . '\' THEN \'' . $data['phone'][$i + $data['Ntels'] * 2] . '\' ';
                                    //$success = true;
                                }
                                $select .= ' END), ';
                                $select .= ' `IsViber`=(CASE `ID` ';
                                for ($i = 0; $i < $data['Ntels']; $i++) {
                                    $select .= 'WHEN \'' . $data['phone'][$i] . '\' THEN \'' . $data['phone'][$i + $data['Ntels'] * 3] . '\' ';
                                }
                                $select .= ' END), ';
                                $select .= ' `IsWatsapp`=(CASE `ID` ';
                                for ($i = 0; $i < $data['Ntels']; $i++) {
                                    $select .= 'WHEN \'' . $data['phone'][$i] . '\' THEN \'' . $data['phone'][$i + $data['Ntels'] * 4] . '\' ';
                                    //$success = true;
                                }
                                $select .= ' END) ';
                                $select .= ' WHERE `StockID`=' . $res['ID'] . ' AND `ID` IN (';
                                for ($i = 0; $i < $data['Ntels']; $i++) {
                                    $select .= '\'' . $data['phone'][$i] . '\',';
                                }
                                $select = substr($select, 0, -1);
                                $select .= ')';
                                if ($result = mysqli_query($link, $select)) {
                                    if (mysqli_affected_rows($link) != -1) {
                                        $success = true;
                                    }
                                }
                                unset ($i);
                            }
                        }
                        unset ($res);
                    } else {
                        $errorMSG = $lang['siteRegisterPassw2Err'];
                    }

                }
                unset($select);
                mysqli_close($link);
            }
        } else {
            $success = false;
        }

        if ($success) $errorMSG = 'success';
        echo $errorMSG;
        unset($data, $success, $errorMSG);
    }


    // ADD-PHONE
    if ($conf['currentAction'] == $conf['serviceLinks']['add-phone']) {
        $errorMSG = "Error";
        if (isset($_SESSION['start']) and !empty($_POST)) {
            if (!empty($_POST["st"]) and is_numeric($_POST["st"]) and $_POST["st"] > 0) {
                $link = dbConnector($conf);
                if ($link) {
                    $select = 'INSERT INTO `pli_stockphones` SET `StockID`=\'' . $_POST["st"] . '\', `CountryCode`=\'00\'';
                    if (mysqli_query($link, $select)) {
                        $newPhoneID = mysqli_insert_id($link);
                        if ($newPhoneID > 0) {
                            $errorMSG = 'success' . $newPhoneID;
                        }
                        unset($newPhoneID);
                    }
                    unset($select);
                    mysqli_close($link);
                }
            }
        }
        echo $errorMSG;
    }


    // DEL-PHONE
    if ($conf['currentAction'] == $conf['serviceLinks']['del-phone']) {
        $errorMSG = $lang['siteRegisterConnErr'];
        if (isset($_SESSION['start']) and !empty($_POST)) {
            if (!empty($_POST['st']) and is_numeric($_POST['st']) and $_POST['st'] > 0 and !empty($_POST['phn']) and strlen($_POST['phn']) > 1) {
                $link = dbConnector($conf);
                if ($link) {
                    $phn = substr($_POST['phn'], 17);
                    if (is_numeric($phn) && $phn > 0) {
                        $select = 'DELETE FROM `pli_stockphones` WHERE `pli_stockphones`.`ID`=' . $phn . ' AND `pli_stockphones`.`StockID`=' . $_POST['st'];
                        if (mysqli_query($link, $select)) {
                            //    $newPhoneID = mysqli_insert_id($link);
                            $errorMSG = 'success';
                        }
                        unset($select);
                    }
                    unset($phn);
                    mysqli_close($link);
                }
            }
        }
        echo $errorMSG;
    }

}

function getStockParts($stock, $start = 0, $end = 20) {
    if ($stock > 0){
		$link = dbConnector($GLOBALS['Conf']);
        if ($link) {
			$select = 'SELECT SQL_CALC_FOUND_ROWS `pli_usersparts`.`PartID`, `brands`.`BRA_BRAND`, `pli_usersparts`.`Code`, `pli_usersparts`.`Name`, `pli_usersparts`.`IsUsed`, `pli_usersparts`.`Quantity`, `pli_usersparts`.`Price`, `pli_usersparts`.`Photo`, `pli_usersparts`.`Active` FROM `pli_usersparts` LEFT JOIN `brands` ON `pli_usersparts`.`Brand`=`brands`.`BRA_ID` WHERE `pli_usersparts`.`StockID`=' . $stock . ' LIMIT ' . $start . ',' . $end;
			if ($result = mysqli_query($link, $select)) {
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						$M[] = $row;
					}
					$result = mysqli_query($link, 'SELECT FOUND_ROWS()');
					$row = mysqli_fetch_assoc($result);
					$M['NumbersOfRowsInSelect'] = $row['FOUND_ROWS()'];
					unset($row, $select);
				} else {
					$M['NumbersOfRowsInSelect'] = 0;
				}
				mysqli_free_result($result);
			}
			mysqli_close($link);
		}
    }
	if (isset($M['NumbersOfRowsInSelect']))
		return $M;
	else
		return false;
}


function TDcrossSearchList($N, $conf)
{
    $select = 'SELECT DISTINCT
	IF (ART_LOOKUP2.ARL_KIND = 3, BRANDS2.BRA_BRAND, SUPPLIERS2.SUP_BRAND) AS BRAND
	/* ,IF (ART_LOOKUP2.ARL_KIND IN (2, 3), ART_LOOKUP2.ARL_SEARCH_NUMBER, ARTICLES2.ART_ARTICLE_NR) AS NUMBER */
	,ART_LOOKUP2.ARL_SEARCH_NUMBER AS NUMBER
	,ART_LOOKUP2.ARL_KIND
	,IF (ART_LOOKUP2.ARL_KIND = 3, BRANDS2.BRA_ID, SUPPLIERS2.SUP_ID) AS BRANDID
FROM ART_LOOKUP
	 LEFT JOIN BRANDS ON BRANDS.BRA_ID = ART_LOOKUP.ARL_BRA_ID
	INNER JOIN ARTICLES ON ARTICLES.ART_ID = ART_LOOKUP.ARL_ART_ID
	INNER JOIN SUPPLIERS ON SUPPLIERS.SUP_ID = ARTICLES.ART_SUP_ID
	INNER JOIN ART_LOOKUP AS ART_LOOKUP2 FORCE KEY (PRIMARY) ON ART_LOOKUP2.ARL_ART_ID = ART_LOOKUP.ARL_ART_ID
	 LEFT JOIN BRANDS AS BRANDS2 ON BRANDS2.BRA_ID = ART_LOOKUP2.ARL_BRA_ID
	INNER JOIN ARTICLES AS ARTICLES2 ON ARTICLES2.ART_ID = ART_LOOKUP2.ARL_ART_ID
	INNER JOIN SUPPLIERS AS SUPPLIERS2 FORCE KEY (PRIMARY) ON SUPPLIERS2.SUP_ID = ARTICLES2.ART_SUP_ID
WHERE
	ART_LOOKUP.ARL_SEARCH_NUMBER = \'' . $N . '\' AND

	(ART_LOOKUP.ARL_KIND, ART_LOOKUP2.ARL_KIND) IN
		((1, 1), (1, 2), (1, 3),
         (2, 1), (2, 2), (2, 3),
		 (3, 1), (3, 2), (3, 3),
		 (4, 1))
ORDER BY BRAND, NUMBER';
    $link = dbConnector($conf);
    if ($link) {
        if ($result = mysqli_query($link, $select)) {
            if (mysqli_num_rows($result) > 0) {
                $cause = '';
                while ($Mas = mysqli_fetch_assoc($result)) {
                    $M[] = $Mas;
                    $cause .= ' (`Brand`=' . $Mas['BRANDID'] . ' AND `Code` LIKE \'' . $Mas['NUMBER'] . '\' AND `Quantity`>0 AND `Active`>0) OR';
                }
                $cause = substr($cause, 0, (strlen($cause) - 2));
                $M['cause'] = $cause;
                unset($cause);
            }
            mysqli_free_result($result);
        }
        mysqli_close($link);
    }

    if (isset($M)) {
        return $M;
    } else {
        return false;
    }
}

function priceSearchList($cause, $conf)
{
    $select = 'SELECT * FROM `pli_usersparts` WHERE ' . $cause;
    $link = dbConnector($conf);
    if ($link) {
        if ($result = mysqli_query($link, $select)) {
            if (mysqli_num_rows($result) > 0) {
                while ($Mas = mysqli_fetch_assoc($result)) {
                    $M[] = $Mas;
                }
            }
            mysqli_free_result($result);
        }
        mysqli_close($link);
    }

    if (isset($M)) {
        return $M;
    } else {
        return false;
    }
}

function CheckUs($N)
{
    $N = trim($N);
    $N = stripslashes($N);
    $N = strip_tags($N);
    // $N = strtoupper($N);
    $N = str_ireplace("COUNT", "", $N);
    $N = str_ireplace("SELECT", "", $N);
    $N = str_ireplace("UPDATE", "", $N);
    $N = str_ireplace("DELETE", "", $N);
    $N = str_ireplace("-", "", $N);
    $N = str_ireplace("%", "", $N);
    $N = str_ireplace(" ", "", $N);
    $N = str_ireplace(".", "", $N);
    $N = str_ireplace(chr(96), "", $N);
    $N = str_ireplace(",", "", $N);
    $N = str_ireplace("<", "", $N);
    $N = str_ireplace(">", "", $N);
    $N = str_ireplace(chr(92), "", $N);
    $N = str_ireplace(chr(47), "", $N);
    $N = str_ireplace(chr(95), "", $N);
    $N = str_ireplace(chr(61), "", $N);
    $N = str_ireplace(chr(27), "", $N);
    $N = str_ireplace(chr(13), "", $N);
    $N = str_ireplace("(", "", $N);
    $N = str_ireplace(")", "", $N);
    $N = str_ireplace(":", "", $N);
    $N = str_ireplace(";", "", $N);
    $N = str_ireplace("!", "", $N);
    $N = str_ireplace("=", "", $N);
    $N = str_ireplace("+", "", $N);
    $N = str_ireplace("&", "", $N);
    $N = str_ireplace("?", "", $N);
    $N = str_ireplace(chr(34), "", $N);
    $N = str_ireplace(chr(39), "", $N);
    $N = str_ireplace("А", "A", $N);
    $N = str_ireplace("а", "A", $N);
    $N = str_ireplace("В", "B", $N);
    $N = str_ireplace("в", "B", $N);
    $N = str_ireplace("С", "C", $N);
    $N = str_ireplace("с", "C", $N);
    $N = str_ireplace("М", "M", $N);
    $N = str_ireplace("м", "M", $N);
    $N = str_ireplace("Е", "E", $N);
    $N = str_ireplace("е", "E", $N);
    $N = str_ireplace("Р", "P", $N);
    $N = str_ireplace("р", "P", $N);
    $N = str_ireplace("О", "O", $N);
    $N = str_ireplace("о", "O", $N);
    $N = str_ireplace("Н", "H", $N);
    $N = str_ireplace("н", "H", $N);
    $N = str_ireplace("к", "K", $N);
    $N = str_ireplace("К", "K", $N);
    return $N;
}