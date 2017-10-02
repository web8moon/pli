<?php
$errMsg = isset($profileConnErr) ? $profileConnErr : 'Error';

if (isset($_SESSION['start'])) {
    if (!isset($content)) {
        ob_start(); ?>
        <h1>Профиль</h1>
<br>
		<?php
		$startUserIDstr = strpos($_SESSION['start'], md5($_SERVER['HTTP_USER_AGENT']+date("z")));
		if ($startUserIDstr > 0) {

			$UserID = substr($_SESSION['start'], 0, $startUserIDstr);
			$UserPassw = substr($_SESSION['start'], (strlen($UserID) + strlen(md5($_SERVER['HTTP_USER_AGENT']+date("z")))));
			unset($startUserIDstr);
			$link = dbConnector(compact('dbhost', 'dbname', 'dbuser', 'dbpass'));
			if ($link) {
				$select = 'SELECT `UserName`, `UserEmail`, `Active`, `UserPlan` FROM `users` WHERE `UserID`=' . $UserID . ' AND `UserPsw` LIKE \'' . $UserPassw . '\' LIMIT 1';
				if($result = mysqli_query($link, $select)) {
					if (mysqli_num_rows($result) == 1) {
						$user = mysqli_fetch_assoc($result);
						mysqli_free_result($result);
						$errMsg = '';
					
			?>


			<div class="card text-center">
  
				<!-- UPPER TABS -->
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a class="nav-link active" href="#">Профиль</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Склады</a>
						</li>
					</ul>
				</div>
  
  
				<div class="card-block">
					<h4 class="card-title">Special title treatment</h4>
    
	
					<!-- FIRST ROW -->
					<div class="form-group row">
<div class="col col-4">


					
							
							
							
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
    <div class="input-group-addon">User Card ID:</div>
    <input type="text" class="form-control" disabled value="<?php echo $UserID; ?>">
  </div>
</div>
							
						<div class="col">

							<div class="input-group">
								<span class="input-group-addon">
									<input checked type="checkbox" aria-label="Checkbox for following text input" id="accountactivechk">
								</span>
								<input disabled value="<?php echo isset($siteSelectorAccountActive) ? $siteSelectorAccountActive : 'Active'; ?>" type="text" id="accountactivelbl"  aria-label="Text input with checkbox">
							</div>

						</div>
					</div>
	
	
					<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
					<a href="#" class="btn btn-primary">Go somewhere</a>
				</div>
			</div>

		
		
		
		
			<?php
					}
				}
				mysqli_close($link);
			}
		}
		$content = ob_get_clean();
    }

	require 'baseTemplate.php';
}
if($errMsg != '') {
	?>
	<br>
	<div class="container">
	<div class="alert alert-danger" role="alert">
		<?php echo isset($profileConnErr) ? $profileConnErr : 'Error'; ?>
	</div></div>
	<br>
	<?php
}
 ?>
