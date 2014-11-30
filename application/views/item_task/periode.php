<div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/project/view/<?=$project['ID'];?>';return false;"><i class="fa fa-arrow-left mr5"></i> Detail Proyek</button>     
      </div>  
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/item/project/<?=$project['ID'];?>'; return false;"><i class="fa fa-list-ul mr5"></i> Item Pekerjaan</button>
      </div>  
      <div class="btn-group">
        <button class="btn btn-primary btn-sm" type="button" id="submit-form">Submit</button>
      </div>  
    </div>
  </div>
</div>
<hr/>
<div class="container-dt">
  <form id="form-periode" method="POST" action="<?= base_url();?>item_task/update_value/<?=$project['ID'];?>">
  <table class="table table-bordered responsive table-hover table-item-list" id="table-list-periode">
    <thead class="">
      <tr>
        <th rowspan="3">No.</th>
        <th rowspan="3"><div style="width:250px;">&nbsp;</div>Uraian Pekerjaan</th>
        <th rowspan="3" class="dt-cols-center">Bobot</th>
        <th class="text-center" colspan="<?=$week;?>">Minggu</th>
      </tr>
      <tr>
        <?=$column;?>
      </tr>
    </thead>

    <tbody>
      <?= $rows;?>
    </tbody>
  </table>
  </form>
</div>

<script type="text/javascript">

  $(document).ready(function(){
    /*
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
    */

    $('#submit-form').click(function(){
      if(confirm('Apakah anda yakin akan menyimpan jadwal master perencanaan ini?')==true)
      {
        $('#form-periode').submit();
      }
    });

    $('#form-periode').ajaxForm({
      success: function(){
        location.reload();
      }
    });

     
    //  $('#table-list-periode').dataTable({
    //      "scrollY": "300px",
    //      "scrollX": "100%",
    //      "scrollCollapse": true,
    //      "paging": false
    //  });

    // new $.fn.dataTable.FixedColumns( tbl );
  
  });


</script>
