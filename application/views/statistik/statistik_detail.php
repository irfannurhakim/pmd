<?php
  $btnImport = ''; 
  if(($this->session->userdata('ID_USER_TYPE') == 1) || ($this->session->userdata('ID_USER_TYPE') == 6)){ 
    $btnImport = '<button class="btn btn-default btn-sm import-data" type="button" data-toggle="modal" data-target=".modal-import"><i class="fa fa-download mr5"></i> Impor </button>';
  }
?>
<div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/statistik';return false;"><i class="fa fa-arrow-left mr5"></i> Kembali</button>     
      </div>  

    </div>
  </div>
</div>
<hr/>

<div class="container-dt" id="tbl" style="height:200px;overflow:auto;">
  <?php
    if(!empty($item_list)){
  ?>
  <table id="table-list-weekly-report" class="table table-hover table-bordered responsive">
    <tr>
      <th>No</td>
      <th>Item Pekerjaan</th>
      <th>Satuan</th>
      <th>Minggu Ke-</th>
      <th>Rencana (%)</th>
      <th>Realisasi (%)</th>
    </tr>
   <tbody>
      <?php $no=1;
            foreach ($item_list as $row) { 
      ?>
      <tr>
          <td><?php echo $no++;?></td>
          <td><?php echo $row['NAME'];?></td>
          <td><?php echo $row['UNIT'];?></td>
          <td><?php echo $row['NO_WEEK'];?></td>
          <td><?php echo $row['RENCANA'];?></td>
          <td><?php echo $row['REALISASI'];?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php
    }else{ echo '<div class="alert alert-info text-center">Data tidak tersedia.</div>'; }
  ?>
</div>

<div class="container-dt" id="chart" style="margin-top:20px;height:300px;"></div>

<input type="hidden" name="id-project" id="id-project" value="<?=$id;?>" />
<script src="<?= base_url();?>public/js/chart/highcharts.js"></script>
<script src="<?= base_url();?>public/js/chart/exporting.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    var chart;
    var id   = $('#id-project').val();

    var options = 
      {
        chart: {renderTo: 'chart',defaultSeriesType: 'line'},
        title: {text: ''},
        subtitle: {text: ''},
        xAxis: {},
        yAxis: {title: {text: 'Persentase'}},
        plotOptions: {
          series: {
            dataLabels: {
              enabled: true
            }
          }
        },  
        legend: {layout: 'vertical',align: 'right',verticalAlign: 'top',x: -10,y: 100,borderWidth: 0},
        series: [{},{}]
        
      };      
      $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>statistik/statistik_chart/"+id,
          success: function(data)
          {
            var objek_JSON = jQuery.parseJSON(data);
            $.each(objek_JSON,function(index,nilai)
            {
              if(index=='judul')
              {
                  options.xAxis.categories= nilai;
              }
              if(index=='rencana')
              {
                options.series[0].name='Rencana';
                options.series[0].data= nilai;

              } 
              if(index=='realisasi')
              {
                options.series[1].name='Realisasi';
                options.series[1].data= nilai;

              } 
            })  
            chart = new Highcharts.Chart(options);  
          }
        });

  });
</script>


