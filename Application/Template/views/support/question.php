<?php defined('SC_PANEL') or die; ?>
<div class="form-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="<?php echo innoUrl($currentRouteSection); ?>" method="post" class="form-example-wrap">
                    <div class="cmp-tb-hd">
                        <h2>Задать вопрос службе поддержки</h2>
                        <p>По возможности постарайтесь подробно описать Вашу проблему, указав действия, необходимые для её воспроизведения.</p>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="floating-numner">
                                    <label for="question-text">Текст вопроса</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="form-group<?php if (!$formData['question']['status']) echo ' has-error'; ?>">
                                    <div class="nk-int-st">
                                        <textarea name="message[question]" id="question-text" rows="10" class="form-control"
                                                  placeholder="Текст вопроса" required<?php if (!$messageFormActive) echo ' disabled'; ?>><?php echo $formData['question']['value']; ?></textarea>

                                        <?php if (!empty($formData['question']['message'])) : ?>
                                            <span class="help-block"><?php echo $formData['question']['message']; ?></span>
                                        <?php endif; ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" mg-t-15">
                        <button type="submit" class="btn btn-success notika-btn-success"<?php if (!$messageFormActive) echo ' disabled'; ?>>Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form Examples area End-->
