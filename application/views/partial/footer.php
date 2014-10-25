            </div>
        </section>       

        <script src="<?= base_url();?>public/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?= base_url();?>public/js/bootstrap.min.js"></script>
        <script src="<?= base_url();?>public/js/modernizr.min.js"></script>
        <script src="<?= base_url();?>public/js/pace.min.js"></script>
        <script src="<?= base_url();?>public/js/retina.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.cookies.js"></script>
        
        <script src="<?= base_url();?>public/js/flot/jquery.flot.min.js"></script>
        <script src="<?= base_url();?>public/js/flot/jquery.flot.resize.min.js"></script>
        <script src="<?= base_url();?>public/js/flot/jquery.flot.spline.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.sparkline.min.js"></script>
        <script src="<?= base_url();?>public/js/morris.min.js"></script>
        <script src="<?= base_url();?>public/js/raphael-2.1.0.min.js"></script>
        <script src="<?= base_url();?>public/js/bootstrap-wizard.min.js"></script>
        <script src="<?= base_url();?>public/js/select2.min.js"></script>
        <script src="<?= base_url();?>public/js/moment.min.js"></script>
        <script src="<?= base_url();?>public/js/locale/id.js"></script>


        <script src="<?= base_url();?>public/js/custom.js"></script>
        <!-- <script src="<?= base_url();?>public/js/dashboard.js"></script> -->


        <!-- custom script -->
        <script src="<?= base_url();?>public/js/director.js"></script>

        <script type="text/javascript">

          $(document).ready(function(){

            var routes = {
              '/home' : home
              // '/projects' : projects,
              // '/project/view/:id' : projectDetail,
              // '/task/view/:id' : taskDetail,
              // '/users' : users,
              // '/my-profile' : myProfile,
            }
            
            var router = Router(routes);

            router.init('/home');
          });

          //moment
          moment().locale('id');
          $('.leftpanel-title').text(moment().format('dddd, Do MMMM YYYY'));


          function home(){
            $.ajax({
              url: '<?php echo base_url();?>home'
            })
            .done(function(response, textStatus, jqhr){
              //initView('user-management-list-user','Enterprise Asset Management | User List');
              $('#home-index').html(response);
            }) 
            .fail(function(e){

            });
          }
    
        </script>
    </body>
</html>