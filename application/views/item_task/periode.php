<div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/item/project/<?=$project['ID'];?>'; return false;"><i class="fa fa-list-ul mr5"></i> Item Pekerjaan</button>
      </div>  
    </div>
  </div>
</div>
<hr/>
<table class="table table-bordered responsive table-hover table-item-list" id="table-list-item">
  <thead class="">
    <tr>
      <th class="text-center" width="30px" rowspan="3" style="vertical-align:middle;">No.</th>
      <th width="200px" rowspan="3" style="vertical-align:middle;" style="vertical-align:middle;">Uraian Pekerjaan</th>
      <th rowspan="3" style="vertical-align:middle;">Spesifikasi</th>
      <th class="text-center" colspan="<?=$week;?>">Week</th>
    </tr>
    <tr>
      <?=$column;?>
    </tr>
  </thead>

  <tbody>
    <?= $rows;?>
  </tbody>
</table>

<script type="text/javascript">
 $('.item-value').change(function(){
  var id   = $(this).attr('id'),
      week = $(this).attr('week'),
      v    = $(this).val();
  
    $.ajax({
      url: '<?php echo base_url();?>item_task/update_value',
      data: "id="+id+"&week="+week+"&v="+v,
      dataType: 'json'
    });
});
</script>
