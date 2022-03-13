        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="#" class="logo">
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
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page" style="margin:0px;">
            <!-- Start content -->
            <div class="content">
            <div class="container-fluid">
            <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">Üretimi Tamamlanmış Ürünler</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-9">
                    <p class="text-white-50 m-b-30">Üretimi tamamlanan ürünlere aşağıdaki tablodan erişebilirsiniz.</p>
                    </div>
                    <div class="col-md-3">                
                        <a href ="javascript:history.back()"><button class="btn btn-warning waves-effect waves-light pull-right" style="padding:5px;margin-right:10px;"><i style="font-size:2em;" class="mdi mdi-reply-all"></i></button></a>
                    </div>               
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-20">
                            <div class="card-body">
                                <div id="alertArea"></div>
                                <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table  table-striped" cellspacing="0" width="100%" style="font-size: 11px;">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th data-priority="0">SERİ NO</th>
                                            <th data-priority="1">TÜRÜ</th>
                                            <th data-priority="2">BARKOD NO</th>
                                            <th data-priority="5">EN</th>
                                            <th data-priority="6">BOY</th>
                                            <th data-priority="8">KG</th>
                                            <th data-priority="9">SORUMLU</th>
                                            <th data-priority="10">PLAKA</th>
                                            <th data-priority="11">FİRMA</th>
                                            <th data-priority="12">ÜRETİM DURUMU</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>        
                         </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
          </div> <!-- container-fluid -->
        </div> <!-- content -->
        <!-- END wrapper -->     
        </div>
        <!-- Responsive-table-->
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/RWD-Table-Patterns/dist/js/rwd-table.min.js"></script>   
        <!-- Required datatable js -->
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/jszip.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/buttons.print.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/datatables/buttons.colVis.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function() {
            //Buton Örnekleri
            var table = $('#tech-companies-1').DataTable({
            lengthChange: true,
            lengthMenu: [
            [ 25, 100, 250, 100000],
            [ '25 Kayıt', '100 Kayıt', '250 Kayıt', 'Tümü' ]
            ],
            processing: true,
            serverSide: true,
            sPaginationType: "full_numbers",
            ajax:{
             url: "<?php echo SITE_URL; ?>/uretim/uretilenlerlistesi",
             dataType: "json",
             type: "POST",                  
              },
            dom: 'Bfrtip',
            language: {
            searchPlaceholder: "Arama Alanı",
            search: "Ara",                
            buttons: {
                pageLength: {
                 _: "Gösterilen %d Kayıt",
                 '-1': "Tüm Kayıtlar",
                }
            }
            },
            searching: true,                   
            buttons: [
                'pageLength',
                {
                 extend: 'collection',
                 text: 'Dışa Aktar',
                 buttons: [
                  'copy',
                  'excel',
                  'pdf',
                  'print'
                 ]
                }
            ],              
            columns: [
                  { "data": "sn" },
                  { "data": "turu" },
                  { "data": "bno" },
                  { "data": "eni" },
                  { "data": "boyu" },                
                  { "data": "kg" },                
                  { "data": "sorumlu" },                
                  { "data": "plaka" },                
                  { "data": "firma" },                
                  { "data": "durum" }                     
               ]             
                });              
                table.buttons().container()
                   .appendTo('#tech-companies-1 .col-md-6:eq(0)');    
                });      
                <?php if(($menuyetkim[0]['EKLE']==1)){?>
                        /* İşlem Görüntüleme Başlangıç */
                        function sevkEt(id) {
                            $.ajax({
                            url: '<?php echo SITE_URL; ?>/uretim/tankgetir',
                            type: 'POST',
                            data: 'id='+id,
                            dataType: 'json',
                            cache: false
                            })
                            .done(function(data){
                                    var obj = $.parseJSON(data);
                                    $.each(obj, function() {
                                        tankid                 = this['tkid'];
                                        serino                 = this['serino'];
                                        sirano                 = this['sirano'];
                                        uretimid               = this['uretimid'];
                                    });
                                    $('#tankid').val(tankid);
                                    $('#serino').val(serino);                                    
                                    $('#sirano').val(sirano);                                    
                                    $('#uretimid').val(uretimid);                                    
                                    $('.table-responsive').hide();
                                    $('.table-responsive').show();
                                    $('.sevkEt').modal('show'); // show bootstrap modal when complete loaded
                            })
                            .fail(function(){
                            $('.table-responsive').html('Hata, Lütfen Tekrar Deneyin..');
                            });   
                        }                      
                <?php } ?>                                       
            </script>