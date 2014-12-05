<div class="media-options">
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default add-data btn-sm" data-toggle="modal" data-target=".bs-example-modal"><i class="fa fa-plus rm5"></i> Tambah Data</button>
      </div>
    </div>
  </div>
</div>
<hr/>

<div class="container-dt">
  <table id="table-list-notice" class="table table-hover table-bordered responsive">
    <thead class="">
      <tr>
        <th width="200px">Nama</th>
        <th>Deskripsi</th>
        <th width="25px"></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($notice as $row) { ?>
      <tr>
          <td><?php echo $row['NAME'];?></td>
          <td><?php echo $row['DESCRIPTION'];?></td>
          <td class="dt-cols-center">
            <a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="<?php echo $row['ID'];?> "><i class="fa fa-pencil"></i></a>
            <a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="<?php echo $row['ID'];?>"><i class="fa fa-trash-o"></i></a>
          </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<div class="modal fade bs-example-modal" tabindex="-1" role="dialog" id="modal-add-notice" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Tambah Data</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" id="form-add-notice" method="POST" action="<?= base_url();?>notice/add">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
                        <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                    </div><!-- panel-btns -->
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                </div>
                <div class="panel-body">
                  <div class="errorForm"></div>
             
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Nama<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="name" class="form-control" required title="Kolom Nama wajib diisi!" />
                      </div>
                  </div><!-- form-group -->

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Deskripsi</label>
                      <div class="col-sm-8">
                        <textarea rows="3" name="description" class="form-control" ></textarea>
                      </div>
                  </div><!-- form-group -->

                  <!-- Hidden Field -->
                  <input type="hidden" name="id" value="-1" />
                  <input type="hidden" name="is-edit" value="0" />
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

    jQuery('#table-list-notice').DataTable({
      "responsive": true
    });

    // Show aciton upon row hover
    jQuery('.table tbody tr').hover(function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 1},100);
    },function(){
      jQuery(this).find('.table-action-hide a').animate({opacity: 0},100);
    });


    $('.add-data').click(function(){
      $('#modal-add-notice').find('.modal-title').text('Tambah Data');
      $('#form-add-notice')[0].reset();

      //info
      $('.info-exception').hide();
    });

    // Validation
    jQuery("#form-add-notice").validate({
      errorLabelContainer: jQuery("#form-add-notice div.errorForm")
    });

    // Submit add user
    $('#form-add-notice').ajaxForm({
      success: function(a,b,c,d){
        $('#modal-add-notice').modal('hide');
        $('.modal-backdrop').hide();
        notices();
      }
    });

    // Function when button edit triggered
    $('.edit-row').click(function(){
      var id = $(this).attr('object');
      $.ajax({
        url: '<?=base_url();?>notice/view/' + id,
        dataType: 'json'
      })
      .done(function(a){
        if(a.status == 'ok'){
          var notice = a.data;

          //edit form
          $('#modal-add-notice').find('.modal-title').text('Edit Pengguna');
          $('#form-add-notice')[0].reset();

          //info
          $('.info-exception').show();

          //fill form
          $("input[name='id']").val(notice.ID);
          $("input[name='name']").val(notice.NAME);
          $("textarea[name='description']").text(notice.DESCRIPTION);
          $("input[name='is-edit']").val(1);

          //show modal
          $('#modal-add-notice').modal('show');
        }
      })
      .fail(function(){

      });
    });

    // Delete row in a table
    jQuery('.delete-row').click(function(){
      var id = $(this).attr('object');
      var c = confirm("Apakah anda yakin untuk menghapus data ini?");
      if(c){
        $.ajax({
          url: '<?=base_url();?>notice/remove/' + id,
          dataType: 'json'
        })
        .done(function(a){
          if(a.status == 'ok'){
          }

          notices();
        })
        .fail(function(e){
          alert(e);
        });
      }
      return false;
    });
  });

</script>
