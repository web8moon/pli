<?php if (!isset($content)) {
    ob_start();

    $userID = checkUserSession('start');
    $userParams = getUserParams();
    $queqryUrl = parseQueryUrl(str_replace("q=", "", trim($_SERVER['QUERY_STRING'])));

    var_dump($queqryUrl);
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
                <a class="nav-link" href="/<?php echo isset($pageLinks['stocks']) ? $pageLinks['stocks'] : 'welcome'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profileStocksMenu) ? $profileStocksMenu : 'Stocks'; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/<?php echo isset($pageLinks['parts']) ? $pageLinks['parts'] : 'welcome'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profilePartsMenu) ? $profilePartsMenu : 'Parts'; ?></a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="container">
        <div class="form-group row justify-content-center">
        <button type="button" class="btn btn-outline-primary" id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Update'; ?>
            <span style="display:none;" class="badge badge-warning" id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
        </button>
        <button type="button" class="btn btn-outline-primary" id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Add'; ?>
            <span style="display:none;" class="badge badge-warning" id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
        </button>
        <button type="button" class="btn btn-outline-primary" id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Import'; ?>
            <span style="display:none;" class="badge badge-warning" id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
        </button>
        <button type="button" class="btn btn-outline-primary" id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Export'; ?>
            <span style="display:none;" class="badge badge-warning" id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
        </button>
        <button type="button" class="btn btn-outline-primary" id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Erase'; ?>
            <span style="display:none;" class="badge badge-warning" id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
        </button>
        </div>

        <div class="input-group">
            <input type="text" class="form-control" id="qsearch" placeholder="<?php echo isset($stockPartsQsearch) ? $stockPartsQsearch : 'Quick Search'; ?>">
            <span class="input-group-btn">
        <button class="btn btn-outline-primary" id="go" type="submit" >Go</button>
      </span>
        </div>
    </div>
    </div>

    <table class="table table-responsive table-hover">
        <thead>
        <tr>
            <th>Active</th>
            <th>Brand</th>
            <th>Code</th>
            <th>Name</th>
            <th>Quan</th>
            <th>Price</th>
            <th>Used</th>
        </tr>
        </thead>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">&laquo;</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">&raquo;</a>
            </li>
        </ul>
    </nav>
</div>


    <?php $content = ob_get_clean();
} ?>

<?php require 'baseTemplate.php'; ?>
