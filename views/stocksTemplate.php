
<?php if(!isset($content)){ ob_start(); ?>

<div class="card text-center">


    <!-- UPPER TABS -->
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/<?php echo isset($pageLinks['profile']) ? $pageLinks['profile'] : 'profile';?>/<?php echo isset($currentLang) ? $currentLang: '/';?>"><?php echo isset($profileAccountMenu) ? $profileAccountMenu : 'Account'; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/<?php echo isset($pageLinks['stocks']) ? $pageLinks['stocks'] : 'stocks';?>/<?php echo isset($currentLang) ? $currentLang: '/';?>"><?php echo isset($profileStocksMenu) ? $profileStocksMenu : 'Stocks'; ?></a>
            </li>
        </ul>
    </div>

<div class="card-body">
	<h1> <?php echo isset($siteTabWarehouse) ? $siteTabWarehouse : 'Stocks'; ?></h1>
	<br>
<?php
	$userParams = array();
	$userParams = getUserParams();
	
	// var_dump ($userParams);
	if ($userParams['stokNumbers'] > 1 AND $userParams['User']['UserPlan'] == 1) {
		$userParams['stokNumbers'] = 1;
	?>
	<br>
    <div class="container">
        <div class="alert alert-warning" role="alert">
            <?php echo isset($stockMultiError) ? $stockMultiError : 'Error'; ?>
        </div>
    </div>
    <br>
	<?php
	}
	if ($userParams['User']['Active'] != 1) {
	?>
	<br>
    <div class="container">
        <div class="alert alert-warning" role="alert">
            <?php echo isset($profileActiveWarning) ? $profileActiveWarning : 'Warning'; ?>
        </div>
    </div>
    <br>
	<?php
	}
	$errMsg = isset($profileConnErr) ? $profileConnErr : 'Error';
	if (checkUserSession('start')) {
		$errMsg = '';
?>		
		<!--  FIRST CARD -->
		<div class="card">
           <div class="card-body">
              <!-- <h6 class="card-subtitle mb-2 text-muted"><?php //echo isset($pr) ? $pr : 'СКлад'; ?></h6> -->
			<div class="form-group row">
			   <label for="user-stock-name" class="col-sm-2 col-form-label"><?php echo isset($stockName) ? $stockName : 'Name'; ?></label>
              <div class="col col-4">
                  <input class="form-control" type="text" value="<?php echo $userParams[$userParams['stokNumbers']]['StockName']; ?>" id="user-stock-name">
              </div>
			  <div class="col-5">
			  <div class="input-group">
					<span class="input-group-addon">
						<input <?php echo ($userParams[$userParams['stokNumbers']]['Active'] >= 1) ? 'checked' : ''; ?> type="checkbox" aria-label="Check to activate your account" id="accountactivechk">
					</span>
                     <input disabled value="<?php echo isset($siteSelectorAccountActive) ? $siteSelectorAccountActive : 'Active'; ?>" type="text" id="accountactivelbl" aria-label="Check to activate your account" class="form-control <?php echo ($user['Active'] < 1) ? 'btn-danger' : ''; ?> ">
             </div>
			  </div>
           </div>
			</div>
		</div>
		<!--  /FIRST CARD -->
		<br>
		<!--  SECOND CARD -->
		<div class="card">
           <div class="card-body">
              <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($pr) ? $pr : 'РАСПОЛО'; ?></h6>
			<div class="form-group row">
			  
			  <div class="col-5">
			  <div class="input-group">
				
				<label for="user-stock-country" class="col-sm-2 col-form-label"><?php echo isset($stockCity) ? $stockCity : 'Country'; ?></label>
              <div class="col col-6">
              
    <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>

              </div>
			  
			 </div>
			  </div>			   
			   
			   <label for="user-stock-name" class="col-sm-2 col-form-label"><?php echo isset($stockCity) ? $stockCity : 'City'; ?></label>
              <div class="col col-4">
                  <input class="form-control" type="text" value="<?php echo $userParams[$userParams['stokNumbers']]['StockCity']; ?>" id="user-stock-name">
              </div>

           </div>
		   <div class="form-group row">
		   <label for="user-stock-name" class="col-sm-2 col-form-label"><?php echo isset($stockAdress) ? $stockAdress : 'Adress'; ?></label>
              <div class="col">
                  <input class="form-control" type="text" value="<?php echo $userParams[$userParams['stokNumbers']]['StockAdress']; ?>" id="user-stock-name">
              </div>
			  
			</div>
			</div>
		</div>
		<!--  /SECOND CARD -->
		<br>
		
		
<?php
	}
	
	if ($errMsg != '') {
    ?>
    <br>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <?php echo $errMsg; ?>
        </div>
    </div>
    <br>
    <?php
}

	
?>	
</div>
</div>
    <?php $content = ob_get_clean();} ?>

<?php require 'baseTemplate.php'; ?>


