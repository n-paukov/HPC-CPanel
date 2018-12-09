<?php defined('SC_PANEL') or die; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="floating-numner">
            <label><?php echo $title; ?></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="form-group<?php if (!$data['status']) echo ' has-error'; ?>">
            <div class="nk-int-st">
                <?php if ($type == 'textarea') : ?>
                    <textarea name="<?php echo $name; ?>" class="form-control"
                              placeholder="<?php echo $placeholder; ?>" <?php if ($required) echo ' required'; ?>><?php echo e($data['value']); ?></textarea>

                <?php else : ?>
                    <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" class="form-control"
                           placeholder="<?php echo $placeholder; ?>" value="<?php echo e($data['value']); ?>"<?php if ($required) echo ' required'; ?>
                    <?php if (!empty($mask)) echo ' data-mask="'.$mask.'"'; ?>>

                <?php endif; ?>
                <?php if (!empty($data['message'])) : ?>
                    <span class="help-block"><?php echo $data['message']; ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>