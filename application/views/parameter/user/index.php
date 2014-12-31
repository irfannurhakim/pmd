<div class="media-options">
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default add-data btn-sm" data-toggle="modal" data-target=".bs-example-modal"><i class="fa fa-plus rm5"></i> Tambah Pengguna</button>
      </div>
    </div>
  </div>
</div>
<hr/>

<div class="container-dt">
  <table id="table-list-users" class="table table-hover table-bordered responsive">
    <thead class="">
      <tr>
        <th>Username</th>
        <th>Tipe Pengguna</th>
        <th>Nama</th>
        <th>Afiliasi</th>
        <th>Email</th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($users as $row) { ?>
      <tr>
          <td><?php echo $row['USERNAME'];?></td>
          <td><?php echo $row['TIPE'];?></td>
          <td><?php echo $row['NAME'];?></td>
          <td><?php echo $row['AFFILIATION'];?></td>
          <td><?php echo $row['EMAIL'];?></td>
          <td class="dt-cols-center">
            <a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="<?php echo $row['ID'];?> "><i class="fa fa-pencil"></i></a>
            <a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="<?php echo $row['ID'];?>"><i class="fa fa-trash-o"></i></a>
          </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<div class="modal fade bs-example-modal" tabindex="-1" role="dialog" id="modal-add-user" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Tambah Pengguna</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" id="form-add-user" method="POST" action="<?= base_url();?>user/add">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi. <span class="info-exception" style="display:none;">Silahkan isi kolom password apabila <strong>INGIN</strong> mengubah password.</span></p>
                </div>
                <div class="panel-body">
                  <div class="errorForm"></div>
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Username<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="username" class="form-control" required title="Kolom Username wajib diisi!" />
                      </div>
                  </div><!-- form-group -->
              
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Nama<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="name" class="form-control" required title="Kolom Nama wajib diisi!" />
                      </div>
                  </div><!-- form-group -->

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Password<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="password" name="password" class="form-control" required title="Kolom Password wajib diisi!" />
                      </div>
                  </div><!-- form-group -->


                  <div class="form-group">
                      <label class="col-sm-4 control-label">Afiliasi<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="affiliation" class="form-control" required title="Kolom Afiliasi wajib diisi!" />
                      </div>
                  </div><!-- form-group -->

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Email<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="email" name="email" class="form-control" required title="Kolom Email wajib diisi dan harus valid!" />
                      </div>
                  </div><!-- form-group -->

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Tipe Pengguna</label>
                      <div class="col-sm-8">
                          <select id="select-id-user-type" data-placeholder="Pilih tipe user" class="width300" name="id-user-type">
                            <?php foreach ($user_type as $row) { ?>
                                <option value="<?php echo $row['ID'];?>"><?php echo $row['NAME'];?></option>
                            <?php }; ?>                                          
                          </select>
                      </div>
                  </div><!-- form-group -->

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Terverifikasi</label>
                      <div class="col-sm-8">
                          <select id="select-verification-type" data-placeholder="Terverifikasi?" class="width300" name="is-verified">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                          </select>
                      </div>
                  </div><!-- form-group -->
                  <!-- Hidden Field -->
                  <input type="hidden" name="id" value="-1" />
                  <input type="hidden" name="is-edit" value="0" />
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-primary mr5" type="submit" id="btn-submit-user">Submit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div><!-- panel-footer -->
              </div><!-- panel-default -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

  $(document).ready(function(){

    jQuery('#table-list-users').DataTable({
      "responsive": false
    });

    // Show aciton upon row hover
    jQuery('.table tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1},100);
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0},100);
    });

    jQuery('#select-id-user-type, #select-verification-type').select2({
      minimumResultsForSearch: -1
    });

    $('.add-data').click(function(){
      $('#modal-add-user').find('.modal-title').text('Tambah Pengguna');
      $('#form-add-user')[0].reset();

      //add required
      $("input[name='password']").attr('required', true);

      //info
      $('.info-exception').hide();
    });

    // Validation
    jQuery("#form-add-user").validate({
      errorLabelContainer: jQuery("#form-add-user div.errorForm")
    });

    // Submit add user
    $('#form-add-user').ajaxForm({
      dataType: 'json',
      beforeSend: function(){
        $('#btn-submit-user').html('Menyimpan...');
        $('#btn-submit-user').attr('disable','disable');
      },
      success: function(a,b,c,d){
        if(a.status == 'ok'){
          jQuery.gritter.add({
            title: 'Info',
            text: 'Berhasil simpan data',
            class_name: 'growl-info',
            image: false,
            sticky: false,
            time: ''
          });

          $('#modal-add-user').modal('hide');
          $('.modal-backdrop').hide();
          users();
        } else {
          jQuery.gritter.add({
            title: 'Upss..',
            text: 'Terjadi kesalahan, silahkan refresh browser',
            class_name: 'growl-danger',
            image: false,
            sticky: false,
            time: ''
          });
        }

        $('#btn-submit-user').html('Submit');
        $('#btn-submit-user').removeAttr('disable');
      },
      error: function(){
        jQuery.gritter.add({
          title: 'Upss..',
          text: 'Terjadi kesalahan, silahkan refresh browser',
          class_name: 'growl-danger',
          image: false,
          sticky: false,
          time: ''
        });

          
        $('#btn-submit-user').html('Submit');
        $('#btn-submit-user').removeAttr('disable');
      }
    });

    // Function when button edit triggered
    $('#table-list-users').delegate('.edit-row', 'click', function(){
      var id = $(this).attr('object');
      $.ajax({
        url: '<?=base_url();?>user/view/' + id,
        dataType: 'json'
      })
      .done(function(a){
        if(a.status == 0){
          var user = a.data;

          //edit form
          $('#modal-add-user').find('.modal-title').text('Edit Pengguna');
          $('#form-add-user')[0].reset();
          $("input[name='password']").removeAttr('required');
          //info
          $('.info-exception').show();

          //fill form
          $("input[name='id']").val(user.ID);
          $("input[name='name']").val(user.NAME);
          $("input[name='username']").val(user.USERNAME);
          $("input[name='affiliation']").val(user.AFFILIATION);
          $("input[name='email']").val(user.EMAIL);
          $("#select-id-user-type").select2("val", user.ID_USER_TYPE);
          $("#select-verification-type").select2("val", user.IS_VERIFIED);
          $("input[name='is-edit']").val(1);

          //show modal
          $('#modal-add-user').modal('show');
        }
      })
      .fail(function(){

      });
    });

    // Delete row in a table
    $('#table-list-users').delegate('.delete-row', 'click', function(){
      var id = $(this).attr('object');
      var c = confirm("Apakah anda yakin untuk menghapus data ini?");
      if(c){
        $.ajax({
          url: '<?=base_url();?>user/remove/' + id,
          dataType: 'json'
        })
        .done(function(a){
          if(a.status == 0){
          }

          users();
        })
        .fail(function(e){
          alert(e);
        });
      }
      return false;
    });
  });

</script>
