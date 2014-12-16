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

        <script src="<?= base_url();?>public/js/jquery.autogrow-textarea.js"></script>
        <script src="<?= base_url();?>public/js/jquery.mousewheel.js"></script>
        <script src="<?= base_url();?>public/js/jquery.tagsinput.min.js"></script>
        <script src="<?= base_url();?>public/js/toggles.min.js"></script>

        <script src="<?= base_url();?>public/js/flot/jquery.flot.min.js"></script>
        <script src="<?= base_url();?>public/js/flot/jquery.flot.resize.min.js"></script>
        <script src="<?= base_url();?>public/js/flot/jquery.flot.spline.min.js"></script>
        <script src="<?= base_url();?>public/js/jquery.sparkline.min.js"></script>
        <script src="<?= base_url();?>public/js/morris.min.js"></script>
        <script src="<?= base_url();?>public/js/raphael-2.1.0.min.js"></script>

        <!-- <script type="text/javascript" src="<?=base_url();?>public/js/dataTables.fixedHeader.js"></script> -->
        <script type="text/javascript" src="<?=base_url();?>public/js/dataTables.fixedColumns.min.js"></script>
        <script type="text/javascript" src="<?=base_url();?>public/js/owl.carousel.min.js"></script>

        <script src="<?= base_url();?>public/js/custom.js"></script>

        <!-- custom script -->
        <script src="<?= base_url();?>public/js/director.min.js"></script>
        <script type="text/javascript">

          var APP_TITLE = "Project Management Dashboard";

          $(document).ready(function(){

            var routes = {
              '/home' : home,
              '/projects' : projects,
              '/items' : items,
              '/project/view/:id' : projectDetail,
              '/item/project/:id' : itemProject,
              '/item/periode/:id' : itemPeriode,
             // '/items/view/:id' : itemDetail,
              '/users' : users,
              // '/my-profile' : myProfile,
              '/quick_access' : quickAccess,
              '/notices' : notices,
              '/realisasi/:id' : itemRealization
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

          function itemPeriode(id){
            var idElement = '#item-periode';
            $.ajax({
              url: '<?php echo base_url();?>item_task/periode/' + id,
              beforeSend: function(){
                activateMenu('projects');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Daftar Periode Pekerjaan');
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

          function notices(){
            var idElement = '#notice-list';
            $.ajax({
              url: '<?php echo base_url();?>notice',
              beforeSend: function(){
                activateMenu('settings, #menu-notices');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Daftar Surat');
              $(idElement).html(response);
            }) 
            .fail(function(e){

            });
          } 

          function itemRealization(id){
            var idElement = '#item-realization';
            $.ajax({
              url: '<?php echo base_url();?>quick_access/realization/' + id,
              beforeSend: function(){
                activateMenu('quick-access');
              }
            })
            .done(function(response, textStatus, jqhr){
              initView(idElement,APP_TITLE + ' - Realisasi Pekerjaan');
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

          $('#form-update-profile').ajaxForm({
            dataType: 'json',
            success: function(a,b,c,d){
              if(a.error){
                jQuery.gritter.add({
                  title: 'Upss..',
                  text: a.error,
                  class_name: 'growl-danger',
                  image: false,
                  sticky: false,
                  time: ''
                });
              } else {
                if(a.status == 'ok'){
                  jQuery.gritter.add({
                    title: 'Info',
                    text: 'Simpan perubahan berhasil.',
                    class_name: 'growl-info',
                    image: false,
                    sticky: false,
                    time: ''
                  });

                  if(a.data.profile_image_url){
                    $('.my-profile-picture').attr('src', '<?=base_url();?>' + a.data.profile_image_url);
                  }

                  $('.my-profile-name').html(a.data.name);
                  $('.my-profile-affiliation').html(a.data.affiliation);
                  $('#field-update-profile-picture').val('');
                } else {
                  jQuery.gritter.add({
                    title: 'Upss..',
                    text: 'Terjadi kesalahan! Refresh kembali browsernya...',
                    class_name: 'growl-danger',
                    image: false,
                    sticky: false,
                    time: ''
                  });
                }
              }

              $('#btn-update-profile').html('Submit');
            },
            error: function(e){
              jQuery.gritter.add({
                title: 'Upss..',
                text: 'Terjadi kesalahan! Refresh kembali browsernya...',
                class_name: 'growl-danger',
                image: false,
                sticky: false,
                time: ''
              });
            },
            uploadProgress: function(e,position,total,percentComplete){
              $('#btn-update-profile').html('Menyimpan... ' + percentComplete + " %");
            }
          });

          $('#form-change-password').ajaxForm({
            clearForm: true,
            dataType: 'json',
            success: function(a,b,c,d){
              if(a.error){
                jQuery.gritter.add({
                  title: 'Upss..',
                  text: a.error,
                  class_name: 'growl-danger',
                  image: false,
                  sticky: false,
                  time: ''
                });
              } else {
                if(a.status == 'ok'){
                  jQuery.gritter.add({
                    title: 'Info',
                    text: 'Simpan perubahan berhasil.',
                    class_name: 'growl-info',
                    image: false,
                    sticky: false,
                    time: ''
                  });
                } else {
                  jQuery.gritter.add({
                    title: 'Upss..',
                    text: a.message,
                    class_name: 'growl-danger',
                    image: false,
                    sticky: false,
                    time: ''
                  });
                }
              }
            },
            error: function(e){
              jQuery.gritter.add({
                title: 'Upss..',
                text: 'Terjadi kesalahan! Refresh kembali browsernya...',
                class_name: 'growl-danger',
                image: false,
                sticky: false,
                time: ''
              });
            }
          });
        </script>

        <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['gauge']}]}"></script>

    </body>
</html>