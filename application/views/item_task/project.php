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
<table class="table table-bordered responsive table-hover table-item-list" id="table-list-item">
  <thead class="">
    <tr>
      <th class="text-center">No.</th>
      <th>Uraian Pekerjaan</th>
      <th>Spesifikasi</th>
      <th class="text-center">Volume</th>
      <th class="text-center">Satuan</th>
      <th class="text-center">Harga Satuan (Rp)</th>
      <th class="text-center">Bobot (%)</th>
      <th class="text-center">Jumlah</th>
      <th width="60px"></th>
    </tr>
  </thead>

  <tbody class="selectable">
    <?php 

      for($i=1;$i<=$max_level[0]['MAX'];$i++)
      {
        $$i = 1;
        echo $$i;
      }

      $budget          = $project['BUDGET'];
      $no_num          = 1;
      $no_alp          = 'a';
      $ar_total_jumlah = array();
      $ar_total_persen = array();
      $lvl             = 3; //start level

      foreach($item_list as $val): 

        $align  = ($val['LEVEL'] == 2)? 'left' : 'right';
        $bg     = ($val['LEVEL'] == 2)? '#eee' : '#fff';
        $name   = ($val['LEVEL'] == 1)? '<strong>'.$val['NAME'].'</strong>' : $val['NAME'];

        $ar_total_jumlah[]  = ($val['LEVEL'] == 1 || $val['LEVEL'] == 2)? 0 : $val['UNIT_PRICE']*$val['VOLUME'];
        $ar_total_persen[]  = ($val['LEVEL'] == 1 || $val['LEVEL'] == 2)? 0 : (($val['UNIT_PRICE']*$val['VOLUME'])/$budget)*100;
        
        if($val['LEVEL'] == 1 && $no_alp != 'a'){ echo '<tr><td colspan="9">&nbsp;</td></tr>';$no_alp = 'a';}

        if($val['LEVEL'] == 1){
          $nomor = '';
        }elseif($val['LEVEL'] == 2){
           $nomor = $no_alp++;
        }else{
          $nomor  = ($lvl != $val['LEVEL'])? $nomor.'.'.$$val['LEVEL']++ : $$val['LEVEL']++;
          $lvl    = $val['LEVEL'];
        }

    ?>
      <tr style="background:<?=$bg;?>;">
        <td style="text-align:<?=$align;?>;"><?=ucwords($nomor);?></td>
        <td><?=$val['LEVEL'];?> <?=$name;?></td>
        <td><?=ucfirst($val['SPECIFICATION']);?></td>
        <td class="text-center"><?=$val['VOLUME'];?></td>
        <td class="text-center"><?=$val['UNIT'];?></td>
        <td class="text-right"><?=number_format($val['UNIT_PRICE']);?></td>
        <td class="text-center"><?=(($val['UNIT_PRICE']*$val['VOLUME'])/$budget)*100;?></td>
        <td class="text-right"><?=number_format($val['UNIT_PRICE']*$val['VOLUME']);?></td>
        <td class="dt-cols-center">
          <a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="<?php echo $val['ID'];?> "><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;
          <a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="<?php echo $val['ID'];?>"><i class="fa fa-trash-o"></i></a>
        </td>
      </tr>
    <?php 

      endforeach; 

      $color_persen = (array_sum($ar_total_persen) < 100)? 'style="color:red;"' : '';
      $color_total  = (array_sum($ar_total_jumlah) < $budget)? 'style="color:red;"' : '';
    ?>
    <tr><td colspan="9">&nbsp;</td></tr>
    <tr>
      <td colspan="6" class="text-center"><strong>Total</strong></td>
      <td class="text-center"><strong <?=$color_persen;?>><?=array_sum($ar_total_persen);?></strong></td>
      <td class="text-right"><strong <?=$color_total;?>><?=number_format(array_sum($ar_total_jumlah));?></strong></td>
      <td>&nbsp;</td>
    </tr>
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
                             <?php foreach ($item_list as $row) { ?>
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
                      <label class="col-sm-4 control-label">Spesifikasi<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <textarea name="specification" id="specification" class="form-control" required title="Kolom Spesifikasi wajib diisi!" style="width:320px;"></textarea>
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


