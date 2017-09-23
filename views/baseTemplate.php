<?php
//if (isset($_REQUEST[session_name()])) session_start();

if (isset($allowLanguages) and is_array($allowLanguages)) {

?>
<!DOCTYPE HTML>
<html lang="ru-RU">
    <head>
        <title><?php echo isset($siteTitle) ? $siteTitle : ''; ?></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/views/baseCSS.css" >

<!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script type="text/javascript" src="../functions/jquery-1.11.2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>	

	</head>
    <body>
    <header>
        <div class="container">
            <a href="/" class="logo"><?php echo isset($siteLogo) ? $siteLogo : ''; ?></a>
            <nav>
			<div class="btn-group">
                <ul class="nav nav-tabs">
                    <li><a href="<?php echo isset($aboutLink)?'/'.$aboutLink.'/':'/'; echo isset($currentLang)?$currentLang:'/';?>"><?php echo isset($siteMenuAbout) ? $siteMenuAbout : ''; ?></a></li>
                    <li><a href=""><?php echo isset($siteMenuContact) ? $siteMenuContact : ''; ?></a></li>
					<?php if (isset($_SESSION['start'])) { ?>
						<li><a href="/logout/<?php echo isset($currentLang)?$currentLang:'/';?>"><?php echo isset($siteMenuLogout) ? $siteMenuLogout : ''; ?></a></li>
					<?php } else { ?>
                    <li><a href="<?php echo isset($loginLink)?'/'.$loginLink.'/':'/'; echo isset($currentLang)?$currentLang:'/';?>">Войти</a></li>
					<li><a href="" class="loginbtn" data-toggle="modal"><?php echo isset($siteMenuLogin) ? $siteMenuLogin : ''; ?></a></li>
					<?php } ?>
                
				
					
					<li class="dropdown open">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo isset($currentLang)?$currentLang:''; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php
							sort($allowLanguages);
							foreach( $allowLanguages as $l ) {
								echo '<li><a href="/' . $currentAction . '/' . $l . '"> ' . $l . ' </a></li>';
							}
							?>
      
						</ul>
					</li>
						
				</ul>
					

			</div>	
            </nav>
        </div>
    </header>
        <div class="main">
            <div class="container">
	            <?php if(isset($content)){echo $content; } else { ?>
	                Default content
	            <?php }?>

            </div>

        </div>
	<div class="sidebar">
        <div class="container">
	        <?php if(isset($sidebar)){echo $sidebar; } else { ?>
	            Default sidebar
	        <?php }?>
        </div>
	</div>
    <footer><div class="container"></div></footer>




<?php if (!isset($_SESSION['start'])) { ?>

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

	
<form role="form" id="contactForm" data-toggle="validator" class="shake">
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="name" class="h4"><?php echo $siteLoginNameLbl; ?></label>
                <input type="text" class="form-control" id="name" placeholder="Enter name" required data-error="NEW ERROR MESSAGE">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-sm-6">
                <label for="password" class="h4"><?php echo $siteLoginPasswLbl; ?></label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
		<input type="hidden" id="uri1" value="<?php echo $currentAction; ?>">
		<input type="hidden" id="uri2" value="<?php echo $currentLang; ?>">
        <button type="submit" id="form-submit" class="btn btn-success btn-lg pull-right "><?php echo isset($siteLoginLoginBtn) ? $siteLoginLoginBtn : ''; ?></button>
        <div id="msgSubmit" class="h3 text-center hidden"></div>
        <div class="clearfix"></div>
    </form>
		
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo isset($siteLoginCloseBtn) ? $siteLoginCloseBtn : ''; ?></button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
    </body>

	
<script type="text/javascript" src="../functions/validator.min.js"></script>
<script type="text/javascript" src="../functions/form-scripts.js"></script>

</html>
<?php
}
