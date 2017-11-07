<?php
//if (isset($_REQUEST[session_name()])) session_start();
if (isset($allowLanguages) and is_array($allowLanguages)) {
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title><?php echo isset($siteTitle) ? $siteTitle : ''; ?></title>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="/views/bootstrap4b.min.css">


    </head>
    <body>
    <header>

        <div class="container">
            <!-- <nav class="navbar navbar-toggleable-md navbar-light"> -->
            <nav class="navbar navbar-dark bg-dark navbar-toggleable-md">


                <div class="navbar-header">
                    <a class="navbar-brand" href="/"><?php echo isset($siteLogo) ? $siteLogo : ''; ?></a>
                </div>
                <!-- <div class="nav justify-content-end"> -->
                <div class="nav justify-content-end text-right">
                    <li class="nav-item"><a class="nav-link"
                                            href="<?php echo isset($pageLinks['about']) ? '/' . $pageLinks['about'] . '/' : '/';
                                            echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($siteMenuAbout) ? $siteMenuAbout : ''; ?></a>
                    </li>
                    <li class="nav-item"><a class="nav-link"
                                            href="<?php echo isset($siteMenuContact) ? '/' . $siteMenuContact . '/' : '/';
                                            echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($siteMenuContact) ? $siteMenuContact : ''; ?></a>
                    </li>
                    <?php if (isset($_SESSION['start'])) { ?>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown"
                               href="#"><?php echo isset($siteMenuUser) ? $siteMenuUser : 'User'; ?> </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php
                                echo '<a class="dropdown-item" href="/' . $pageLinks['profile'] . '/' . $currentLang . '"> ' . $siteTabProfile . ' </a>';
                                ?>
                                <a class="dropdown-item"
                                   href="/<?php echo isset($serviceLinks['logout']) ? $serviceLinks['logout'] : 'logout'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($siteMenuLogout) ? $siteMenuLogout : ''; ?></a>
                            </div>
                        </li>
                    <?php } else { ?>

                        <li class="nav-item"><a class="nav-link" href="" id="loginbtn"
                                                data-toggle="modal"><?php echo isset($siteMenuLogin) ? $siteMenuLogin : ''; ?></a>
                        </li>
                    <?php } ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"
                           href="#"><?php echo isset($currentLang) ? $currentLang : ''; ?> <span
                                    class="caret"></span></a>
                        <div class="dropdown-menu">
                            <?php
                            sort($allowLanguages);
                            foreach ($allowLanguages as $l) {
                                echo '<a class="dropdown-item" href="/' . $currentAction . '/' . $l . '"> ' . $l . ' </a>';
                            }
                            ?>

                        </div>
                    </li>

                </div>


            </nav>
        </div>


        <!-- </div> -->
    </header>
    <div class="main">
        <div class="container">
            <?php if (isset($content)) {
                echo $content;
            } else { ?>
                Default content
            <?php } ?>

        </div>

    </div>
    <div class="sidebar">
        <div class="container">
            <?php if (isset($sidebar)) {
                echo $sidebar;
            } else { ?>
                Default sidebar
            <?php } ?>
        </div>
    </div>
    <footer>
        <div class="container">
           
			<nav class="navbar navbar-dark bg-dark">
			 <div class="navbar-header">
				<span class="navbar-text">
				Made with<img src="../views/heart.gif" width="22" height="22" alt="love" style="margin-left:5px; margin-right:5px;">to our users!
				</span>
				
                <?php 
				/*
				echo '<br>Current Action:' . $currentAction . ' / Lang:' . $currentLang . '<br>';
                echo 'QueryString:' . $_SERVER['QUERY_STRING'] . '<br>';
                echo 'HTTP_HOST:' . $_SERVER['HTTP_HOST'] . '<br>';
                echo 'REQUEST_URI:' . $_SERVER['REQUEST_URI'] . '<br>';
                echo 'SCRIPT_NAME:' . $_SERVER['SCRIPT_NAME'] . '<br>';
                echo '__FILE__:' . __FILE__ . '<br>';
                echo '__FUNCTION__:' . __FUNCTION__ . '<br>';
                echo '__LINE__:' . __LINE__ . '<br>';
				echo '$_SESSION[start]:' . $_SESSION['start'] . '<br>';
*/
                ?>
</div>           
		   </nav>
			
        </div>
    </footer>


    <?php if (!isset($_SESSION['start'])) { ?>
        <!-- Логин -->
        <div id="loginModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><?php echo isset($siteLoginTitle) ? $siteLoginTitle : ''; ?></h4>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">

                        <form role="form" id="loginForm" data-toggle="validator" class="shake">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="name" class="h4"><?php echo $siteLoginNameLbl; ?></label>
                                    <input type="email" class="form-control" id="name"
                                           placeholder="<?php echo isset($siteRegisterLoginPlace) ? $siteRegisterLoginPlace : ''; ?>"
                                           required
                                           data-error="<?php echo isset($siteRegisterLoginErr) ? $siteRegisterLoginErr : ''; ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="password" class="h4"><?php echo $siteLoginPasswLbl; ?></label>
                                    <input type="password" class="form-control" id="password"
                                           placeholder="<?php echo isset($siteRegisterPasswPlace) ? $siteRegisterPasswPlace : ''; ?>"
                                           required
                                           data-error="<?php echo isset($siteRegisterPasswErr) ? $siteRegisterPasswErr : ''; ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <input type="hidden" id="uri1" value="<?php echo $currentAction; ?>">
                            <input type="hidden" id="uri2" value="<?php echo $currentLang; ?>">
                            <button type="submit" id="form-submit"
                                    class="btn btn-success btn-lg pull-right "><?php echo isset($siteLoginLoginBtn) ? $siteLoginLoginBtn : 'Login'; ?></button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </form>

                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button type="button" class="btn"
                                data-dismiss="modal"><?php echo isset($siteLoginCloseBtn) ? $siteLoginCloseBtn : 'Close'; ?></button>
                        <button type="button" class="btn btn-warning"
                                id="registerme"><?php echo isset($siteLoginRegisterBtn) ? $siteLoginRegisterBtn : 'Register'; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Регистрация -->
        <div id="registerModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><?php echo isset($siteRegisterTitle) ? $siteRegisterTitle : ''; ?></h4>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">


                        <form role="form" id="registerForm" data-toggle="validator" class="shake">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="regname" class="h4"><?php echo $siteLoginNameLbl; ?></label>
                                    <input type="email" class="form-control" id="regname"
                                           placeholder="<?php echo isset($siteRegisterLoginPlace) ? $siteRegisterLoginPlace : ''; ?>"
                                           required
                                           data-error="<?php echo isset($siteRegisterLoginErr) ? $siteRegisterLoginErr : ''; ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="regpassword" class="h4"><?php echo $siteLoginPasswLbl; ?></label>
                                    <input type="password" class="form-control" id="regpassword"
                                           placeholder="<?php echo isset($siteRegisterPasswPlace) ? $siteRegisterPasswPlace : ''; ?>"
                                           required
                                           data-error="<?php echo isset($siteRegisterPasswErr) ? $siteRegisterPasswErr : ''; ?>">


                                    <label for="regpassword2" class="h4"><?php echo $siteLoginPassw2Lbl; ?></label>
                                    <input type="password" class="form-control" id="regpassword2"
                                           placeholder="<?php echo isset($siteLoginPassw2Lbl) ? $siteLoginPassw2Lbl : ''; ?>"
                                           required
                                           data-error="<?php echo isset($siteRegisterPasswErr) ? $siteRegisterPasswErr : ''; ?>">


                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <input type="hidden" id="uri1" value="<?php echo $currentAction; ?>">
                            <input type="hidden" id="uri2" value="<?php echo $currentLang; ?>">
                            <button type="submit" id="reg-form-submit"
                                    class="btn btn-success btn-lg pull-right "><?php echo isset($siteRegisterRegisterBtn) ? $siteRegisterRegisterBtn : 'Register'; ?></button>
                            <div id="regSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </form>

                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button type="button" class="btn"
                                data-dismiss="modal"><?php echo isset($siteLoginCloseBtn) ? $siteLoginCloseBtn : 'Close'; ?></button>
                        <button type="button" class="btn btn-info"
                                id="loginme"><?php echo isset($siteRegisterLoginBtn) ? $siteRegisterLoginBtn : 'Login'; ?></button>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>


    </body>

    <script type="text/javascript" src="../functions/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="../functions/popper4a.min.js"></script>
    <script type="text/javascript" src="../functions/bootstrap4b.min.js"></script>
    <script type="text/javascript" src="../functions/validator.min.js"></script>
    <script type="text/javascript" src="../functions/search-script.js"></script>
    <?php 
	if (!isset($_SESSION['start'])) { ?>
        <script type="text/javascript" src="../functions/form-scripts.js"></script>
    <?php } else {
			if ( $currentAction == $pageLinks['profile'] ) {?>
				<script type="text/javascript" src="../functions/profile-script.js"></script>
    <?php 
			}
			if ( $currentAction == $pageLinks['stocks'] ) {?>
				<script type="text/javascript" src="../functions/stocks-script.js"></script>
    <?php 
			}
			
			
	} ?>


    </html>
    <?php
}
