<div>
  <button class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal">Tambah Pengguna</button>
</div>

<table id="table-list-users" class="table table-striped table-bordered responsive">
  <thead class="">
    <tr>
      <th width="50px">Id</th>
      <th>Username</th>
      <th>Name</th>
      <th>Affiliation</th>
      <th>Email</th>
      <th></th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($users as $row) { ?>
    <tr>
        <td><?php echo $row['ID'];?></td>
        <td><?php echo $row['USERNAME'];?></td>
        <td><?php echo $row['NAME'];?></td>
        <td><?php echo $row['AFFILIATION'];?></td>
        <td><?php echo $row['EMAIL'];?></td>
        <td class="dt-cols-center table-action-hide">
          <a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="<?php echo $row['ID'];?> "><i class="fa fa-pencil"></i></a>
          <a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="<?php echo $row['ID'];?>"><i class="fa fa-trash-o"></i></a>
        </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

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
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-primary mr5" type="submit">Submit</button>
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
      "responsive": true
    });

    // Show aciton upon row hover
    jQuery('.table tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1},100);
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0},100);
    });

    jQuery('#select-id-user-type').select2({
      minimumResultsForSearch: -1
    });

    // Validation
    jQuery("#form-add-user").validate({
      errorLabelContainer: jQuery("#form-add-user div.errorForm")
    });

    $('#form-add-user').ajaxForm({
      success: function(a,b,c,d){
        $('#modal-add-user').modal('hide');
        $(".modal-backdrop").hide();
        users();
      }
    });

    // Delete row in a table
    jQuery('.delete-row').click(function(){
      var id = $(this).attr('object');
      var c = confirm("Apakah anda yakin untuk menghapus data ini?");
      if(c){
        $.ajax({
          url: '<?=base_url();?>user/remove/' + id
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
