<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo "{$title}"; ?></title>
        <?php
        foreach ($css as $file) {
            echo "\n";
            echo '<link href="' . $file . '?v=0.8" rel="stylesheet" type="text/css" />';
        } 
        echo "\n";
        ?>
        <script>
            var base_url       = '<?php echo base_url(); ?>';
            var site_url       = '<?php echo site_url(); ?>';
            var current_url    = '<?php echo current_url(); ?>';
            var config_animate = 'No';
        </script>
        
        <?php
        foreach ($js as $file) {
            echo "\n";
            echo '<script src="' . $file . '?v=0.0.6"></script>';
        } 
        echo "\n"
        ?>
    </head>

    <?php $version = checkVersion(); ?>

    <body class="fixed-nav" id="ib_body">
        <div class="header navbar navbar-fixed-top">
            <div class="">
                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-7 pull-right">
                        <div class="navbar navbar-inverse" role="banner">
                            <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user->fullname; ?> <b class="caret"></b></a>
                                        <ul class="dropdown-menu animated fadeInUp">
                                            <li><a href="<?php echo site_url('auth/logout'); ?>"><?php echo lang('logout'); ?></a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content" style="margin-top: 70px;">
            <div class="row">
                <?php if($this->data['user']->is_admin == 1 AND $version['server_env'] == "production"){ ?>
                    <?php if(dev_version($version['remote_version']) > dev_version($version['my_version']) ){ ?>
                        <div class="col-md-12">
                            <div class="alert alert-info" role="alert" style="width:100%;">
                                Newer version has been released. v <?php echo $version['remote_version'];?> 
                                <a href="<?php echo base_url('sysupgrade/doupgrade')?>">
                                    <span style="font-size:10px;padding:8px;background-color:gold;color:black;">Upgrade here</span>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="col-md-2">
                    <div class="sidebar content-box" style="display: block;">
                        <ul class="nav">
                            <!-- Main menu -->
                            <li class="<?= menu_active('dashboard', false); ?>">
                                <a href="<?= base_url(); ?>">
                                    <i class="glyphicon glyphicon-home"></i> Dashboard
                                </a>
                            </li>
                            <li class="<?= menu_active('user', false) ?>">
                                <a href="<?= base_url('user'); ?>">
                                    <i class="glyphicon glyphicon-user"></i> User Management
                                </a>
                            </li>
                        </ul>
                     </div>
                </div>

                <div class="col-md-10 content-area">
                    <?php echo "$output"; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row" style="border-top:1px solid #ddd;padding-bottom:20px;padding-top:23px;" id="kip-footer">
                <div class="col-md-8" style="margin-bottom:10px;">
                    <div class="sub-footer clear" style="color:#666;">
                        <p class="copyright">
                            © 2020 Testing </p>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){

              $(".submenu > a").click(function(e) {
                e.preventDefault();
                var $li = $(this).parent("li");
                var $ul = $(this).next("ul");

                if($li.hasClass("open")) {
                  $ul.slideUp(350);
                  $li.removeClass("open");
                } else {
                  $(".nav > li > ul").slideUp(350);
                  $(".nav > li").removeClass("open");
                  $ul.slideDown(350);
                  $li.addClass("open");
                }
              });
              
            });
        </script>
    </body>
</html>