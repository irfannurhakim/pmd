<div>
  <button class="btn btn-primary add-data" data-toggle="modal" data-target=".modal-add-item"><i class="fa fa-plus"></i> Buat Item</button>
</div>
<table class="table table-bordered responsive table-hover" id="table-list-item">
  <thead class="">
    <tr>
      <th>Nama Item</th>
      <th>Parent Item</th>
      <th>Value</th>
      <th>Volume</th>
      <th>Satuan</th>
      <th width="60px"></th>
    </tr>
  </thead>

  <tbody class="selectable">
    <?php foreach($item_list as $val): ?>
      <tr>
        <td><?=$val['NAME'];?></td>
        <td><?=$val['PARENT'];?></td>
        <td><?=$val['VALUE'];?></td>
        <td><?=$val['VOLUME'];?></td>
        <td><?=$val['SATUAN'];?></td>
        <td class="dt-cols-center">
          <a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="<?php echo $val['ID'];?> "><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;
          <a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="<?php echo $val['ID'];?>"><i class="fa fa-trash-o"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="modal fade modal-add-item" tabindex="-1" role="dialog" id="modal-add-item" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Buat Item Baru</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" id="form-add-item" method="POST" action="<?= base_url();?>item_task/add">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
                        <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                    </div>
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                </div>
                <div class="panel-body">
                  <div class="errorForm"></div>
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Project<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <select id="select-id-project" data-placeholder="Pilih Project" class="width300" name="id-project" title="Project wajib dipilih" required>
                             <option value="0"></option>
                             <?php foreach ($project as $row) { ?>
                                <option value="<?php echo $row['ID'];?>"><?php echo $row['NAME'];?></option>
                            <?php }; ?>                                          
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Parent Item</label>
                      <div class="col-sm-8">
                          <select id="select-id-parent" data-placeholder="Pilih Parent Item" class="width300" name="id-parent">
                             <option value="0"></option>
                             <?php foreach ($item as $row) { ?>
                                <option value="<?php echo $row['ID'];?>"><?php echo $row['NAME'];?></option>
                            <?php }; ?>                                          
                          </select>
                      </div>
                  </div>
                <div class="panel-body">
                  <div class="errorForm"></div>
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Nama Item<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="name" id="name" class="form-control" required title="Kolom Nama Item wajib diisi!" />
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Value<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <input type="text" name="value" id="value" class="form-control" required title="Kolom Value wajib diisi!" value="0" />
                      </div>
                  </div>
                   <div class="form-group">
                      <label class="col-sm-4 control-label">Volume<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <input type="text" name="volume" id="volume" class="form-control" required title="Kolom Volume wajib diisi!" value="0" />
                      </div>
                  </div>
                   <div class="form-group">
                      <label class="col-sm-4 control-label">Satuan<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <input type="text" name="satuan" id="satuan" class="form-control" required title="Kolom Satuan wajib diisi!"  />
                      </div>
                  </div>

                  <!-- Hidden Field -->
                  <input type="hidden" name="id" id="id" value="-1" />
                  <input type="hidden" name="is-edit" id="is-edit" value="0" />
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

    jQuery('#table-list-item').DataTable({
      "responsive": true
    });

    jQuery('#select-id-project,#select-id-parent').select2();

    $('.add-data').click(function(){
      $('#form-add-item').trigger('reset');
      $('#select-id-project,#select-id-parent').select2('data', null);
    });
    // Submit add item
    $('#form-add-item').ajaxForm({
      success: function(a,b,c,d){
        $('#modal-add-item').modal('hide');
        $('.modal-backdrop').hide();
        items();

        //reset status
        $("#is-edit").val('0');
      }
    });

    $('.edit-row').click(function(){
      var id = $(this).attr('object');
      //$("select #select-id-parent option[value='"+id+"']").attr('disabled',true);

      $.ajax({
        url: '<?php echo base_url();?>item_task/id/' + id,
        dataType: 'json'
      })
      .done(function(response, textStatus, jqhr){
        if(response.status == "ok"){
          $('#select-id-project').val(response.data.ID_PROJECT).trigger('change');
          $('#select-id-parent').val(response.data.ID_PARENT).trigger('change');
          $("#name").val(response.data.NAME);
          $("#value").val(response.data.VALUE);
          $("#volume").val(response.data.VOLUME);
          $("#satuan").val(response.data.SATUAN);
          $("#id").val(response.data.ID);
          $("#is-edit").val('1');
        }
      })
      .fail(function(){

      });

      $('.modal-add-item').modal('show');
    });

    $('.delete-row').click(function(){
      var id = $(this).attr('object');
      
      if (confirm('Apakah anda yakin menghapus item ini ?')) { 
        $.ajax({
          url: '<?php echo base_url();?>item_task/remove/' + id,
          dataType: 'json'
        })
        .done(function(response, textStatus, jqhr){
          items();
        })
        .fail(function(){

        });
      }
    });

  });
</script>


