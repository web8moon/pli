<?php if (!isset($content)) {
    ob_start(); ?>
    <br>
    <div class="card text-center">


        <!-- UPPER TABS -->
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link"
                       href="/<?php echo isset($pageLinks['profile']) ? $pageLinks['profile'] : 'profile'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profileAccountMenu) ? $profileAccountMenu : 'Account'; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active"
                       href="/<?php echo isset($pageLinks['stocks']) ? $pageLinks['stocks'] : 'stocks'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profileStocksMenu) ? $profileStocksMenu : 'Stocks'; ?></a>
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
                            <label for="user-stock-name"
                                   class="col-sm-2 col-form-label"><?php echo isset($stockName) ? $stockName : 'Name'; ?></label>
                            <div class="col col-3">
                                <input class="form-control" type="text"
                                       value="<?php echo $userParams[$userParams['stokNumbers']]['StockName']; ?>"
                                       id="user-stock-name">
                            </div>


                            <div class="col">
                                <div class="input-group">

                                    <label for="user-stock-country" class="col-sm-8 col-form-label"><?php echo isset($stockCurrency) ? $stockCurrency : 'Currency'; ?></label>

                                    <select id="user-stock-country" class="form-control col-4">
                                        <option>EUR</option>
                                        <option>Uhy</option>
                                        <option>3</option>
                                    </select>


                                </div>
                            </div>


                            <div class="col-3">
                                <div class="input-group">
					<span class="input-group-addon">
						<input <?php echo ($userParams[$userParams['stokNumbers']]['Active'] >= 1) ? 'checked' : ''; ?> type="checkbox" aria-label="Check to activate your account" id="accountactivechk">
					</span>
                                    <input disabled value="<?php echo isset($stockSelectorStockActive) ? $stockSelectorStockActive : 'Active'; ?>"
                                           type="text" id="accountactivelbl" aria-label="Check to activate your stock"
                                           class="form-control <?php echo ($userParams[$userParams['stokNumbers']]['Active'] < 1) ? 'btn-danger' : ''; ?> ">
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

                            <div class="col">
                                <div class="input-group">

                                    <label for="user-stock-country"
                                           class="col-sm-4 col-form-label"><?php echo isset($stockCountry) ? $stockCountry : 'Country'; ?></label>

                                    <select class="form-control" id="user-stock-country">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>


                                </div>
                            </div>

                            <label for="user-stock-name"
                                   class="col-sm-2 col-form-label"><?php echo isset($stockCity) ? $stockCity : 'City'; ?></label>
                            <div class="col col-4">
                                <input class="form-control" type="text"
                                       value="<?php echo $userParams[$userParams['stokNumbers']]['StockCity']; ?>"
                                       id="user-stock-name">
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="user-stock-name"
                                   class="col-sm-2 col-form-label"><?php echo isset($stockAdress) ? $stockAdress : 'Adress'; ?></label>
                            <div class="col">
                                <input class="form-control" type="text"
                                       value="<?php echo $userParams[$userParams['stokNumbers']]['StockAdress']; ?>"
                                       id="user-stock-name">
                            </div>

                        </div>
                    </div>
                </div>
                <!--  /SECOND CARD -->
                <br>
                <!--  THIRD CARD -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($pr) ? $pr : 'KOHTAK'; ?></h6>
                        <div class="form-group row">

                            <label for="user-stock-mail"
                                   class="col-sm-4 col-form-label"><?php echo isset($stockOrdersEmail) ? $stockOrdersEmail : 'E-mail'; ?></label>
                            <div class="col col-5">
                                <input class="form-control" type="email"
                                       value="<?php echo $userParams[$userParams['stokNumbers']]['StockEmail']; ?>"
                                       id="user-stock-mail">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="user-stock-phone"
                                   class="col-sm-3 col-form-label"><?php echo isset($stockOrdersEmail) ? $stockOrdersEmail : 'E-mail'; ?></label>
                            <div class="col col-1">
                                <input class="form-control" type="text"
                                       value="<?php echo $userParams[$userParams['stokNumbers']]['StockEmail']; ?>"
                                       id="user-stock-country-code">
                            </div>

                            <div class="col col-3">
                                <input class="form-control" type="tel"
                                       value="<?php echo $userParams[$userParams['stokNumbers']]['StockEmail']; ?>"
                                       id="user-stock-phone">
                            </div>

                            <div class="form-check">
                                <label class="form-check-label">

                            <input type="checkbox" class="form-check-input" id="has-viber">
                                    <img src="../views/icon_viber.png" alt="Viber" width="22" height="22">
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">

                                    <input type="checkbox" class="form-check-input" id="has-whatsapp">
                                    <img src="../views/icon_whatsapp.png" alt="Whatsapp" width="24" height="24">
                                </label>
                            </div>
                            <button type="button" class="btn btn-outline-primary">Add</button>
                        </div>

                        <div class="form-group row">
                            <label for="user-stock-ships"
                                   class="col-sm-2 col-form-label"><?php echo isset($stockAdress) ? $stockAdress : 'ShipsInfo'; ?></label>
                            <div class="col">
                                <input class="form-control" type="text"
                                       value="<?php echo $userParams[$userParams['stokNumbers']]['ShipsInfo']; ?>"
                                       id="user-stock-ships">
                            </div>

                        </div>
                    </div>
                </div>
                <!--  /THIRD CARD -->
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
    <?php $content = ob_get_clean();
} ?>

<?php require 'baseTemplate.php'; ?>


