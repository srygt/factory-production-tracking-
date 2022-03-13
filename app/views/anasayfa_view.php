            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">                
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Dashboard</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">
                                            Sayın <strong><?php echo session::get("adminName"); ?></strong> Hoşgeldiniz
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat">
                                <a href="<?php echo SITE_URL; ?>/seri/seriler/&ID=12" title="Ürün Seri Numaraları">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-account float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3" lang="tr">SERİLER</h6>
                                            <h4 class="mb-4"><?php echo $toplamseri; ?></h4>
                                            <span class="ml-2">Seri Numarası Bulunmaktadır</span>
                                        </div>
                                    </div>
                                </a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat">
                                <a href="<?php echo SITE_URL; ?>/stok/stoktakiler/&ID=10" title="Stok Listesi">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-file float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3" lang="tr">STOKLAR</h6>
                                            <h4 class="mb-4"><?php echo $toplamstok; ?></h4>
                                            <span class="ml-2">Stok Bulunmaktadır</span>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat">
                                <a href="<?php echo SITE_URL; ?>/personel/personeller/&ID=5" title="Personeller">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-account-multiple float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3" lang="tr">PERSONELLER</h6>
                                            <h4 class="mb-4"><?php echo $toplampersonel; ?></h4>
                                            <span class="ml-2">Personel Bulunmaktadır</span>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat">
                                <a href="<?php echo SITE_URL; ?>/stok/barkodlar/&ID=16" title="Sevk Edilenler">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-account-switch float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3" lang="tr">SEVKLER</h6>
                                            <h4 class="mb-4"><?php echo $toplamsevk; ?></h4>
                                            <span class="ml-2">Sevk Bulunmaktadır</span>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-xl-3 col-lg-3">
                                <div class="card m-b-20">
                                    <div class="card-body btn-warning">
                                        <h4 class="mt-0 header-title mb-4"><i class="mdi mdi-file float-right"></i> Stokta Bulunan Ürün Sayısı</h4>
                                        <div class="table-responsive">
                                            <div class="text-white">
                                                <h4 class="mb-4"><?php echo $toplamstok; ?></h4>
                                                <span class="ml-2">Toplam Ürün Bulunmaktadır.</span>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <a href="<?=SITE_URL?>/stok/stoktakiler/&ID=10" class="btn btn-sm btn-default">Tüm Stoklar</a>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3">
                                <div class="card m-b-20">
                                    <div class="card-body btn-success">
                                        <h4 class="mt-0 header-title mb-4"><i class="mdi mdi-file float-right"></i> Üretilenler Listesi</h4>
                                        <div class="table-responsive">
                                            <div class="text-white">
                                                <h4 class="mb-4"><?php echo $toplamuretilen; ?></h4>
                                                <span class="ml-2">Toplam Ürün Bulunmaktadır.</span>
                                            </div>                                            
                                        </div>                                        
                                        <div class="text-center">
                                            <a href="<?php echo SITE_URL; ?>/uretim/uretilenler/&ID=15" class="btn btn-sm btn-default">Tüm Üretilenler</a>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                            <div class="col-xl-3 col-lg-3">
                                <div class="card m-b-20">
                                    <div class="card-body btn-info">
                                        <h4 class="mt-0 header-title mb-4"><i class="mdi mdi-file float-right"></i> Üretimdekiler Listesi</h4>
                                        <div class="table-responsive">
                                            <div class="text-white">
                                                <h4 class="mb-4"><?php echo $toplamuretimdekiler; ?></h4>
                                                <span class="ml-2">Toplam Ürün Bulunmaktadır.</span>
                                            </div>                                            
                                        </div>                                        
                                        <div class="text-center">
                                            <a href="<?php echo SITE_URL; ?>/" class="btn btn-sm btn-default">Tüm Üretimdekiler</a>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                            <div class="col-xl-3 col-lg-3">
                                <div class="card m-b-20">
                                    <div class="card-body btn-danger">
                                        <h4 class="mt-0 header-title mb-4"><i class="mdi mdi-file float-right"></i> Üretilecekler Listesi</h4>
                                        <div class="table-responsive">
                                            <div class="text-white">
                                                <h4 class="mb-4"><?php echo $toplamuretilecek; ?></h4>
                                                <span class="ml-2">Toplam Ürün Bulunmaktadır.</span>
                                            </div>                                            
                                        </div>                                        
                                        <div class="text-center">
                                            <a href="<?php echo SITE_URL; ?>/uretim/uretilecekler/&ID=25" class="btn btn-sm btn-default">Tüm Üretilecekler</a>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                            <div class="col-xl-6 col-lg-6">
                                <div class="cardz m-b-20">
                                    <div class="card-body">
                                        <h4 class="mt-0 mb-4" style="background-color:#333;padding:10px;color:#fff;"><i class="mdi mdi-barcode-scan float-right"></i> <strong><?=date("d.m.Y")?></strong> Tarihli Okunan Barkod Listesi</h4>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>BARKOD NO</th>
                                                        <th>SERİ NO</th>
                                                        <th>ÇAP/YÜKSEKLİK/LİTRE</th>
                                                        <th>OKUNAN ADET</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($okunanlar as $v){?>
                                                    <tr>
                                                        <td><?=$v['barkodno']?></td>
                                                        <td><?=$v['serino']?></td>
                                                        <td><?=$v['cap'].'/'.$v['yukseklik'].'/'.$v['litre']?></td>
                                                        <td><strong style="font-weight:bold;color:#fff;background-color:#ec536c;padding:15px;height:40px;width:60px;border-radius:100%;"><?=$v['miktar']?></strong></td>
                                                    </tr>                          
                                                    <?php } ?>                          
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                            <div class="col-xl-6 col-lg-6">
                                <div class="cards m-b-20">
                                    <div class="card-body">
                                        <h3 class="mt-0 mb-4" style="background-color:#333;padding:10px;color:#fff;"><i class="mdi mdi-barcode float-right"></i> Stok Listesi</h3>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>BARKOD NO</th>
                                                        <th>SERİ NO</th>
                                                        <th>EBATLAR</th>
                                                        <th>STOK MİKTARI</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($stoklar as $v){?>
                                                    <tr>
                                                        <td><?=$v['barkodno']?></td>
                                                        <td><?=$v['serino']?></td>
                                                        <td><?=$v['cap'].'/'.$v['yukseklik']?></td>
                                                        <td><?=$v['girismiktari']-$v['cikismiktari']?></td>
                                                    </tr>                          
                                                    <?php } ?>                          
                                                </tbody>
                                            </table>                                          
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                        </div>                        
                    </div> <!-- container-fluid -->
                </div> <!-- content -->
            </div>
            <!-- Hatırlatmalar -->