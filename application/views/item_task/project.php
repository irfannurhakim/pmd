<div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:history.go(-1);return false;"><i class="fa fa-arrow-left mr5"></i> Induk Proyek</button>     
        <button class="btn btn-default btn-sm add-data" type="button" data-toggle="modal" data-target=".modal-add-item"><i class="fa fa-plus mr5"></i> Tambah Item</button>
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/item/periode/<?=$project['ID'];?>'; return false;"><i class="fa fa-list-ul mr5"></i> Periode Pekerjaan</button>
      </div>  
    </div>
  </div>
</div>
<hr/>
<table class="table table-bordered responsive table-hover table-item-list" id="table-list-item">
  <thead class="">
    <tr>
      <th class="text-center" width="30px">No.</th>
      <th width="200px">Uraian Pekerjaan</th>
      <th>Spesifikasi</th>
      <th class="text-center" width="30px">Volume</th>
      <th class="text-center" width="30px">Satuan</th>
      <th class="text-center" width="100px">Harga Satuan (Rp)</th>
      <th class="text-center" width="30px">Bobot (%)</th>
      <th class="text-center" width="150px">Jumlah</th>
      <th width="60px"></th>
    </tr>
  </thead>

  <tbody>
    <?= $rows;?>
    <tr><td colspan="9">&nbsp;</td></tr>
    <!-- <tr>
      <td colspan="6" class="text-center"><strong>Total</strong></td>
      <td class="text-center"><strong <?=$color_persen;?>><?=array_sum($ar_total_persen);?></strong></td>
      <td class="text-right"><strong <?=$color_total;?>><?=number_format(array_sum($ar_total_jumlah));?></strong></td>
      <td>&nbsp;</td>
    </tr> -->
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
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                </div>
                <div class="panel-body">
                  <div class="errorForm"></div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Parent Item</label>
                      <div class="col-sm-8">
                          <select id="select-id-parent" data-placeholder="Pilih Item"  class="width300" name="id-parent">
                            <option value="0">Level Pekerjaan Teratas</option>
                            <?php foreach ($item_list as $row) { ?>
                                <option value="<?php echo $row['ID'];?>"><?php echo $row['NAME'];?></option>
                            <?php }; ?>
                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Nama Item<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="name" id="name" class="form-control" required title="Kolom Nama Item wajib diisi!" />
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Spesifikasi<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <textarea name="specification" id="specification" rows="3" class="form-control" required title="Kolom Spesifikasi wajib diisi!" class="col-sm-8"></textarea>
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
                          <input type="text" name="unit" id="unit" class="form-control" required title="Kolom Satuan wajib diisi!"  />
                      </div>
                  </div>

                   <div class="form-group">
                      <label class="col-sm-4 control-label">Harga Satuan<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <input type="text" name="unit_price" id="unit_price" class="form-control" required title="Kolom Value wajib diisi!" value="0" />
                      </div>
                  </div>

                  <!-- Hidden Field -->
                  <input type="hidden" name="id" id="id" value="-1" />
                  <input type="hidden" name="is-edit" id="is-edit" value="0" />
                  <input type="hidden" name="id-project" id="id-project" value="<?=$project['ID'];?>" />
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

    /*
    jQuery('#table-list-item').DataTable({
      "responsive": true,
      "aoColumns": [
			{ "bSortable": false },
			{ "bSortable": false },
			{ "bSortable": false },
			{ "bSortable": false },
			{ "bSortable": false }
		],
    });
    */

    jQuery('#select-id-parent').select2();

    $('.add-data').click(function(){
      $('#form-add-item').trigger('reset');
      //$('#select-id-parent').select2('data', null);
    });
    // Submit add item
    $('#form-add-item').ajaxForm({
      success: function(a,b,c,d){
        $('#modal-add-item').modal('hide');
        $('.modal-backdrop').hide();

        //reset status
        $("#is-edit").val('0');

        location.reload();
        //itemProject(<?=$id;?>);
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
          $('#select-id-parent').val(response.data.ID_PARENT).trigger('change');
          $("#name").val(response.data.NAME);
          $("#specification").val(response.data.SPECIFICATION);
          $("#volume").val(response.data.VOLUME);
          $("#unit").val(response.data.UNIT);
          $("#unit_price").val(response.data.UNIT_PRICE);
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


