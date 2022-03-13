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
                            <li class="breadcrumb-item active">Firmayı Cezalı Duruma Düşürme Alanı</li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-10">
                    <p class="text-white-50 m-b-30">Firmayı cezalı duruma düşürmek için aşağıdaki formdan kayıt yapabilirsiniz.</p>
                </div>
                <div class="col-md-2">
                    <a href ="<?php echo SITE_URL; ?>/mhfirma/malhizmetveren/&ID=11" title="Liste"><button class="btn btn-primary waves-effect waves-light pull-right" style="padding:5px;margin-right:10px;"><i style="font-size:2em;" class="mdi mdi-format-line-spacing"></i></button></a>
                    <a href ="javascript:history.back()"><button class="btn btn-warning waves-effect waves-light pull-right" style="padding:5px;margin-right:10px;"><i style="font-size:2em;" class="mdi mdi-reply-all"></i></button></a>
                </div>
            </div>
            <form id="form_validation" method="POST">
                <div class="row">
                <div class="col-lg-12">
                    <div class="card m-b-20">
                        <div class="card-body"> 
                            <div class="form-group">
                                <label>NEDENİNİ YAZIN</label>
                                <div>                                        
                                    <textarea name="cNot" lang="tr" onkeyup="this.value = this.value.buyukHarf();" placeholder="Not Yazınız" class="form-control" rows="3"></textarea>
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card m-b-20">
                        <div class="card-body" style="padding: 1.25rem 1.25rem 0rem 1.25rem;">
                            <div class="form-group">
                                <input type="hidden" name="firmaID" value="<?php echo $_REQUEST['ID']; ?>"  lang="tr" onkeyup="this.value = this.value.buyukHarf();" class="form-control">
                                <button type="submit" style="width: 100%;" class="btn btn-primary waves-effect waves-light mr-1">
                                    <i class="mdi mdi-content-save"></i> Cezalı Yap
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
            <script>
            $(document).ready(function(){
            $('#form_validation').submit(function(){
                // show that something is loading
                $('#alertArea').html('<div class="alert alert-info bg-info text-white"><img style="max-height:30px;" src="<?php echo SITE_URL; ?>/upload/img/loading.gif"> İşlem Gerçekleşiyor. Lütfen bekleyiniz...</div>');
                $.ajax({
                type: 'POST',
                url: '<?php echo SITE_URL; ?>/mhfirma/cezalikaydet',
                    data: $(this).serialize()
                })
                .done(function(data){
                // show the response
                if(data=='bos'){
                setTimeout(function(){$('#alertArea').html('<div class="alert alert-danger bg-danger text-white mb-0">Boş Kayıt Oluşturamazsınız.Lütfen ilgili alanları doldurarak işlem yapınız.</div>').fadeOut(2000);}, 2000);
                }else{
                setTimeout(function(){$('#alertArea').html(data).fadeOut(5000);}, 5000);
                
                setInterval(function(){
                    window.location.href = '<?php echo SITE_URL; ?>/mhfirma/malhizmetveren/&ID=11';
                }, 6000);
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