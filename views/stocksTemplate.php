<?php

if (!isset($content)) {
    ob_start();
    $errMsg = isset($profileConnErr) ? $profileConnErr : 'Error';
    ?>
    <br>
    <div class="card text-center">


        <!-- UPPER TABS -->
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="/<?php echo isset($pageLinks['profile']) ? $pageLinks['profile'] : 'welcome'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profileAccountMenu) ? $profileAccountMenu : 'Account'; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/<?php echo isset($pageLinks['stocks']) ? $pageLinks['stocks'] : 'welcome'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profileStocksMenu) ? $profileStocksMenu : 'Stocks'; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/<?php echo isset($pageLinks['parts']) ? $pageLinks['parts'] : 'welcome'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profilePartsMenu) ? $profilePartsMenu : 'Parts'; ?></a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <h1> <?php echo isset($siteTabWarehouse) ? $siteTabWarehouse : 'Stocks'; ?></h1>
            <br>
            <?php
            if (checkUserSession('start')) {
            $userParams = array();
            $userParams = getUserParams();

             //echo '<pre>';
             //var_dump($userParams);
             //echo '</pre>';
			 $userParams['stokNumbers'] = 0;
            if (count($userParams['Stock']) > 1 and $userParams['User']['UserPlan'] == 1) {
                // $userParams['stokNumbers'] = 0;
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

            if ($countries = getTableList('pli_countries') and $userParams and $currency = getTableList('pli_currencies')) {
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
                                       value="<?php echo $userParams['Stock'][$userParams['stokNumbers']]['StockName']; ?>"
                                       id="user-stock-name">
                            </div>


                            <div class="col">
                                <div class="input-group">

                                    <label for="user-stock-currency"
                                           class="col-sm-8 col-form-label"><?php echo isset($stockCurrency) ? $stockCurrency : 'Currency'; ?></label>

                                    <select id="user-stock-currency" class="form-control col-4">


                                        <?php

                                        foreach ($currency as $c) {
                                            echo '<option value="' . $c['ID'] . '"';
                                            if ($userParams['Stock'][$userParams['stokNumbers']]['Currency'] == $c['ID'])
                                                echo ' selected';
                                            echo '>' . $c['Name'] . '</option>';
                                        }


                                        ?>
                                    </select>


                                </div>
                            </div>


                            <div class="col-3">
                                <div class="input-group">
							<span class="input-group-addon"> <input
                                    <?php echo ($userParams['Stock'][$userParams['stokNumbers']]['Active'] >= 1) ? 'checked' : ''; ?>
                                        type="checkbox" aria-label="Check to activate your stock"
                                        id="stock-active-chk">
							</span> <input disabled
                                           value="<?php echo isset($stockSelectorStockActive) ? $stockSelectorStockActive : 'Active'; ?>"
                                           type="text" id="stock-active-lbl"
                                           aria-label="Check to activate your stock"
                                           class="form-control <?php echo ($userParams['Stock'][$userParams['stokNumbers']]['Active'] < 1) ? 'btn-danger' : ''; ?> ">
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
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($stockLocation) ? $stockLocation : 'Location'; ?></h6>
                        <div class="form-group row">

                            <div class="col">
                                <div class="input-group">

                                    <label for="user-stock-country"
                                           class="col-sm-4 col-form-label"><?php echo isset($stockCountry) ? $stockCountry : 'Country'; ?></label>

                                    <select class="form-control" id="user-stock-country">
                                        <?php

                                        foreach ($countries as $c) {
                                            echo '<option value="' . $c['ID'] . '"';
                                            if ($userParams['Stock'][$userParams['stokNumbers']]['StockCountry'] == $c['ID'])
                                                echo ' selected';
                                            echo '>' . $c['Name'] . '</option>';
                                        }


                                        ?>

                                    </select>


                                </div>
                            </div>

                            <label for="user-stock-city"
                                   class="col-sm-2 col-form-label"><?php echo isset($stockCity) ? $stockCity : 'City'; ?></label>
                            <div class="col col-4">
                                <input class="form-control" type="text"
                                       value="<?php echo $userParams['Stock'][$userParams['stokNumbers']]['StockCity']; ?>"
                                       id="user-stock-city">
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="user-stock-adress"
                                   class="col-sm-2 col-form-label"><?php echo isset($stockAdress) ? $stockAdress : 'Adress'; ?></label>
                            <div class="col">
                                <input class="form-control" type="text"
                                       value="<?php echo $userParams['Stock'][$userParams['stokNumbers']]['StockAdress']; ?>"
                                       id="user-stock-adress">
                            </div>

                        </div>
                    </div>
                </div>
                <!--  /SECOND CARD -->
                <br>
                <!--  THIRD CARD -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($stockConacts) ? $stockConacts : 'Contacts'; ?></h6>
                        <div class="form-group row">

                            <label for="user-stock-mail"
                                   class="col-sm-4 col-form-label"><?php echo isset($stockOrdersEmail) ? $stockOrdersEmail : 'E-mail'; ?></label>
                            <div class="col col-5">
                                <input class="form-control" type="email"
                                       value="<?php echo $userParams['Stock'][$userParams['stokNumbers']]['StockEmail']; ?>"
                                       id="user-stock-mail">
                            </div>
                        </div>

                        <div id="three">
                            <?php

                            for ($i = 0; $i < count($userParams['Phone']); $i++) {
                                if ($userParams['Stock'][$userParams['stokNumbers']]['ID'] == $userParams['Phone'][$i]['StockID']) {
                                    ?>

                                    <div class="form-group row">

                                        <label for="user-stock-phone" class="col-sm-3 col-form-label"
                                               id="phLbl"><?php echo isset($stockPhone) ? $stockPhone : 'Phone'; ?></label>
                                        <div class="col col-1">
                                            <input class="form-control" type="text"
                                                   value="<?php echo $userParams['Phone'][$i]['CountryCode']; ?>"
                                                   id="user-phone-country-code-<?php echo $userParams['Phone'][$i]['ID']; ?>"
                                                   data-toggle="tooltip" data-placement="bottom"
                                                   title="<?php echo isset($stockCountryCode) ? $stockCountryCode : 'CountryCode'; ?>">
                                        </div>

                                        <div class="col col-3">
                                            <input class="form-control" type="tel"
                                                   value="<?php echo $userParams['Phone'][$i]['Phone']; ?>"
                                                   id="user-stock-phone-<?php echo $userParams['Phone'][$i]['ID']; ?>">
                                        </div>

                                        <div class="form-check">
                                            <label class="form-check-label"> <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="has-viber-<?php echo $userParams['Phone'][$i]['ID']; ?>"
                                                                                    data-toggle="tooltip" <?php echo $userParams['Phone'][$i]['IsViber'] == 1 ? 'checked' : ''; ?>
                                                                                    data-placement="bottom"
                                                                                    title="<?php echo isset($stockPhoneViberChk) ? $stockPhoneViberChk : 'HasViber'; ?>">
                                                <img src="../views/icon_viber.png" alt="Viber" width="22" height="22">
                                            </label>
                                        </div>
                                        &nbsp;
                                        <div class="form-check">
                                            <label class="form-check-label"> <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="has-whatsapp-<?php echo $userParams['Phone'][$i]['ID']; ?>"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="bottom" <?php echo $userParams['Phone'][$i]['IsWatsapp'] == 1 ? 'checked' : ''; ?>
                                                                                    title="<?php echo isset($stockPhoneWhatsappChk) ? $stockPhoneWhatsappChk : 'HasWhatsapp'; ?>">
                                                <img src="../views/icon_whatsapp.png" alt="Whatsapp" width="24"
                                                     height="24">
                                            </label>
                                        </div>
                                        <?php if (count($userParams['Phone']) > 1) { ?>
                                            &nbsp;
                                            <div class="form-check">
                                                <label onclick="delPhoneN('del-phone-number-<?php echo $userParams['Phone'][$i]['ID']; ?>')"
                                                       class="form-check-label del-phone-number"
                                                       id="del-phone-number-<?php echo $userParams['Phone'][$i]['ID']; ?>">
                                                    <img src="../views/del.bmp" alt="Del" width="22" height="22">
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                        <button type="button" class="btn btn-outline-primary"
                                id="add-phone-number"><?php echo isset($stockPhoneAdd) ? $stockPhoneAdd : 'Add'; ?>
                            <span style="display:none;" class="badge badge-warning"
                                  id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?></span>
                        </button>
                    </div>

                    <div class="form-group row">
                        <label for="user-stock-ships"
                               class="col-sm-3 col-form-label"><?php echo isset($stockShipmentInfo) ? $stockShipmentInfo : 'ShipsInfo'; ?></label>
                        <div class="col">
                            <input class="form-control" type="text"
                                   value="<?php echo $userParams['Stock'][$userParams['stokNumbers']]['ShipsInfo']; ?>"
                                   id="user-stock-ships">
                        </div>

                    </div>
                </div>
                <!--  /THIRD CARD -->


                <br>
                <div class="container">
                    <a href="" data-toggle="modal" class="btn btn-primary"
                       id="save-stock"><?php echo isset($siteSave) ? $siteSave : 'Save'; ?></a>
                </div>
                <br>

                <input type="hidden" id="uri1" value="<?php echo $currentAction; ?>">
                <input type="hidden" id="uri2" value="<?php echo $currentLang; ?>">
                <input type="hidden" id="stn"
                       value="<?php echo $userParams['Stock'][$userParams['stokNumbers']]['ID']; ?>">
                <?php
            }
            ?>
        </div>
        <?php
        } else {
            session_destroy();
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
  <!--  </div> -->

    <!-- PASWWORD CONFIRM -->
    <?php if (isset($_SESSION['start'])) {
        ?>
        <div id="SconfirmModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">×
                        </button>
                        <h4 class="modal-title"><?php echo isset($siteLoginTitle) ? $siteLoginTitle : ''; ?></h4>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">


                        <form role="form" id="SconfirmForm" data-toggle="validator"
                              class="shake">
                            <div class="row">
                                <div class="form-group">
                                    <label for="password"
                                           class="h4"><?php echo isset($profileConfirmLbl) ? $profileConfirmLbl : ''; ?></label>
                                    <input type="password" class="form-control" id="conf-password"
                                           placeholder="<?php echo isset($siteRegisterPasswPlace) ? $siteRegisterPasswPlace : ''; ?>"
                                           required
                                           data-error="<?php echo isset($siteRegisterPasswErr) ? $siteRegisterPasswErr : ''; ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <input type="hidden" id="uri1"
                                   value="<?php echo $currentAction; ?>"> <input type="hidden"
                                                                                 id="uri2"
                                                                                 value="<?php echo $currentLang; ?>">
                            <button type="submit" id="conf-form-submit"
                                    class="btn btn-success btn-lg pull-right "><?php echo isset($profileConfirmBtn) ? $profileConfirmBtn : 'Confirm'; ?></button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </form>

                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button type="button" class="btn"
                                data-dismiss="modal"><?php echo isset($siteLoginCloseBtn) ? $siteLoginCloseBtn : 'Close'; ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
	
    $content = ob_get_clean();
}

require 'baseTemplate.php'; ?>

