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
                                <li class="breadcrumb-item active">Seriler</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-9">
                    <p class="text-white-50 m-b-30">Sistem kayıtlı tüm serilere aşağıdaki tablodan erişebilirsiniz.</p>
                    </div>
                    <div class="col-md-3"> 
                    <?php if(($menuyetkim[0]['EKLE']==1)){?>
                        <a href ="<?php echo SITE_URL; ?>/seri/seriekle" title="Kayıt Ekle"><button class="btn btn-success waves-effect waves-light pull-right" style="padding:5px;"><i style="font-size:2em;" class="mdi mdi-comment-plus-outline"></i></button></a>
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
                                        <th data-priority="1">BARKOD NO</th>
                                        <th data-priority="2">SN</th>
                                        <th data-priority="3">YILI</th>
                                        <th data-priority="4">TİP ONAY</th>
                                        <th data-priority="5">LİTRE TANIMI</th>
                                        <th data-priority="6">TANK TÜRÜ</th>
                                        <th data-priority="7">ÇAP</th>
                                        <th data-priority="7">YÜKSELİK</th>
                                        <th data-priority="8">LİTRE</th>
                                        <th data-priority="9">TİPİ</th>
                                        <th data-priority="10">KG</th>
                                        <th data-priority="11">GÖVDE</th>
                                        <th data-priority="12">KAPAK</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5"><div class="btn btn-info">Tank Üretimini Başlat</div>
                                            <div class="btn btn-warning">Tankı Üretime Kapat</div>
                                            <div class="btn btn-danger">İşlemi Sil</div></th>
                                            <th colspan="6"></th>
                                        </tr>
                                    </tfoot>
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
        <?php if(($menuyetkim[0]['EKLE']==1)){?>
            <!--  Modal Seri Tanımlama Alanı -->
            <div class="modal fade seribilgiekle" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Seri Numarası Bilgi Tanımlama Alanı</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <div class="row">
                                <form id="form_validation" method="POST" enctype="multipart/form-data">
                                    <div class="row" style="padding:0px 15px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>BARKOD NO </label>
                                                <div>
                                                    <input type="text" id="seriBarkod" name="seriBarkod" class="form-control" placeholder="Barkod No">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->             

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ÇAP </label>
                                                <div>
                                                    <input type="text" id="seriCap" name="seriCap" class="form-control" placeholder="Çap">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>YÜKSELİK </label>
                                                <div>
                                                    <input type="text" id="seriYukseklik" name="seriYukseklik" class="form-control" placeholder="Yükseklik">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>LİTRE </label>
                                                <div>
                                                    <input type="text" id="seriLitre" name="seriLitre" class="form-control" placeholder="Litre">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->                
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>KG </label>
                                                <div>
                                                    <input type="text" id="seriKg" name="seriKg" class="form-control" placeholder="Kg">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>GÖVDE </label>
                                                <div>
                                                    <input type="text" id="seriGovdeEni" name="seriGovdeEni" class="form-control" placeholder="Gövde Eni">
                                                    <input type="text" id="seriGovdeBoyu" name="seriGovdeBoyu" class="form-control" placeholder="Gövde Boyu">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>KAPAK </label>
                                                <div>
                                                    <input type="text" id="seriKapakEni" name="seriKapakEni" class="form-control" placeholder="Kapak Eni">
                                                    <input type="text" id="seriKapakBoyu" name="seriKapakBoyu" class="form-control" placeholder="Kapak Boyu">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->                
                                    <div class="col-lg-12">
                                        <div class="card m-b-20">
                                            <div class="card-body" style="padding: 1.25rem 1.25rem 0rem 1.25rem;">
                                                <div class="form-group">
                                                    <input type="hidden" id="seriid" name="seriid">
                                                    <input type="hidden" id="yili" name="yili">
                                                    <input type="hidden" id="tipi" name="tipi">
                                                    <input type="hidden" id="litresi" name="litresi">
                                                    <button type="submit" style="width: 100%;" class="btn btn-primary waves-effect waves-light mr-1">
                                                        <i class="mdi mdi-content-save"></i> Kaydet
                                                    </button>
                                                </div>   
                                                <div id="alertAream"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>            
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!--  Modal Seri Tanımlama Alanı -->
            <div class="modal fade seribilgiguncelle" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Seri Numarası Bilgi Güncelleme Alanı</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <div class="row">
                                <form action="<?=SITE_URL?>/seri/seribilgiguncelle" method="POST" enctype="multipart/form-data">
                                    <div class="row" style="padding:0px 15px;">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>BARKOD NO </label>
                                                <div>
                                                    <input type="text" id="seriBarkodg" name="seriBarkodg" class="form-control" placeholder="Barkod No">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->             

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>ÇAP </label>
                                                <div>
                                                    <input type="text" id="seriCapg" name="seriCapg" class="form-control" placeholder="Çap">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>YÜKSELİK </label>
                                                <div>
                                                    <input type="text" id="seriYukseklikg" name="seriYukseklikg" class="form-control" placeholder="Yükseklik">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>LİTRE </label>
                                                <div>
                                                    <input type="text" id="seriLitreg" name="seriLitreg" class="form-control" placeholder="Litre">
                                                </div>
                                            </div>
                                        </div> <!-- end col -->                
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>KG </label>
                                                <div>
                                                    <input type="text" id="seriKgg" name="seriKgg" class="form-control" placeholder="Kg">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>GÖVDE </label>
                                                <div>
                                                    <input type="text" id="seriGovdeEnig" name="seriGovdeEnig" class="form-control" placeholder="Gövde Eni">
                                                    <input type="text" id="seriGovdeBoyug" name="seriGovdeBoyug" class="form-control" placeholder="Gövde Boyu">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>KAPAK </label>
                                                <div>
                                                    <input type="text" id="seriKapakEnig" name="seriKapakEnig" class="form-control" placeholder="Kapak Eni">
                                                    <input type="text" id="seriKapakBoyug" name="seriKapakBoyug" class="form-control" placeholder="Kapak Boyu">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->                
                                    <div class="col-lg-12">
                                        <div class="card m-b-20">
                                            <div class="card-body" style="padding: 1.25rem 1.25rem 0rem 1.25rem;">
                                                <div class="form-group">
                                                    <input type="hidden" id="serinoid" name="serinoid">
                                                    <button type="submit" style="width: 100%;" class="btn btn-primary waves-effect waves-light mr-1">
                                                        <i class="mdi mdi-content-save"></i> Güncelle
                                                    </button>
                                                </div>   
                                                <div id="alertAream"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>            
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->            
        <?php } ?>           
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
             url: "<?php echo SITE_URL; ?>/seri/serilistesi",
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
                  { "data": "barno"},
                  { "data": "sn" },
                  { "data": "yili" },
                  { "data": "tip" },
                  { "data": "litre" },
                  { "data": "tank" },
                  { "data": "cap" },
                  { "data": "yukseklik" },
                  { "data": "litresi" },
                  { "data": "tipi" },
                  { "data": "kg" },
                  { "data": "govde" },
                  { "data": "kapak" }
               ]             
                });              
                table.buttons().container()
                   .appendTo('#tech-companies-1 .col-md-6:eq(0)');    
                });              
                <?php if(($menuyetkim[0]['SIL']==1)){?>
                /* Silme İşlemi Başlangıç    */
                function seriSil(id) {
                    var conf = confirm("Seriyi silmek istediğinizden emin misiniz? Sildiğiniz taktirde işlemleri geri alamazsınız.");
                    if (conf == true) {
                        $.post("<?php echo SITE_URL; ?>/seri/serisil", {
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
                <?php if(($menuyetkim[0]['URET']==1)){?>
                /* Üretme Başlatma Başlangıç    */
                function uretimiBaslat(id) {
                    var conf = confirm("Üretimi başlatmak istediğinizden emin misiniz?");
                    if (conf == true) {
                        $.post("<?php echo SITE_URL; ?>/seri/uretimibaslat", {
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
                <?php if(($menuyetkim[0]['KAPAT']==1)){?>
                /* Üretime Kapatma İşlemi Başlangıç    */
                function uretimeKapat(id) {
                    var conf = confirm("Tankı üretime kapatmak istediğinizden emin misiniz? Kapattığınız taktirde bu ürünü bir daha üretemezsiniz.");
                    if (conf == true) {
                        $.post("<?php echo SITE_URL; ?>/seri/uretimekapat", {
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
                <?php if(($menuyetkim[0]['GOR']==1)){?>
                        /* İşlem Görüntüleme Başlangıç */
                        function seribilgiekle(id) {
                            $.ajax({
                            url: '<?php echo SITE_URL; ?>/seri/serigetir',
                            type: 'POST',
                            data: 'id='+id,
                            dataType: 'json',
                            cache: false
                            })
                            .done(function(data){
                                    var obj = $.parseJSON(data);
                                    $.each(obj, function() {
                                        seriid                 = this['tsnid'];
                                        yili                   = this['yili'];
                                        tipi                   = this['tiponay'];
                                        litresi                = this['litretanimi'];
                                    });
                                    $('#seriid').val(seriid);
                                    $('#yili').val(yili);                                    
                                    $('#tipi').val(tipi);                                    
                                    $('#litresi').val(litresi);                                    
                                    $('.table-responsive').hide();
                                    $('.table-responsive').show();
                                    $('.seribilgiekle').modal('show'); // show bootstrap modal when complete loaded
                            })
                            .fail(function(){
                            $('.table-responsive').html('Hata, Lütfen Tekrar Deneyin..');
                            });   
                        }   
                        /* İşlem Görüntüleme Başlangıç */
                        function seribilgiguncelle(id) {
                            alert(id);
                            $.ajax({
                            url: '<?php echo SITE_URL; ?>/seri/serinogetir',
                            type: 'POST',
                            data: 'id='+id,
                            dataType: 'json',
                            cache: false
                            })
                            .done(function(data){
                                    var obj = $.parseJSON(data);
                                    $.each(obj, function() {
                                        sntid               = this['sntid'];
                                        barkodno               = this['barkodno'];
                                        cap                    = this['cap'];
                                        yukseklik              = this['yukseklik'];
                                        litre                  = this['litre'];
                                        kg                     = this['kg'];
                                        g1                     = this['g1'];
                                        g2                     = this['g2'];
                                        k1                     = this['k1'];
                                        k2                     = this['k2'];
                                    });
                                    $('#serinoid').val(sntid);                                  
                                    $('#seriBarkodg').val(barkodno);                                  
                                    $('#seriCapg').val(cap);                                  
                                    $('#seriYukseklikg').val(yukseklik);                                  
                                    $('#seriLitreg').val(litre);                                  
                                    $('#seriKgg').val(kg);                                  
                                    $('#seriGovdeEnig').val(g1);                                  
                                    $('#seriGovdeBoyug').val(g2);                                  
                                    $('#seriKapakEnig').val(k1);                                  
                                    $('#seriKapakBoyug').val(k2);                                  
                                    $('.table-responsive').hide();
                                    $('.table-responsive').show();
                                    $('.seribilgiguncelle').modal('show'); // show bootstrap modal when complete loaded
                            })
                            .fail(function(){
                            $('.table-responsive').html('Hata, Lütfen Tekrar Deneyin..');
                            });   
                        }                           
                        // Seri Bilgi Kayıt Alanı
                        $(document).ready(function(){
                            $('#form_validation').submit(function(){
                                // show that something is loading
                                $('#alertAream').html('<div class="alert alert-info bg-info text-white"><img style="max-height:30px;" src="<?php echo SITE_URL; ?>/upload/img/loading.gif"> İşlem Gerçekleşiyor. Lütfen bekleyiniz...</div>');
                                var form = $('#form_validation')[0];
                                var forms= new FormData(form);
                                $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_URL; ?>/seri/seribilgikaydet',
                                enctype:'multipart/form-data',
                                processData: false,
                                contentType: false,
                                cache:false,
                                data:forms
                                })
                                .done(function(data){
                                // show the response
                                if(data=='bos'){
                                setTimeout(function(){$('#alertAream').html('<div class="alert alert-danger bg-danger text-white mb-0">Boş Kayıt Oluşturamazsınız.Lütfen ilgili alanları doldurarak işlem yapınız.</div>').fadeOut(2000);}, 2000);
                                }else{
                                setTimeout(function(){$('#alertAream').html(data).fadeOut(2000);}, 3000);                                
                                setInterval(function(){
                                    window.location.href = '<?php echo SITE_URL; ?>/seri/seriler/&ID=12';
                                }, 3000);
                                }
                                })
                                .fail(function() {
                                // just in case posting your form failed
                                alert( "Kayıt İşlemi Başarısız" );
                            });
                            // to prevent refreshing the whole page page
                            return false;
                            });
                            }); 
                     // Seri Bilgi Kayıt Alanı
                        $(document).ready(function(){
                            $('#form_validation_update').submit(function(){
                                // show that something is loading
                                $('#alertAream').html('<div class="alert alert-info bg-info text-white"><img style="max-height:30px;" src="<?php echo SITE_URL; ?>/upload/img/loading.gif"> İşlem Gerçekleşiyor. Lütfen bekleyiniz...</div>');
                                var form = $('#form_validation')[0];
                                var forms= new FormData(form);
                                $.ajax({
                                type: 'POST',
                                url: '<?php echo SITE_URL; ?>/seri/seribilgiguncelle',
                                enctype:'multipart/form-data',
                                processData: false,
                                contentType: false,
                                cache:false,
                                data:forms
                                })
                                .done(function(data){
                                // show the response
                                if(data=='bos'){
                                setTimeout(function(){$('#alertAream').html('<div class="alert alert-danger bg-danger text-white mb-0">Boş Kayıt Oluşturamazsınız.Lütfen ilgili alanları doldurarak işlem yapınız.</div>').fadeOut(2000);}, 2000);
                                }else{
                                setTimeout(function(){$('#alertAream').html(data).fadeOut(2000);}, 3000);                                
                                setInterval(function(){
                                    window.location.href = '<?php echo SITE_URL; ?>/seri/seriler/&ID=12';
                                }, 3000);
                                }
                                })
                                .fail(function() {
                                // just in case posting your form failed
                                alert( "Kayıt İşlemi Başarısız" );
                            });
                            // to prevent refreshing the whole page page
                            return false;
                            });
                            });                              
                    <?php } ?>                           
            </script>