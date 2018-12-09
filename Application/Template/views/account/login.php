<?php defined('SC_PANEL') or die; ?><!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Login Register area Start-->
<div class="login-content">
    <!-- Login -->
    <div class="nk-block toggled" id="l-login">
        <div class="nk-form">
            <?php if (!empty($errorMessage)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo innoUrl(['account', 'login']); ?>" method="post">
            <div class="input-group">
                <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-support"></i></span>
                <div class="nk-int-st">
                    <input type="text" class="form-control" name="account[login]" placeholder="Логин">
                </div>
            </div>
            <div class="input-group mg-t-15">
                <span class="input-group-addon nk-ic-st-pro"><i class="notika-icon notika-edit"></i></span>
                <div class="nk-int-st">
                    <input type="password" name="account[password]" class="form-control" placeholder="Пароль">
                </div>
            </div>
            <button type="submit" class="btn btn-login btn-success btn-float"><i class="notika-icon notika-right-arrow right-arrow-ant"></i></button>
            </form>
        </div>
    </div>
</div>