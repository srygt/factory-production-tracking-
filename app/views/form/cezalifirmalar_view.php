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
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>">Anasayfa</a></li>
                                <li class="breadcrumb-item active">Cezalı Firmalar</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-8">
                    <p class="text-white-50 m-b-30">Sistem kayıtlı tüm cezalı firmalar aşağıdaki tablodan erişebilirsiniz.</p>
                    </div>
                    <div class="col-md-4">
                    <?php if(($menuyetkim[0]['GOR']==1)){?>
                        <a href ="<?php echo SITE_URL; ?>/ymm/mukellefler/&ID=1" title="Mükellef Listesi"><button class="btn btn-info waves-effect waves-light pull-left" style="padding:5px;"><i style="font-size:2em;" class="mdi mdi-account-switch"></i> MÜKELLEFLER</button></a> 
                        <a href ="<?php echo SITE_URL; ?>/mhfirma/malhizmetveren/&ID=11" title="Hizmet üreten Firmalar"><button class="btn btn-success waves-effect waves-light pull-right" style="padding:5px;"><i style="font-size:2em;" class="mdi mdi-comment-plus-outline"></i> FİRMALAR</button></a>
                    <?php } ?>                  
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
                                        <th data-priority="0">İŞLEM</th>
                                        <th data-priority="2">FİRMA</th>
                                        <th data-priority="3">YETKİLİ</th>
                                        <th data-priority="4">VERGİ DAİRESİ</th>
                                        <th data-priority="5">VERGİ NO / TCNO</th>
                                        <th data-priority="6">TELEFON/GSM</th>
                                        <th data-priority="7">CEZA NOTU</th>
                                        <th data-priority="8">İŞLEM TARİHİ</th>
                                        <th data-priority="9">DURUMU</th>
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
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/pages/lightbox.js"></script>
        <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
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
             url: "<?php echo SITE_URL; ?>/mhfirma/cezalifirmalistesi/",
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
                  { "data": "islem" },
                  { "data": "firma" },
                  { "data": "yetki" },
                  { "data": "vd" },
                  { "data": "vn" },
                  { "data": "telefon" },
                  { "data": "cnot" },
                  { "data": "ceztar" },
                  { "data": "durum" }
               ]             
                });              
                table.buttons().container()
                   .appendTo('#tech-companies-1 .col-md-6:eq(0)');    
                });                
                <?php if(($menuyetkim[0]['SIL']==1)){?>
                /* Silme İşlemi Başlangıç    */
                function cezaSil(id) {
                    var conf = confirm("Firmanın ceza durumunu kaldırmak istediğinizden emin misiniz?. Sildiğiniz taktirde işlemleri geri alamazsınız.");
                    if (conf == true) {
                        $.post("<?php echo SITE_URL; ?>/mhfirma/cezalifirmasil", {
                                id: id
                            },
                            function (data, status) {
                                // reload Users by using readRecords();
                            $('#alertArea').html(data).delay(3000).fadeOut(3000);
                            location.reload();
                            }
                        );
                    }
                }
                /* Silme İşlemi Bitiş */                
                <?php } ?>
            </script>