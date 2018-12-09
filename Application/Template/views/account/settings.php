<?php defined('SC_PANEL') or die; ?>
<div class="form-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="<?php echo innoUrl($currentRouteSection); ?>" method="post" class="form-example-wrap">
                    <div class="cmp-tb-hd">
                        <h2>Настройки аккаунта</h2>
                        <p>Указанные здесь данные будут использоваться для отправки уведомлений.</p>
                    </div>
                    <div>
                        <?php innoFormFieldRow('account[name]', 'Ваше имя', 'Ваше имя', true, $formData['name']); ?>
                        <?php innoFormFieldRow('account[surname]', 'Ваша фамилия', 'Ваша фамилия', true, $formData['surname']); ?>
                        <?php innoFormFieldRow('account[email]', 'Ваш E-Mail', 'address@vsu.ru', true, $formData['email']); ?>

                    </div>
                    <div class=" mg-t-15">
                        <button type="submit" class="btn btn-success notika-btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form Examples area End-->
