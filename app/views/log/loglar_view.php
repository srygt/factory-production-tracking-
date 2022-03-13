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
                                <li class="breadcrumb-item active">Personel Logları</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-9">
                    <p class="text-white-50 m-b-30">Sistem kayıtlı tüm personel logları aşağıdaki tablodan erişebilirsiniz.</p>
                    </div>
                    <div class="col-md-3"> 
                    <?php if(($menuyetkim[0]['GOR']==1)){?>
                        <a href ="<?php echo SITE_URL; ?>/log/loglar/&ID=10" title="Liste"><button class="btn btn-primary waves-effect waves-light pull-right" style="padding:5px;margin-right:10px;"><i style="font-size:2em;" class="mdi mdi-format-line-spacing"></i></button></a>
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
                                <table id="tech-companies-1" class="table table-striped table-bordered text-nowrap dataTable no-footer dtr-inline collapsed" cellspacing="0" width="100%" style="font-size: 11px;">
                                    <thead class="thead-primary">
                                    <tr>
                                        <th data-priority="1">PERSONEL</th>
                                        <th data-priority="2">GSM NO</th>
                                        <th data-priority="4">İŞLEM TÜRÜ</th>
                                        <th data-priority="5">İŞLEM TARİHİ</th>
                                        <th data-priority="6">İP NO</th>
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>            
        <script type="text/javascript">
            $(function() {
                $('#tahsTutar').mask("#,##0.00", {reverse: true});                
                $( "#tahsTarihi" ).datepicker({
                dateFormat: "dd-mm-yy",
                monthNames: [ "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık" ],
                dayNamesMin: [ "Pa", "Pt", "Sl", "Ça", "Pe", "Cu", "Ct" ],
                firstDay:1
                });            
            });        
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
             url: "<?php echo SITE_URL; ?>/log/loglistesi/",
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
                  { "data": "admin" },
                  { "data": "kuladi" },
                  { "data": "ituru" },
                  { "data": "itarih" },
                  { "data": "ip" }
               ]             
                });              
                table.buttons().container()
                   .appendTo('#tech-companies-1 .col-md-6:eq(0)');    
                });        
                // Tarih Dönüştürme Fonksiyonu
                function formatDate(date) {
                    var d = new Date(date),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear();

                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;

                    return [day, month, year].join('-');
                }          
            </script>