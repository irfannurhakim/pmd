<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Project Management Dashboard - Change Password</title>
        <link href="<?= base_url();?>public/css/style.default.css" rel="stylesheet">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="signin">       
        <section>   
            <div class="panel panel-signin">
                <div class="panel-body">
                    <h4 class="text-center mb5">Perubahan Password</h4>
                    <div class="mb30"></div>
                    <form action="<?= base_url();?>forgot/change_pass_init" method="post" id="form-change-password">
                       <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="text" class="form-control" placeholder="Email" name="email" value="<?=$email;?>" />
                        </div>
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Password Lama" name="password">
                        </div>
                        <hr />
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
                            <input type="password" class="form-control" placeholder="Password Baru" name="new_password">
                        </div>
                         <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
                            <input type="password" class="form-control" placeholder="Ulangi Password Baru" name="conf_new_password">
                        </div>
                        <div class="clearfix">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success">Submit <i class="fa fa-angle-right ml5"></i></button>
                            </div>
                        </div>                      
                    </form>
                </div>
                <div class="panel-footer">
                    <a href="<?= base_url();?>authentication" class="btn btn-primary btn-block">Klik disini untuk login ke Aplikasi</a>
                </div>
            </div>
        </section>
        <script src="<?= base_url();?>public/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?= base_url();?>public/js/bootstrap.min.js"></script>
        <script src="<?= base_url();?>public/js/modernizr.min.js"></script>
        <script src="<?= base_url();?>public/js/pace.min.js"></script>
        <script src="<?= base_url();?>public/js/retina.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.cookies.js"></script>
        <script src="<?= base_url();?>public/js/custom.js"></script>
        <script src="<?= base_url();?>public/js/jquery.form.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#form-change-password').ajaxForm({
                    url: '<?=base_url();?>forgot/change_pass_init', 
                    resetForm: false,
                    beforeSubmit: function(formData, jqForm, options){
                        var form = jqForm[0]; 
                        if (!form.email.value) { 
                            alert('Silahkan masukkan email !'); $('input[name=email]').focus();
                            return false; 
                        }
                        if (!form.password.value) { 
                            alert('Silahkan masukkan password lama !'); $('input[name=password]').focus();
                            return false; 
                        }
                        if (!form.new_password.value) { 
                            alert('Silahkan masukkan password baru !'); $('input[name=new_password]').focus();
                            return false; 
                        }
                        if (form.new_password.value != form.conf_new_password.value) { 
                            alert('Password baru tidak sama dengan konfirmasi password baru !'); 
                            return false; 
                        }

                    },
                    success: function(responseText, statusText, xhr, $form){
                        alert(responseText);  
                    },
                    error: function(){
                        alert('Terjadi kesalahan, silahkan Refresh Halaman ini.');
                    }
                });
            });
        </script>
    </body>
</html>
