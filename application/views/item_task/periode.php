
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    /*
     * FixedColumns styles
     */
    div.DTFC_LeftHeadWrapper table,
    div.DTFC_LeftFootWrapper table,
    div.DTFC_RightHeadWrapper table,
    div.DTFC_RightFootWrapper table,
    table.DTFC_Cloned tr.even {
        background-color: white;
    }
     
    div.DTFC_RightHeadWrapper table ,
    div.DTFC_LeftHeadWrapper table {
        margin-bottom: 0 !important;
        border-top-right-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
     
    div.DTFC_RightHeadWrapper table thead tr:last-child th:first-child,
    div.DTFC_RightHeadWrapper table thead tr:last-child td:first-child,
    div.DTFC_LeftHeadWrapper table thead tr:last-child th:first-child,
    div.DTFC_LeftHeadWrapper table thead tr:last-child td:first-child {
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
     
    div.DTFC_RightBodyWrapper table,
    div.DTFC_LeftBodyWrapper table {
        border-top: none;
        margin-bottom: 0 !important;
    }
     
    div.DTFC_RightBodyWrapper tbody tr:first-child th,
    div.DTFC_RightBodyWrapper tbody tr:first-child td,
    div.DTFC_LeftBodyWrapper tbody tr:first-child th,
    div.DTFC_LeftBodyWrapper tbody tr:first-child td {
        border-top: none;
    }
     
    div.DTFC_RightFootWrapper table,
    div.DTFC_LeftFootWrapper table {
        border-top: none;
    }

    table.dataTable tbody tr{
      background-color: white;
    }

}
</style>
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
      <?php if($this->session->userdata('ID_USER_TYPE') != 4){?>  
      <div class="btn-group">
        <button class="btn btn-primary btn-sm" type="button" id="submit-form"><i class="fa fa-save"></i> Simpan</button>
      </div>
      <?php }?>  
    </div>
  </div>
</div>
<hr/>
<div class="container-dt">
  <form id="form-periode" method="POST" action="<?= base_url();?>item_task/update_value/<?=$project['ID'];?>">
  <table class="table table-bordered table-hover table-item-list" id="table-list-periode" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th rowspan="2" width="20px">No.</th>
        <th rowspan="2"><div style="min-width:50px;">&nbsp;</div>Uraian Pekerjaan</th>
        <th rowspan="2" width="10px" class="dt-cols-center">Bobot</th>
        <th rowspan="2" width="10px" class="dt-cols-center">+/-</th>
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
    
    $('.item-value').keyup(function(){
      var selector = $(this).attr('object'),
        totalBobot = $(this).attr('totalBobot'),
        totalPlan = 0,
        diff = 0;

      $('.' + selector).each(function(idx){
        totalPlan += $(this).val() * 1;
      });

      diff = ((totalPlan - totalBobot) * 1000) / 1000;
      $('.clone-' + selector).text(diff.toFixed(3));
    });

    $('#submit-form').click(function(){
      if(confirm('Apakah anda yakin akan menyimpan jadwal master perencanaan ini?')==true)
      {
        $('#form-periode').submit();
      }
    });

    $('#form-periode').ajaxForm({
      beforeSend: function(){
        $('#submit-form').html('<i class="fa fa-save"></i> Menyimpan...');
        $('#submit-form').attr('disabled','disabled');
      },
      success: function(){
        location.reload();
      }
    });

    var tbl = jQuery('#table-list-periode').DataTable({
      paging : false,
      ordering : false,
      scrollY: "600px",
      scrollX: "100%",
      scrollCollapse: true,
      responsive: false
    });

    new $.fn.dataTable.FixedColumns( tbl, {
      leftColumns: 4
    });
  });


</script>
