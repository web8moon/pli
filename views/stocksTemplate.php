
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


	<br> <h1> <?php echo isset($siteTabWarehouse) ? $siteTabWarehouse : 'Stocks'; ?></h1>

	
	
</div>	
    <?php $content = ob_get_clean();} ?>

<?php require 'baseTemplate.php'; ?>


