<?php
if (isset($_SESSION['start'])) {
    if (!isset($content)) {
        ob_start(); ?>
        <h1>Профиль</h1>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Профиль</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Склады</a>
            </li>
        </ul>


        <br>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
      <span class="input-group-addon">
        <input checked type="checkbox" aria-label="Checkbox for following text input" id="accountactivechk">
      </span>
                    <input disabled value="<?php echo isset($siteSelectorAccountActive) ? $siteSelectorAccountActive : 'Active'; ?>" type="text" id="accountactivelbl"
                           class="form-control" aria-label="Text input with checkbox">
                </div>
            </div>
        </div>

        <?php $content = ob_get_clean();
    } ?>

    <?php require 'baseTemplate.php';
} ?>