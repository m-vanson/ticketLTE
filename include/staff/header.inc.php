<?php
/* * *******************************************************************
  header.inc.php

  File modified for AdminLTE theme
  Modified by:
  M. van Son <m.vanson@solvedit.nu>
  https://www.solvedit.nu
 **********************************************************************/

header("Content-Type: text/html; charset=UTF-8");

$title = ($ost && ($title = $ost->getPageTitle())) ? $title : ('osTicket :: ' . __('Staff Control Panel'));

if (!isset($_SERVER['HTTP_X_PJAX'])) {
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html<?php
    if (($lang = Internationalization::getCurrentLanguage()) && ($info = Internationalization::getLanguageInfo($lang)) && (@$info['direction'] == 'rtl'))
        echo ' dir="rtl" class="rtl"';
    if ($lang) {
        echo ' lang="' . Internationalization::rfc1766($lang) . '"';
    }
    ?>>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <meta http-equiv="cache-control" content="no-cache" />
            <meta http-equiv="pragma" content="no-cache" />
            <meta http-equiv="x-pjax-version" content="<?php echo GIT_VERSION; ?>">
            <title><?php echo Format::htmlchars($title); ?></title>
            <!--[if IE]>
            <style type="text/css">
                .tip_shadow { display:block !important; }
            </style>
            <![endif]-->

            <!-- let's get our jquery and bootstrap from CDN -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

            <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
            <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
            <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/thread.css?901e5ea" media="all"/>
            <link rel="stylesheet" href="<?php echo ROOT_PATH ?>scp/css/scp.css?901e5ea" media="all"/>
            <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?901e5ea" media="screen"/>
            <link rel="stylesheet" href="<?php echo ROOT_PATH ?>scp/css/typeahead.css?901e5ea" media="screen"/>
            <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?901e5ea" rel="stylesheet" media="screen" />
            <!--[if IE 7]>
            <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome-ie7.min.css?901e5ea"/>
            <![endif]-->
            <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH ?>scp/css/dropdown.css?901e5ea"/>
            <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/loadingbar.css?901e5ea"/>
            <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?901e5ea"/>
            <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?901e5ea"/>
            <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?901e5ea"/>
            <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH ?>scp/css/translatable.css?901e5ea"/>

            <!-- Insert AdminLTE style sheets and JS files -->
            <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/adminlte/css/AdminLTE.css"/>
            <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/adminlte/css/skins/skin-blue.min.css">

            <script type="text/javascript" src="<?php echo ROOT_PATH; ?>assets/adminlte/js/adminlte.js"></script>
            <script type="text/javascript" src="<?php echo ROOT_PATH; ?>assets/adminlte/js/app.js"></script>

            <?php
            if ($ost && ($headers = $ost->getExtraHeaders())) {
                echo "\n\t" . implode("\n\t", $headers) . "\n";
            }
            ?>
        </head>
        <body class="skin-blue sidebar-mini">
            <div class="wrapper" style="height: auto; min-height: 100%;">
                <?php
                if ($ost->getError()) {
                    echo sprintf('<div id="error_bar">%s</div>', $ost->getError());
                } elseif ($ost->getWarning()) {
                    echo sprintf('<div id="warning_bar">%s</div>', $ost->getWarning());
                } elseif ($ost->getNotice()) {
                    echo sprintf('<div id="notice_bar">%s</div>', $ost->getNotice());
                }
                ?>
                <header class="main-header">

                    <!-- Logo -->
                    <a href="<?php echo ROOT_PATH ?>scp/index.php" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b>A</b>LT</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><img src="<?php echo ROOT_PATH ?>scp/logo.php?<?php echo strtotime($cfg->lastModified('staff_logo_id')); ?>" alt="osTicket &mdash; <?php echo __('Customer Support System'); ?>" width="130px"/></span>
                    </a>

                    <!-- Header Navbar -->
                    <nav class="navbar navbar-static-top" role="navigation">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                        <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <?php if ($thisstaff->isAdmin() && !defined('ADMINPAGE')) { ?>
                                    <li><a href="<?php echo ROOT_PATH ?>scp/admin.php" class="no-pjax"><?php echo __('Admin Panel'); ?></a></li>
                                <?php } else { ?>
                                    <li><a href="<?php echo ROOT_PATH ?>scp/index.php" class="no-pjax"><?php echo __('Agent Panel'); ?></a></li>
                                <?php } ?>
                                <li><a href="<?php echo ROOT_PATH ?>scp/profile.php"><?php echo __('Profile'); ?></a></li>
                                <li><a href="<?php echo ROOT_PATH ?>scp/logout.php?auth=<?php echo $ost->getLinkToken(); ?>" class="no-pjax"><?php echo __('Log Out'); ?></a></li>

                                <!-- User Account Menu -->
                                <li class="dropdown user user-menu">
                                    <!-- Menu Toggle Button -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <!-- The user image in the navbar
                                              Disabled for now...-->
                                        <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                        <span class="hidden-xs"><?php echo sprintf(__('Welcome, %s.'), '<strong>' . $thisstaff->getFirstName() . '</strong>'); ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- The user image in the menu -->
                                        <li class="user-header">
                                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                            <p><?php echo '<strong>' . $thisstaff->getFirstName() . '</strong>'; ?></p>
                                        </li>
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <div id="pjax-container" class="<?php if ($_POST) echo 'no-pjax'; ?>">
                    <?php
                } else {
                    header('X-PJAX-Version: ' . GIT_VERSION);
                    if ($pjax = $ost->getExtraPjax()) {
                        ?>
                        <script type="text/javascript">
        <?php
        foreach (array_filter($pjax) as $s)
            echo $s . ";";
        ?>
                        </script>
                        <?php
                    }
                    foreach ($ost->getExtraHeaders() as $h) {
                        if (strpos($h, '<script ') !== false)
                            echo $h;
                    }
                    ?>
                    <title><?php echo ($ost && ($title = $ost->getPageTitle())) ? $title : 'osTicket :: ' . __('Staff Control Panel'); ?></title><?php
                } # endif X_PJAX 

                /*                 * *******************************************************************
                 *    Begin AdminLTE menu
                 *
                 * ******************************************************************** */
                ?>
                <aside class="main-sidebar">
                    <section class="sidebar">
                        <!-- Sidebar Menu -->
                        <ul class="sidebar-menu tree" data-widget="tree">
<?php include STAFFINC_DIR . "templates/navigation.tmpl.php"; ?>
                        </ul>
                        <!-- /.sidebar-menu -->
                    </section>
                    <!-- /.sidebar -->
                </aside>

                <div class="content-wrapper">
                    <?php if ($errors['err']) { ?>
                        <div id="msg_error"><?php echo $errors['err']; ?></div>
                    <?php } elseif ($msg) { ?>
                        <div id="msg_notice"><?php echo $msg; ?></div>
                    <?php } elseif ($warn) { ?>
                        <div id="msg_warning"><?php echo $warn; ?></div>
                        <?php
                    }
                    foreach (Messages::getMessages() as $M) {
                        ?>
                        <div class="<?php echo strtolower($M->getLevel()); ?>-banner"><?php echo (string) $M; ?></div>
                        <?php
                    } 
