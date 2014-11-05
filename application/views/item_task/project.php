<!--
<div>
  <button class="btn btn-primary add-data" data-toggle="modal" data-target=".modal-add-item"><i class="fa fa-plus"></i> Buat Item</button>
</div>
-->

<div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:history.go(-1);return false;"><i class="fa fa-arrow-left mr5"></i> Induk Proyek</button>     
        <button class="btn btn-default btn-sm add-data" type="button" data-toggle="modal" data-target=".modal-add-item"><i class="fa fa-plus mr5"></i> Tambah Item</button>
      </div>  
    </div>
  </div>
</div>
<hr/>
<table class="table table-bordered responsive table-hover" id="table-list-item">
  <thead class="">
    <tr>
      <th class="text-center">No.</th>
      <th>Uraian Pekerjaan</th>
      <th>Value</th>
      <th>Volume</th>
      <th>Satuan</th>
      <th class="text-center">Price</th>
      <th class="text-center">Y</th>
      <th class="text-center">N</th>
      <th width="60px"></th>
    </tr>
  </thead>

  <tbody class="selectable">
    <?php 
      $no_num = 1;
      $no_alp = 'a';
      foreach($item_list as $val): 

        $nomor  = (($val['ID_PARENT'] == 0)? '' :  (in_array($val['ID_PARENT'],$ar_id)? $no_alp++ : $no_num++));
        $align  = (in_array($val['ID_PARENT'],$ar_id))? 'left' : 'right';
        $bg     = (in_array($val['ID_PARENT'],$ar_id))? '#eee' : '#fff';
        $name   = ($val['ID_PARENT'] != 0)? $val['NAME'] : '<strong>'.$val['NAME'].'</strong>';
        
        if($id != $val['ID'] && $val['ID_PARENT'] == 0){ echo '<tr><td colspan="9">&nbsp;</td></tr>';$no_alp = 'a';}

    ?>
      <tr style="background:<?=$bg;?>;">
        <td style="text-align:<?=$align;?>;"><?=ucwords($nomor);?>.</td>
        <td><?=$name;?></td>
        <td><?=$val['VALUE'];?></td>
        <td><?=$val['VOLUME'];?></td>
        <td><?=$val['UNIT'];?></td>
        <td class="text-center"><input type="text" style="width:150px;" /></td>
        <td class="text-center"><input type="checkbox" /></td>
        <td class="text-center"><input type="checkbox" /></td>
        <td class="dt-cols-center">
          <a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="<?php echo $val['ID'];?> "><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;
          <a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="<?php echo $val['ID'];?>"><i class="fa fa-trash-o"></i></a>
        </td>
      </tr>
    <?php 
        $id     = $val['ID'];
        $no_num = (in_array($val['ID_PARENT'],$ar_id))? 1 : $no_num; 
      endforeach; 
    ?>
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
              <input type="hidden" name="id-project" id="id-project" value="<?=$project['ID'];?>" />
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
                      <label class="col-sm-4 control-label">Parent Item</label>
                      <div class="col-sm-8">
                          <select id="select-id-parent" data-placeholder="Pilih Parent Item" class="width300" name="id-parent">
                             <option></option>
                             <?php foreach ($list_item as $row) { ?>
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
      $('#select-id-parent').select2('data', null);
    });
    // Submit add item
    $('#form-add-item').ajaxForm({
      success: function(a,b,c,d){
        $('#modal-add-item').modal('hide');
        $('.modal-backdrop').hide();
        itemProject(<?=$id;?>);

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


