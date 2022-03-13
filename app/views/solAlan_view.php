        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="<?php echo SITE_URL; ?>" class="logo">
                        <span>
                            <img src="<?=SITE_URL?>/upload/images/logo.png" alt="Yönetim Paneli" height="50">
                        </span>
                        <i>
                            <img src="<?=SITE_URL?>/upload/images/logo.png" alt="Yönetim Paneli" height="45">
                        </i>
                    </a>
                </div>
                <nav class="navbar-custom">
                    <ul class="navbar-right d-flex list-inline float-right mb-0">
                        <li class="dropdown notification-list">
                            <div class="dropdown notification-list nav-pro-img">
                                <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/images/users/user-1.jpg" alt="user" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <!-- item-->
                                    <a class="dropdown-item" href="<?php echo SITE_URL; ?>/user/changepass"><i class="mdi mdi-wallet m-r-5"></i> Şifremi Değiştir</a>
                                    <a class="dropdown-item text-danger" href="<?php echo SITE_URL; ?>/yonetici/cikis"><i class="mdi mdi-power text-danger"></i> Çıkış Yap</a>
                                </div>                                                                    
                            </div>
                        </li>
                    </ul>
                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-effect">
                                <i class="mdi mdi-menu"></i>
                            </button>
                        </li>
                        <li class="d-none d-sm-block">
                            <div class="dropdown pt-3 d-inline-block">
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Top Bar End -->
            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="slimscroll-menu" id="remove-scroll">
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu" id="side-menu">
                            <li>
                                <a href="<?php echo SITE_URL; ?>/" class="waves-effect">
                                    <i class="mdi mdi-home"></i> <span> Anasayfa </span>
                                </a>
                            </li>                            
                            <?php foreach ($menulistesi as $key => $mc) { if($mc['PARENTID']==0){?>                                
                            <li>
                            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-<?php echo $mc['am_Ikon']; ?>"></i> <span> <?php echo $mc['am_Konu']; ?> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="submenu collapse" aria-expanded="true">
                            <?php foreach ($menulistesi as $key => $msc){ if($msc['PARENTID']==$mc['AMID']){ ?>                               
                            <li><a href="<?=SITE_URL?>/<?=$msc['am_Link']?>/&ID=<?=$msc['AMID']?>"><span><i class="mdi mdi-flag-triangle"></i> <?=$msc['am_Konu']?> </span></a></li>
                            <?php }} ?>
                            </ul>
                            </li> 
                            <?php }} ?> 
                        </ul>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>
                </div>
                <!-- Sidebar -left -->
            </div>
            <!-- Left Sidebar End -->
