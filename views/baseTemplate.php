<!DOCTYPE HTML>
<html lang="ru-RU">
    <head>
        <title><?php echo isset($defaultTitle) ? $defaultTitle : ''; ?></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/views/baseCSS.css" >
		<link rel="stylesheet" href="/views/loginForm.css" >

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>	


<script type="text/javascript">
$(document).ready(function(){
  //при нажатию на любую кнопку, имеющую класс .btn
  $(".login").click(function() {

	//открыть модальное окно с id="myModal"
	$("#myModal").modal('show');
  });
});
</script>	
	</head>
    <body>
    <header>
        <div class="container">
            <a href="/" class="logo">LOGO</a>
            <nav>
                <ul>
                    <li><a href="<?php echo isset($aboutLink)?'/'.$aboutLink.'/':'/'; echo isset($defaultLang)?$defaultLang:'/';?>">О платформе</a></li>
                    <li><a href="">Написать разработчикам</a></li>
                    <li><a href="<?php echo isset($loginLink)?'/'.$loginLink.'/':'/'; echo isset($defaultLang)?$defaultLang:'/';?>">Войти</a></li>
					<li><a href="#" class="login" data-toggle="modal">Открыть модальное окно</a>  </li>
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





<div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Авторизация на Parts-Link</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">

	
<form>
  <div class="form-group">
    <label for="exampleInputEmail1">Login</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
		
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>


	


</html>