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
                            <li class="breadcrumb-item active">Mal ve Hizmet Veren Firma Güncelleme</li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-10">
                    <p class="text-white-50 m-b-30">Mal ve Hizmet Veren Firma güncelleme için aşağıdaki formdan kayıt yapabilirsiniz.</p>
                </div>
                <div class="col-md-2">
                    <a href ="<?php echo SITE_URL; ?>/mhfirma/malhizmetveren/&ID=11" title="Liste"><button class="btn btn-primary waves-effect waves-light pull-right" style="padding:5px;margin-right:10px;"><i style="font-size:2em;" class="mdi mdi-format-line-spacing"></i></button></a>
                    <a href ="javascript:history.back()"><button class="btn btn-warning waves-effect waves-light pull-right" style="padding:5px;margin-right:10px;"><i style="font-size:2em;" class="mdi mdi-reply-all"></i></button></a>
                </div>
            </div>
            <form id="form_validation" method="POST">
                <div class="row">
                <div class="col-lg-6">
                    <div class="card m-b-20">
                        <div class="card-body">  
                                <div class="form-group">
                                    <label>YMM *</label>
                                    <div>
                                        <select class="form-control select2" id="mhfirmaMM" name="mhfirmaMM" data-live-search="true" required="">
                                            <option value="">Ymm Seç</option>
                                            <?php foreach ($malimusavirler as $key => $value): ?>
                                                <option value="<?php echo $value['MSID']; ?>" <?php if($mhfirmaduzenle[0]['YMMID']==$value['MSID']){ echo "selected"; } ?>><?php echo $value['MSADI']." ".$value['MSSOYADI']; ?></option>
                                            <?php endforeach ?>
                                        </select>                                         
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label>SMM *</label>
                                    <div>
                                        <select class="form-control select2" id="mhfirmaSM" name="mhfirmaSM" data-live-search="true" required="">
                                            <option value="">Ymm-Smm Seç</option>
                                            <?php foreach ($malimusavirler as $key => $value): ?>
                                                <option value="<?php echo $value['MSID']; ?>" <?php if($mhfirmaduzenle[0]['SMMID']==$value['MSID']){ echo "selected"; } ?>><?php echo $value['MSADI']." ".$value['MSSOYADI']; ?></option>
                                            <?php endforeach ?>
                                        </select>                                         
                                    </div>
                                </div>                                                                                                
                                <div class="form-group">
                                    <label>FİRMA ÜNVANI *</label>
                                    <div>
                                        <input type="text" value="<?=$mhfirmaduzenle[0]['FIRMAUNVANI']?>" lang="tr" required onkeyup="this.value = this.value.buyukHarf();" name="mhfirmaUnvani" class="form-control" placeholder="Firma Adını Yazın">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>YETKİLİ</label>
                                    <div>
                                        <input type="text" value="<?=$mhfirmaduzenle[0]['FIRMAYETKILI']?>" name="mhfirmaYetkili" lang="tr" onkeyup="this.value = this.value.buyukHarf();" class="form-control" placeholder="Yetkiliyi Yazın">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>VERGİ NO / TC NO *</label>
                                    <div>
                                        <input type="text" value="<?=$mhfirmaduzenle[0]['FIRMAVN']?>" require name="mhfirmaVN"  lang="tr" class="form-control" placeholder="Tc Kimlik veya Vergi Numarasını Yazın">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>VERGİ DAİRESİ</label>
                                    <div>
                                        <input type="text" value="<?=$mhfirmaduzenle[0]['FIRMAVD']?>" name="mhfirmaVD" class="form-control" onkeyup="this.value = this.value.buyukHarf();" placeholder="Vergi Dairesini Yazınız">
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label>FİRMA DURUMU</label>
                                    <div>
                                        <select class="form-control show-tick" id="mhfirmaDurum" name="mhfirmaDurum" data-live-search="true" required="">
                                            <option value="">Durum Seç</option>
                                            <?php if($mhfirmaduzenle[0]['FIRMADURUM']==1){ ?>
                                                <option value="1" selected>Aktif</option>
                                                <option value="0">Pasif</option>
                                            <?php }elseif($mhfirmaduzenle[0]['FIRMADURUM']==0){ ?>
                                                <option value="1">Aktif</option>
                                                <option value="0" selected>Pasif</option>
                                            <?php }else{ ?>
                                                <option value="1">Aktif</option>
                                                <option value="0">Pasif</option>
                                            <?php } ?>
                                        </select>                                         
                                    </div>
                                </div>                             
                        </div>
                    </div>
                </div> <!-- end col -->
                <div class="col-lg-6">
                    <div class="card m-b-20">
                        <div class="card-body">
                                <div class="form-group">
                                    <label>TELEFON NO *</label>
                                    <div>
                                        <input type="text" value="<?=$mhfirmaduzenle[0]['FIRMATEL']?>" id="mhfirmaTel" name="mhfirmaTel" required class="form-control" placeholder="Telefon Numarasını Yazınız">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>E-POSTA</label>
                                    <div>
                                        <input type="text" value="<?=$mhfirmaduzenle[0]['FIRMAEPOSTA']?>" name="mhfirmaEPosta" id="mhfirmaEPosta" class="form-control" placeholder="E-Posta Adresini Yazın">
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label>ADRES</label>
                                    <div>
                                        <textarea name="mhfirmaAdres" lang="tr" onkeyup="this.value = this.value.buyukHarf();" placeholder="Mal ve Hizmet Veren Firma Adresini Yazınız" class="form-control" rows="2"><?=$mhfirmaduzenle[0]['FIRMAADRES']?></textarea>
                                    </div>
                                </div>                                    
                                <div class="form-group">
                                    <label>NOT</label>
                                    <div>
                                        <textarea name="mhfirmaNot" lang="tr" onkeyup="this.value = this.value.buyukHarf();" placeholder="Mal ve Hizmet Veren Firma Hakkında Bilgi Yazınız" class="form-control" rows="3"><?=$mhfirmaduzenle[0]['FIRMANOT']?></textarea>
                                    </div>
                                </div>                                        
                        </div>
                    </div>
                </div> <!-- end col -->
                <div class="col-lg-12">
                    <div class="card m-b-20">
                        <div class="card-body" style="padding: 1.25rem 1.25rem 0rem 1.25rem;">
                            <div class="form-group">
                                <input type="hidden" value="<?=$mhfirmaduzenle[0]['MHVID']?>" name="FIRMAID">
                                <button type="submit" style="width: 100%;" class="btn btn-primary waves-effect waves-light mr-1">
                                    <i class="mdi mdi-content-save"></i> Kaydet
                                </button>
                            </div>     
                        </div>
                    </div>
                </div>
                <div id="alertArea"></div>
            </div>            
            </form>
            </div>
            </div>
            </div>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>            

            <script>
            $(document).ready(function(){          
                $(document).ready(function(){
                document.getElementById('mhfirmaTel').addEventListener('input', function (e) {
                var x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,3})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
            });
            }); 
            $('#form_validation').submit(function(){
                // show that something is loading
                $('#alertArea').html('<div class="alert alert-info bg-info text-white"><img style="max-height:30px;" src="<?php echo SITE_URL; ?>/upload/img/loading.gif"> İşlem Gerçekleşiyor. Lütfen bekleyiniz...</div>');
                $.ajax({
                type: 'POST',
                url: '<?php echo SITE_URL; ?>/mhfirma/mhfirmaguncelle',
                    data: $(this).serialize()
                })
                .done(function(data){
                // show the response
                if(data=='bos'){
                setTimeout(function(){$('#alertArea').html('<div class="alert alert-danger bg-danger text-white mb-0">Boş Kayıt Oluşturamazsınız.Lütfen ilgili alanları doldurarak işlem yapınız.</div>').fadeOut(2000);}, 2000);
                }else{
                setTimeout(function(){$('#alertArea').html(data).fadeOut(2000);}, 2000);
                
                setInterval(function(){
                    window.location.href = '<?php echo SITE_URL; ?>/mhfirma/malhizmetveren/&ID=11';
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
            </script>
            <script type="text/javascript">
            String.prototype.buyukHarf=function() {
            var str = [];
            for(var i = 0; i < this.length; i++) {
            var ch = this.charCodeAt(i);
            var c = this.charAt(i);
            if(ch == 105) str.push('İ');
            else if(ch == 305) str.push('I');
            else if(ch == 287) str.push('Ğ');
            else if(ch == 252) str.push('Ü');
            else if(ch == 351) str.push('Ş');
            else if(ch == 246) str.push('Ö');
            else if(ch == 231) str.push('Ç');
            else if(ch >= 97 && ch <= 122) str.push(c.toUpperCase());
            else str.push(c);
            }
            return str.join('');
            }
            // Sadece Rakam
            function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
            // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
            }            
            </script>                        