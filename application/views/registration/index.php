<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Project Management Dashboard - Registrasi</title>

        <link href="<?= base_url();?>public/css/style.default.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="signin">
        
        
        <section>                            

          <form action="<?= base_url();?>registration/register" method="post" id="fm-registration">
            <div class="panel panel-signin">
                <div class="panel-heading">
                  <h3>Pendaftaran</h3>
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi. <span class="info-exception" style="display:none;">Silahkan isi kolom password apabila <strong>INGIN</strong> mengubah password.</span></p>
                </div>
                <div class="panel-body">
                  <div class="errorForm"></div>
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Username<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="username" class="form-control" required title="Kolom Username wajib diisi!" placeholder="Huruf semua, tanpa spasi"/>
                      </div>
                  </div><!-- form-group -->
              
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Nama<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="name" class="form-control" required title="Kolom Nama wajib diisi!" placeholder="Isi nama lengkap anda" />
                      </div>
                  </div><!-- form-group -->

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Password<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="password" name="password" class="form-control" required title="Kolom Password wajib diisi!" placeholder="Minimal 6 karakter" />
                      </div>
                  </div><!-- form-group -->


                  <div class="form-group">
                      <label class="col-sm-4 control-label">Afiliasi<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="affiliation" class="form-control" required title="Kolom Afiliasi wajib diisi!" placeholder="Isi dengan nama perusahaan anda" />
                      </div>
                  </div><!-- form-group -->

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Email<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="email" name="email" class="form-control" required title="Kolom Email wajib diisi dan harus valid!" placeholder="Isikan email aktif anda"/>
                      </div>
                  </div><!-- form-group -->

                  <!-- Hidden Field -->
                  <input type="hidden" name="id" value="-1" />
                  <input type="hidden" name="is-edit" value="0" />
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-primary mr5" type="submit" id="btn-submit-registration">Submit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <div class="mb30"></div>
                    <p>
                      Sudah mempunyai akun?<a href="<?=base_url();?>authentication">Login</a>
                    </p>
                </div><!-- panel-footer -->
            </div><!-- panel -->
          </form>
        </section>


        <script src="<?= base_url();?>public/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?= base_url();?>public/js/bootstrap.min.js"></script>
        <script src="<?= base_url();?>public/js/modernizr.min.js"></script>
        <script src="<?= base_url();?>public/js/pace.min.js"></script>
        <script src="<?= base_url();?>public/js/retina.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.cookies.js"></script>
        <script src="<?= base_url();?>public/js/jquery.validate.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.form.min.js"></script>
        <script src="<?= base_url();?>public/js/custom.js"></script>

        <script type="text/javascript">
          $('#fm-registration').ajaxForm({
            dataType: 'json',
            beforeSend: function(){
              $('#btn-submit-registration').html('Memproses...');
              $('#btn-submit-registration').attr('disable','disable');
            },
            success: function(a,b,c,d){
              if(a.status == 'ok'){
                window.location.replace("<?=base_url();?>registration/success");
              } else if (a.status == 'param'){
                alert(a.message);
              } else {
                alert('Server sedang ada gangguan, silahkan coba lagi nanti...');
              }

              $('#btn-submit-registration').html('Submit');
              $('#btn-submit-registration').removeAttr('disable');
            },
            error: function(){
              alert('Server sedang ada gangguan, silahkan coba lagi nanti...');
              $('#btn-submit-registration').html('Submit');
              $('#btn-submit-registration').removeAttr('disable');
            }
          });
        </script>

    </body>
</html>
