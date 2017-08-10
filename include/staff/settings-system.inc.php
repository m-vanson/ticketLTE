<?php
if (!defined('OSTADMININC') || !$thisstaff || !$thisstaff->isAdmin() || !$config)
    die('Access Denied');

$gmtime = Misc::gmtime();
?>
<section class="content-header">
    <h1><?php echo __('System Settings and Preferences'); ?> <small>osTicket (<?php echo $cfg->getVersion(); ?>)</small></h1>
</section>

<form action="settings.php?t=system" method="post" class="form-horizontal">
    <?php csrf_token(); ?>
    <input type="hidden" name="t" value="system" >

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo __('General Settings'); ?></h3>
                    </div>
                    <div class="box-body">
                        <?php echo!$config['isonline'] ? '<div class="form-group has-warning">' : '<div class="form-group">' ?>
                        <label for="isonline" class="col-sm-4 control-label"><?php echo __('Helpdesk Status'); ?></label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <select class="form-control" name="isonline" id="isonline">
                                    <option value="1" <?php echo $config['isonline'] ? 'selected' : ''; ?>><?php echo __('Online'); ?></option>
                                    <option value="0" <?php echo!$config['isonline'] ? 'selected' : ''; ?>><?php echo __('Offline'); ?></option>
                                </select>
                                <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#helpdesk_status"></i></span>
                            </div>
                            <?php echo!$config['isonline'] ? '<span class="help-block">osTicket ' . __('Offline') . '</span>' : ''; ?>
                        </div>
                    </div> <!-- /form-group -->

                    <?php echo (isset($errors['helpdesk_url']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
                    <label for="helpdesk_url" class="col-sm-4 control-label"><?php echo __('Helpdesk URL'); ?> *</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" class="form-control" name="helpdesk_url" id="helpdesk_url" value="<?php echo $config['helpdesk_url']; ?>">
                            <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#helpdesk_url"></i></span>
                        </div>
                        <?php echo (isset($errors['helpdesk_url']) ? '<span class="help-block">' . $errors['helpdesk_url'] . '</span>' : '') ?>
                    </div>
                </div> <!-- /form-group -->

                <?php echo (isset($errors['helpdesk_title']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
                <label for="helpdesk_title" class="col-sm-4 control-label"><?php echo __('Helpdesk Name/Title'); ?> *</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="helpdesk_title" id="helpdesk_title" value="<?php echo $config['helpdesk_title']; ?>">
                    <?php echo (isset($errors['helpdesk_title']) ? '<span class="help-block">' . $errors['helpdesk_title'] . '</span>' : '') ?>
                </div>
            </div> <!-- /form-group -->

            <?php echo (isset($errors['default_dept_id']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
            <label for="default-dept-id" class="col-sm-4 control-label"><?php echo __('Default Department'); ?> *</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <select class="form-control" name="default_dept_id" id="default_dept_id" data-quick-add="department">
                        <option value="">&mdash; <?php echo __('Select Default Department'); ?> &mdash;</option>
                        <?php
                        if (($depts = Dept::getPublicDepartments())) {
                            foreach ($depts as $id => $name) {
                                $selected = ($config['default_dept_id'] == $id) ? 'selected="selected"' : '';
                                echo '<option value="' . $id . '"' . $selected . '>' . $name . '</option>';
                            }
                        }
                        ?>
                        <option value="0" data-quick-add>&mdash; <?php echo __('Add New'); ?> &mdash;</option>
                    </select>
                    <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#default_department"></i></span>
                </div>
                <?php echo (isset($errors['default_dept_id']) ? '<span class="help-block">' . $errors['default_dept_id'] . '</span>' : '') ?>
            </div>
        </div> <!-- /form-group -->

        <?php echo (isset($errors['autolock_minutes']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
        <label for="autolock_minutes" class="col-sm-4 control-label"><?php echo __('Collision Avoidance Duration'); ?></label>
        <div class="col-sm-6">
            <div class="input-group">
                <input type="text" class="form-control" name="autolock_minutes" id="autolock_minutes" value="<?php echo $config['autolock_minutes']; ?>">
                <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#collision_avoidance"></i></span>
            </div>
            <?php echo (isset($errors['autolock_minutes']) ? '<span class="help-block">' . $errors['autolock_minutes'] . '</span>' : '') ?>
        </div>
        </div> <!-- /form-group -->

        <div class="form-group">
            <label for="max_page_size" class="col-sm-4 control-label"><?php echo __('Default Page Size'); ?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <select class="form-control" name="max_page_size" id="max_page_size">
                        <?php
                        //$pagelimit = $config['max_page_size'];
                        for ($i = 5; $i <= 50; $i += 5) {
                            echo '<option ' . ($config['max_page_size'] == $i ? 'selected="selected"' : '') . ' value="' . $i . '">' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#default_page_size"></i></span>
                </div>
            </div>
        </div> <!-- /form-group -->

        <?php echo (isset($errors['log_level']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
        <label for="log_level" class="col-sm-4 control-label"><?php echo __('Default Log Level'); ?></label>
        <div class="col-sm-6">
            <div class="input-group">
                <select class="form-control"  name="log_level" id="log_level">
                    <option value=0 <?php echo $config['log_level'] == 0 ? 'selected="selected"' : ''; ?>><?php echo __('None (Disable Logger)'); ?></option>
                    <option value=3 <?php echo $config['log_level'] == 3 ? 'selected="selected"' : ''; ?>> <?php echo __('DEBUG'); ?></option>
                    <option value=2 <?php echo $config['log_level'] == 2 ? 'selected="selected"' : ''; ?>> <?php echo __('WARN'); ?></option>
                    <option value=1 <?php echo $config['log_level'] == 1 ? 'selected="selected"' : ''; ?>> <?php echo __('ERROR'); ?></option>
                </select>
                <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#default_log_level"></i></span>
            </div>
            <?php echo (isset($errors['log_level']) ? '<span class="help-block">' . $errors['log_level'] . '</span>' : '') ?>
        </div>
        </div> <!-- /form-group -->

        <div class="form-group">
            <label for="log_graceperiod" class="col-sm-4 control-label"><?php echo __('Purge Logs'); ?></label>
            <div class="col-sm-6">
                <div class="input-group">
                    <select class="form-control" name="log_graceperiod" id="log_graceperiod">
                        <option value=0 selected><?php echo __('Never Purge Logs'); ?></option>
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            echo '<option ' . ($config['log_graceperiod'] == $i ? 'selected="selected"' : '') . 'value="' . $i . '">';
                            echo sprintf(_N('After %d month', 'After %d months', $i), $i);
                            echo '</option>';
                        }
                        ?>
                    </select>
                    <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#purge_logs"></i></span>
                </div>
            </div>
        </div> <!-- /form-group -->

        <div class="form-group">
            <label for="enable_avatars" class="col-sm-4 control-label"><?php echo __('Show Avatars'); ?></label>
            <div class="col-sm-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="enable_avatars" id="enable_avatars" <?php echo $config['enable_avatars'] ? 'checked="checked"' : ''; ?>>
                        <?php echo __('Show Avatars on thread view.'); ?>
                    </label>
                    <span class="pull-right"><i class="help-tip fa fa-question-circle" href="#enable_avatars"></i></span>
                </div>
            </div>
        </div> <!-- /form-group -->

        <div class="form-group">
            <label for="enable_richtext" class="col-sm-4 control-label"><?php echo __('Enable Rich Text'); ?></label>
            <div class="col-sm-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="enable_richtext" id="enable_richtext" <?php echo $config['enable_richtext'] ? 'checked="checked"' : ''; ?>>
                        <?php echo __('Enable html in thread entries and email correspondence.'); ?>
                    </label>
                    <span class="pull-right"><i class="help-tip fa fa-question-circle" href="#enable_richtext"></i></span>
                </div>
            </div>
        </div> <!-- /form-group -->
        </div> <!-- /box-body -->
        </div> <!-- /box -->
        </div> <!-- /col-xs-12 col-lg-6 -->

        <div class="col-xs-12 col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo __('Date and Time Options'); ?></h3>
                </div>
                <div class="box-body">
                    <?php if (extension_loaded('intl')) { ?>
                        <div class="form-group">
                            <label for="default_locale" class="col-sm-4 control-label"><?php echo __('Default Locale'); ?></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="default_locale" id="default_locale">
                                    <option value=""><?php echo __('Use Language Preference'); ?></option>
                                    <?php
                                    foreach (Internationalization::allLocales() as $code => $name) {
                                        echo '<option value="' . $code . '"' . $code == $config['default_locale'] ? 'selected="selected"' : '' . '>' . $name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div> <!-- /form-group -->

                    <?php } ?>

                    <?php echo (isset($errors['default_timezone']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
                    <label for="enable_richtext" class="col-sm-4 control-label"><?php echo __('Default Time Zone'); ?></label>
                    <div class="col-sm-6">
                        <?php
                        $TZ_TIMEZONE = $config['default_timezone'];
                        $TZ_NAME = 'default_timezone';
                        $TZ_ALLOW_DEFAULT = false;
                        include STAFFINC_DIR . 'templates/timezone.tmpl.php';
                        ?>
                        <?php echo (isset($errors['default_timezone']) ? '<span class="help-block">' . $errors[''] . '</span>' : '') ?>
                    </div>
                </div> <!-- /form-group -->

                <div class="form-group">
                    <label for="date_formats" class="col-sm-4 control-label"><?php echo __('Date and Time Format'); ?></label>
                    <div class="col-sm-6">
                        <select class="form-control" name="date_formats" id="date_formats" onchange="javascript: $('#advanced-time').toggle($(this).find(':selected').val() == 'custom');">
                            <?php
                            foreach (array('' => __('Locale Defaults'), '24' => __('Locale Defaults, 24-hour Time'), 'custom' => '— ' . __("Advanced") . ' —') as $v => $name) {
                                echo '<option value="' . $v . '"';

                                if ($v == $config['date_formats']) {
                                    echo ' selected="selected"';
                                }
                                echo '>' . $name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div> <!-- /form-group -->

                <?php echo (isset($errors['time_format']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
                <label for="time_format" class="col-sm-4 control-label"><?php echo __('Time Format'); ?></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control date-format-preview" name="time_format" id="time_format" value="<?php echo $config['time_format']; ?>">
                    &nbsp;<font class="error">*&nbsp;<?php echo $errors['time_format']; ?></font>
                    <em><?php echo Format::time(null, false); ?></em>
                    <span class="faded date-format-preview" data-for="time_format">
                        <?php echo Format::time('now'); ?>
                    </span>
                </div>
            </div> <!-- /form-group -->

            <?php echo (isset($errors['date_format']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
            <label for="date_format" class="col-sm-4 control-label"><?php echo __('Date Format'); ?></label>
            <div class="col-sm-6">
                <input type="text" class="form-control date-format-preview" name="date_format" id="date_format" value="<?php echo $config['date_format']; ?>">
                &nbsp;<font class="error">*&nbsp;<?php echo $errors['date_format']; ?></font>
                <em><?php echo Format::date(null, false); ?></em>
                <span class="faded date-format-preview" data-for="date_format">
                    <?php echo Format::date('now'); ?>
                </span>
            </div>
        </div> <!-- /form-group -->

        <?php echo (isset($errors['datetime_format']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
        <label for="datetime_format" class="col-sm-4 control-label"><?php echo __('Date and Time Format'); ?></label>
        <div class="col-sm-6">
            <input type="text" class="form-control date-format-preview" name="datetime_format" id="datetime_format" value="<?php echo $config['datetime_format']; ?>">
            &nbsp;<font class="error">*&nbsp;<?php echo $errors['datetime_format']; ?></font>
            <em><?php echo Format::datetime(null, false); ?></em>
            <span class="faded date-format-preview" data-for="datetime_format">
                <?php echo Format::datetime('now'); ?>
            </span>
        </div>
        </div> <!-- /form-group -->

        <?php echo (isset($errors['daydatetime_format']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
        <label for="daydatetime_format" class="col-sm-4 control-label"><?php echo __('Day, Date and Time Format'); ?></label>
        <div class="col-sm-6">
            <input type="text" class="form-control date-format-preview" name="daydatetime_format" id="daydatetime_format" value="<?php echo $config['daydatetime_format']; ?>">
            &nbsp;<font class="error">*&nbsp;<?php echo $errors['daydatetime_format']; ?></font>
            <em><?php echo Format::daydatetime(null, false); ?></em>
            <span class="faded date-format-preview" data-for="daydatetime_format">
                <?php echo Format::daydatetime('now'); ?>
            </span>
        </div>
        </div> <!-- /form-group -->
        </div> <!-- /box-body -->
        </div> <!-- /box -->
        </div> <!-- /col-xs-12 col-lg-6 -->
        </div> <!-- /row -->

        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo __('System Languages'); ?></h3><span class="pull-right"><i class="help-tip fa fa-question-circle" href="#languages"></i></span>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="system_language" class="col-sm-4 control-label"><?php echo __('Primary Language'); ?></label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <?php $langs = Internationalization::availableLanguages(); ?>
                                    <select class="form-control" name="system_language" id="system_language">
                                        <option value="">&mdash; <?php echo __('Select a Language'); ?> &mdash;</option>
                                        <?php
                                        foreach ($langs as $l) {
                                            $selected = ($config['system_language'] == $l['code']) ? 'selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $l['code']; ?>" <?php echo $selected;
                                            ?>><?php echo Internationalization::getLanguageDescription($l['code']); ?></option>
                                                <?php } ?>
                                    </select>
                                    <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#primary_language"></i></span>
                                </div>
                                <?php echo (isset($errors['system_language']) ? '<span class="help-block">' . $errors['system_language'] . '</span>' : '') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="secondary_langs" class="col-sm-4 control-label"><?php echo __('Secondary Languages'); ?></label>
                            <div class="col-sm-6">
                                <div id="secondary_langs" style="width: 300px">
                                    <?php
                                    foreach ($cfg->getSecondaryLanguages() as $lang) {
                                        $info = Internationalization::getLanguageInfo($lang);
                                        ?>
                                        <div class="secondary_lang" style="cursor:move">
                                            <i class="icon-sort"></i>&nbsp;
                                            <span class="flag flag-<?php echo $info['flag']; ?>"></span>&nbsp;
                                            <?php echo Internationalization::getLanguageDescription($lang); ?>
                                            <input type="hidden" name="secondary_langs[]" value="<?php echo $lang; ?>"/>
                                            <div class="pull-right">
                                                <a href="#<?php echo $lang; ?>" onclick="javascript:
                                                                if (confirm('<?php echo __('You sure?'); ?>')) {
                                                            $(this).closest('.secondary_lang')
                                                                    .find('input').remove();
                                                            $(this).closest('.secondary_lang').slideUp();
                                                        }
                                                        return false;
                                                   "><i class="icon-trash"></i></a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <script type="text/javascript">
                                    </script>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-plus-circle"></i></span>
                                    <select class="form-control" name="add_secondary_language">
                                        <option value="">&mdash; <?php echo __('Add a Language'); ?> &mdash;</option>
                                        <?php
                                        foreach ($langs as $l) {
                                            $selected = ($config['add_secondary_language'] == $l['code']) ? 'selected="selected"' : '';
                                            if (!$selected && $l['code'] == $cfg->getPrimaryLanguage())
                                                continue;
                                            if (!$selected && in_array($l['code'], $cfg->getSecondaryLanguages()))
                                                continue;
                                            ?>
                                            <option value="<?php echo $l['code']; ?>" <?php echo $selected;
                                            ?>><?php echo Internationalization::getLanguageDescription($l['code']); ?></option>
                                                <?php } ?>
                                    </select>
                                    <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#secondary_language"></i></span>
                                </div>
                                <?php echo (isset($errors['add_secondary_language']) ? '<span class="help-block">' . $errors[''] . '</span>' : '') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo __('Attachments Storage and Settings'); ?></h3><span class=" pull-right"><i class="help-tip fa fa-question-circle" href="#attachments"></i></span>
                    </div>
                    <div class="box-body">

                        <?php echo (isset($errors['default_storage_bk']) ? '<div class="form-group has-error">' : '<div class="form-group">') ?>
                        <label for="default_storage_bk" class="col-sm-4 control-label"><?php echo __('Store Attachments'); ?></label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <select class="form-control" name="default_storage_bk" id="default_storage_bk">
                                    <?php
                                    if (($bks = FileStorageBackend::allRegistered())) {
                                        foreach ($bks as $char => $class) {
                                            $selected = $config['default_storage_bk'] == $char ? 'selected="selected"' : '';
                                            echo '<option ' . $selected . 'value="' . $char . '">' . $class::$desc . '</option>';
                                        }
                                    } else {
                                        echo sprintf('<option value="">%s</option>', __('Select Storage Backend'));
                                    }
                                    ?>
                                </select>
                                <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#default_storage_bk"></i></span>
                            </div>
                            <?php echo (isset($errors['default_storage_bk']) ? '<span class="help-block">' . $errors['default_storage_bk'] . '</span>' : '') ?>
                        </div>
                    </div> <!-- /form-group -->

                    <div class="form-group">
                        <label for="max_file_size" class="col-sm-4 control-label"><?php echo __('Agent Maximum File Size'); ?></label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <select class="form-control" name="max_file_size" id="max_file_size">
                                    <option value="262144">&mdash; <?php echo __('Small'); ?> &mdash;</option>
                                    <?php
                                    $next = 512 << 10;
                                    $max = strtoupper(ini_get('upload_max_filesize'));
                                    $limit = (int) $max;
                                    if (!$limit)
                                        $limit = 2 << 20;# 2M default value
                                    elseif (strpos($max, 'K'))
                                        $limit <<= 10;
                                    elseif (strpos($max, 'M'))
                                        $limit <<= 20;
                                    elseif (strpos($max, 'G'))
                                        $limit <<= 30;
                                    while ($next <= $limit) {
                                        // Select the closest, larger value (in case the
                                        // current value is between two)
                                        $diff = $next - $config['max_file_size'];
                                        $selected = ($diff >= 0 && $diff < $next / 2) ? 'selected="selected"' : '';
                                        echo '<option value="' . $next . '" ' . $selected . '>' . Format::file_size($next) . '</option>';
                                        $next *= 2;
                                    }
                                    // Add extra option if top-limit in php.ini doesn't fall at a power of two
                                    if ($next < $limit * 2) {
                                        $selected = ($limit == $config['max_file_size']) ? 'selected="selected"' : '';
                                        echo '<option value="' . $limit . '" ' . $selected . '>' . Format::file_size($limit) . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-group-addon"><i class="help-tip fa fa-question-circle" href="#max_file_size"></i></span>
                            </div>
                        </div>
                    </div> <!-- /form-group -->

                    <div class="form-group">
                        <label for="files_req_auth" class="col-sm-4 control-label"><?php echo __('Login required'); ?></label>
                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="files_req_auth" id="files_req_auth" <?php if ($config['files_req_auth']) echo 'checked="checked"'; ?> />
                                    <?php echo __('Require login to view any attachments'); ?>
                                </label>
                            </div>
                            <span class="pull-right"><i class="help-tip fa fa-question-circle" href="#files_req_auth"></i></span>
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

<script type="text/javascript">
    $(function () {
        $('#secondary_langs').sortable({
            cursor: 'move'
        });
        var prev = [];
        $('input.date-format-preview').keyup(function () {
            var name = $(this).attr('name'),
                    div = $('span.date-format-preview[data-for=' + name + ']'),
                    current = $(this).val();
            if (prev[name] && prev[name] == current)
                return;
            prev[name] = current;
            div.text('...');
            $.get('ajax.php/config/date-format', {format: $(this).val()})
                    .done(function (html) {
                        div.html(html);
                    });
        });
    });
</script>
