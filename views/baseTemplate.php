<!DOCTYPE HTML>
<html lang="ru-RU">
    <head>
        <title><?php echo isset($defaultTitle) ? $defaultTitle : ''; ?></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/views/baseCSS.css" >
        <script type="text/javascript" src="/functions/jquery-2.0.2.min.js"></script>
    </head>
    <body>
    <header>
        <div class="container">
            <a href="/" class="logo">LOGO</a>
            <nav>
                <ul>
                    <li><a href="<?php echo isset($aboutLink)?'/'.$aboutLink.'/':'/'; echo isset($defaultLang)?$defaultLang:'/';?>"">О платформе</a></li>
                    <li><a href="">Написать разработчикам</a></li>
                    <li><a href="<?php echo isset($loginLink)?'/'.$loginLink.'/':'/'; echo isset($defaultLang)?$defaultLang:'/';?>">Войти</a></li>

                </ul>
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

    </body>
</html>