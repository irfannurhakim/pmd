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
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/weekly_report';return false;"><i class="fa fa-arrow-left mr5"></i> Kembali</button>     
      </div>  

      <div class="btn-group">
        <button class="btn btn-default btn-sm choose-week" type="button" data-toggle="modal" data-target=".modal-filter-week"><i class="fa fa-clock-o mr5"></i> Pilih Minggu</button>
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
      <th>Periode</th>
      <th>Persentase</th>
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
          <td><?php echo date('d/m/Y',strtotime($row['START_WEEK'])).' - '.date('d/m/Y',strtotime($row['END_WEEK']));?></td>
          <td><?php echo $row['PERCENTAGE'];?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php
    }else{ echo '<div class="alert alert-info text-center">Belum ada data tersedia.<br />Silahkan pilih minggu pada tombol di atas.</div>'; }
  ?>
</div>

<div class="container-dt" id="chart" style="margin-top:20px;height:300px;"></div>


<div class="modal fade modal-filter-week" tabindex="-1" role="dialog" id="modal-filter-week" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Pilih Minggu</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="errorForm"></div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Minggu Ke-</label>
                    <div class="col-sm-5">
                      <select id="week" style="width:100px;">
                        <?php 
                            foreach ($week as $row) { 
                              $selected = ($cur_week==$row["NO_WEEK"])? 'selected' : '';
                              echo '<option value="'.$row["NO_WEEK"].'" '. $selected.'>'.$row["NO_WEEK"].'</option>';
                            } 
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="id-project" id="id-project" value="<?=$id;?>" />
                <div class="panel-footer">
                    <button class="btn btn-primary mr5" id="submit">Submit</button>
                </div><!-- panel-footer -->
              </div><!-- panel-default -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url();?>public/js/chart/highcharts.js"></script>
<script src="<?= base_url();?>public/js/chart/exporting.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    jQuery('#week').select2();

    $('#submit').click(function(){
      var id   = $('#id-project').val();
      var week = $('#week').val();

      $.ajax({
        url: '<?php echo base_url();?>reports/weekly_report/'+id+'/'+week,
        dataType: 'html',
        success:function(result){
          $('.modal-backdrop').remove();
          $('#weekly-report-detail').html(result);
          $('body').css('overflow','auto')
        }
      });

    });


    var chart;
    var id   = $('#id-project').val();
    var week = $('#week').val();
    var options = 
      {
        chart: {renderTo: 'chart',defaultSeriesType: 'line'},
        title: {text: ''},
        subtitle: {text: ''},
        xAxis: {},
        yAxis: {title: {text: 'Progres Minggu ke <?=$cur_week;?>'}},
        plotOptions: {
          series: {
            dataLabels: {
              enabled: true
            }
          }
        },  
        legend: {layout: 'vertical',align: 'right',verticalAlign: 'top',x: -10,y: 100,borderWidth: 0},
        series: [{}]
        
      };      
      $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>reports/weekly_report_chart/"+id+"/"+week,
          success: function(data)
          {
            var objek_JSON = jQuery.parseJSON(data);
            $.each(objek_JSON,function(index,nilai)
            {
              if(index=='judul')
              {
                  options.xAxis.categories= nilai;
              }
              if(index=='nilai')
              {
                options.series[0].name='Persentase';
                options.series[0].data= nilai;

              } 
            })  
            chart = new Highcharts.Chart(options);  
          }
        });

  });
</script>


