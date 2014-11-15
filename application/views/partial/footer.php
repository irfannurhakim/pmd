            </div>
        </section>       

        <script src="<?= base_url();?>public/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery-ui-1.10.3.min.js"></script>
        <script src="<?= base_url();?>public/js/bootstrap.min.js"></script>
        <script src="<?= base_url();?>public/js/modernizr.min.js"></script>
        <script src="<?= base_url();?>public/js/pace.min.js"></script>
        <script src="<?= base_url();?>public/js/retina.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.cookies.js"></script>
        <script src="<?= base_url();?>public/js/select2.min.js"></script>
        <script src="<?= base_url();?>public/js/moment.min.js"></script>
        <script src="<?= base_url();?>public/js/locale/id.js"></script>
        <script src="<?= base_url();?>public/js/jquery.validate.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.form.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.dataTables.min.js"></script>
        <script src="<?= base_url();?>public/js/dataTables.bootstrap.js"></script>
        <script src="<?= base_url();?>public/js/dataTables.responsive.js"></script>
        <script src="<?= base_url();?>public/js/jquery.dataTables.reload.ajax.min.js"></script>
        <script src="<?= base_url();?>public/js/bootstrap-timepicker.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.priceFormat.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.gritter.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.prettyPhoto.js"></script>
        <script src="<?= base_url();?>public/js/holder.js"></script>

<!--
        <script src="<?= base_url();?>public/js/jquery.autogrow-textarea.js"></script>
        <script src="<?= base_url();?>public/js/jquery.mousewheel.js"></script>
        <script src="<?= base_url();?>public/js/jquery.tagsinput.min.js"></script>
        <script src="<?= base_url();?>public/js/toggles.min.js"></script>
        <script src="<?= base_url();?>public/js/bootstrap-timepicker.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.maskedinput.min.js"></script>
        <script src="<?= base_url();?>public/js/select2.min.js"></script>
        <script src="<?= base_url();?>public/js/colorpicker.js"></script>
        <script src="<?= base_url();?>public/js/dropzone.min.js"></script> 
-->
        <script src="<?= base_url();?>public/js/custom.js"></script>
        <!-- <script src="<?= base_url();?>public/js/dashboard.js"></script> -->

        <!-- custom script -->
        <script src="<?= base_url();?>public/js/director.js"></script>
        <script type="text/javascript">

          var APP_TITLE = "Project Management Dashboard";

          $(document).ready(function(){

            var routes = {
              '/home' : home,
              '/projects' : projects,
              '/items' : items,
              '/project/view/:id' : projectDetail,
              '/item/project/:id' : itemProject,
             // '/items/view/:id' : itemDetail,
              '/users' : users,
              // '/my-profile' : myProfile,
              '/quick_access' : quickAccess
            }
            
            var router = Router(routes).configure({
              'notfound' : notfound
            });

            router.init('<?php echo $initRoute;?>');
          });

          //moment
          moment().locale('id');
          $('.leftpanel-title').text(moment().format('dddd, Do MMMM YYYY'));

          function activateMenu(idElement){
            $('.activable').removeClass('active parent-focus');
            $('#menu-' + idElement).addClass('active');
          }

          function initView(idToShow, docTitle){
            $('.page-content').hide();
            $('.page-content').empty();
            $(idToShow).show();
            document.title = docTitle;
          }

          function home(){
            var idElement = '#home-index';
            $.ajax({
              url: '<?php echo base_url();?>home',
              beforeSend: function(){
                activateMenu('home');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Dashboard');
              $(idElement).html(response);
            }) 
            .fail(function(e){

            });
          }

          function projects(){
            var idElement = '#project-list';
            $.ajax({
              url: '<?php echo base_url();?>project',
              beforeSend: function(){
                activateMenu('projects');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Daftar Proyek');
              $(idElement).html(response);
            }) 
            .fail(function(e){

            });
          }

           function items(){
            var idElement = '#item-list';
            $.ajax({
              url: '<?php echo base_url();?>item_task',
              beforeSend: function(){
                activateMenu('items');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Daftar Item Project');
              $(idElement).html(response);
            }) 
            .fail(function(e){

            });
          }

          function projectDetail(id){
            var idElement = '#project-detail';
            $.ajax({
              url: '<?php echo base_url();?>project/view/' + id,
              beforeSend: function(){
                activateMenu('projects');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Detail Proyek');
              $(idElement).html(response);
            }) 
            .fail(function(e){

            });
          }

          function users(){
            var idElement = '#user-list';
            $.ajax({
              url: '<?php echo base_url();?>user',
              beforeSend: function(){
                activateMenu('settings, #menu-users');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Daftar Pengguna');
              $(idElement).html(response);
            }) 
            .fail(function(e){

            });
          } 

          function itemProject(id){
            var idElement = '#item-list';
            $.ajax({
              url: '<?php echo base_url();?>item_task/project/' + id,
              beforeSend: function(){
                activateMenu('projects');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Daftar Item Pekerjaan');
              $(idElement).html(response);
            }) 
            .fail(function(e){

            });
          }

          function quickAccess(){
            var idElement = '#quick-access';
            $.ajax({
              url: '<?php echo base_url();?>/quick_access',
              beforeSend: function(){
                activateMenu('quick-access');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Akses Cepat');
              $(idElement).html(response);
            }) 
            .fail(function(e){

            });            
          }

          function notfound(){
            var idElement = '#error-404';
            initView(idElement,APP_TITLE + ' - 404');
            $(idElement).html("<center><h3>404 Halaman tidak ditemukan!</h3></center>");
          }

          $('body').tooltip({
            selector: '[data-toggle=tooltip]'
          });
    
        </script>
    </body>
</html>