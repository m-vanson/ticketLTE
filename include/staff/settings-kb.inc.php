<?php
if (!defined('OSTADMININC') || !$thisstaff || !$thisstaff->isAdmin() || !$config)
    die('Access Denied');
?>

<section class="content-header">
    <h1><?php echo __('Knowledge Base Settings and Options'); ?></h1>
</section>

<form action="settings.php?t=kb" method="post" class="form-horizontal">
    <?php csrf_token(); ?>
    <input type="hidden" name="t" value="kb" >
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo __('Disabling knowledge base disables clients\' interface.'); ?></h3>
                    </div>
                    <div class="box-body">

                        <?php echo (isset($errors['enable_kb']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
                        <label for="enable_kb" class="col-sm-4 control-label"><?php echo __('Knowledge Base Status'); ?></label>
                        <div class="col-xs-12 col-sm-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="enable_kb" id="enable_kb" value="1" <?php echo $config['enable_kb'] ? 'checked="checked"' : ''; ?>>
                                    <?php echo __('Enable Knowledge Base'); ?>
                                </label>
                                <span class="pull-right"><i class="help-tip fa fa-question-circle" href="#knowledge_base_status"></i></span>
                            </div>
                            <?php echo (isset($errors['enable_kb']) ? '<span class="help-block">' . $errors['enable_kb'] . '</span>' : '') ?>
                        </div>
                    </div> <!-- /form-group -->

                    <?php echo (isset($errors['restrict_kb']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
                    <label for="restrict_kb" class="col-xs-12 col-sm-4 control-label"><?php echo __('Require Client Login'); ?></label>
                    <div class="col-xs-12 col-sm-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="restrict_kb" id="restrict_kb" value="1" <?php echo $config['restrict_kb'] ? 'checked="checked"' : ''; ?>>
                                <?php echo __('Require Client Login'); ?>
                            </label>
                            <span class="pull-right"><i class="help-tip fa fa-question-circle" href="#restrict_kb"></i></span>
                        </div>
                        <?php echo (isset($errors['restrict_kb']) ? '<span class="help-block">' . $errors['restrict_kb'] . '</span>' : '') ?>
                    </div>
                </div> <!-- /form-group -->

                <?php echo (isset($errors['enable_premade']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
                <label for="enable_premade" class="col-xs-12 col-sm-4 control-label"><?php echo __('Canned Responses'); ?></label>
                <div class="col-xs-12 col-sm-6">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="enable_premade" id="enable_premade" value="1" <?php echo $config['enable_premade'] ? 'checked="checked"' : ''; ?>>
                            <?php echo __('Enable Canned Responses'); ?>
                        </label>
                        <span class="pull-right"><i class="help-tip fa fa-question-circle" href="#canned_responses"></i></span>
                    </div>
                    <?php echo (isset($errors['enable_premade']) ? '<span class="help-block">' . $errors['enable_premade'] . '</span>' : '') ?>
                </div>
            </div> <!-- /form-group -->
        </div> <!-- /box-body -->
        </div> <!-- /box -->
        </div> <!-- /col-xs-12 col-lg-6 -->
        </div> <!-- /row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <button type="reset" class="btn btn-default"><?php echo __('Reset Changes'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo __('Save Changes'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
