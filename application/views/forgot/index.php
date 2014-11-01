<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Project Management Dashboard - Lupa Password</title>
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
                    <div class="logo text-center">
                        <img src="<?= base_url();?>public/images/logo-primary.png" alt="Chain Logo" >
                    </div>
                    <h4 class="text-center mb5">Project Management Dashboard v1.0</h4>
                    <p class="text-center">Lupa password akun</p>
                    <div class="mb30"></div>
                    <form action="<?= base_url();?>forgot/init" method="post" id="form-reset-password">
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" placeholder="Username" name="username">
                        </div><!-- input-group -->
                        <div class="clearfix">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success">Submit <i class="fa fa-angle-right ml5"></i></button>
                            </div>
                        </div>                      
                    </form>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <a href="<?= base_url();?>authentication" class="btn btn-primary btn-block">Klik disini untuk login ke Aplikasi</a>
                </div><!-- panel-footer -->
            </div><!-- panel -->
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
                $('#form-reset-password').ajaxForm({
                    url: '<?=base_url();?>forgot/init', 
                    resetForm: true,
                    beforeSubmit: function(formData, jqForm, options){
                        var form = jqForm[0]; 
                        if (!form.username.value) { 
                            alert('Silahkan masukkan username anda terlebih dahulu!'); 
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
