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

      <div class="btn-group">
        <a href="<?=base_url();?>reports/weekly_report/<?=$id;?>/<?=$cur_week;?>/1" target="_blank" class="btn btn-default btn-sm export-data"><i class="fa fa-upload mr5"></i> Export </a>
      </div>

    </div>
  </div>
</div>
<hr/>

<div class="container-dt" id="tbl" style="height:200px;overflow:auto;">
  <?php
    if(!empty($item_list)){
  ?>
 <table class="table table-bordered table-hover tbl-item-list responsive" id="tbl-realisasi">
      <thead>
        <tr>
          <th width="50px" rowspan="2" class="dt-cols-center">No</th>
          <th rowspan="2">Uraian Pekerjaan</th>
          <th rowspan="2" class="dt-cols-center">Satuan</th>
          <th colspan="4" class="dt-cols-center">Volume</th>
          <th colspan="3" class="dt-cols-center">Bobot</th>
        </tr>
        <tr>
          <th width="20px" class="dt-cols-center">Kontrak</th>
          <th width="20px" class="dt-cols-center">Rencana</th>
          <th width="20px" class="dt-cols-center">Realisasi Pengawas</th>
          <th width="20px" class="dt-cols-center">Realisasi Kontraktor</th>
          <th width="20px" class="dt-cols-center">Kontrak</th>
          <th width="20px" class="dt-cols-center">Rencana</th>
          <th width="20px" class="dt-cols-center">Realisasi</th>                        
        </tr>
      </thead>
      <tbody class="selectable">
        <?php
          $i = 1;
          foreach ($item_list as $item) {
            $bobot = round((($item['UNIT_PRICE'] * $item['VOLUME']) / $project['BUDGET'] ) * 100, 4);
            $vol = ($item['VOLUME'] > 0) ? round((($item['SUPERVISOR_PROGRESS_VOLUME'] / $item['VOLUME']) * $bobot), 4) : 0;
        ?>
        <tr object="<?=$item['ID_ITEM_TASK'];?>" planningvolume="<?=round($item['VOLUME'], 4);?>" realizationbefore="<?=round($item['SUPERVISOR_PROGRESS_VOLUME'], 4);?>" bobot="<?=$bobot;?>">
          <td class="dt-cols-center"><?=$i;?></td>                            
          <td ><?=$item['NAME'];?></td>
          <td class="dt-cols-center"><?=$item['UNIT'];?></td>
          <td class="dt-cols-right"><?=$bobot;?></td>
          <td class="dt-cols-right"><?=round($item['VOLUME'], 4);?></td>
          <td class="dt-cols-right"><?=round($item['SUPERVISOR_PROGRESS_VOLUME'], 4);?></td>
          <td class="dt-cols-right"><?=round($item['VENDOR_PROGRESS_VOLUME'], 4);?></td>
          <td class="dt-cols-right"></td>
          <td class="dt-cols-right"><?=round($item['WEIGHT_PLANNING'], 4);?></td>
          <td class="dt-cols-right"><?=$vol;?></td>
        </tr>
        <?php $i++; } ?>

        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right">Total</th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
            </tr>
        </tfoot>
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
        series: [{},{},{},{}]
        
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
              if(index=='v_rencana')
              {
                options.series[0].name='v_rencana';
                options.series[0].data= nilai;
              }
               if(index=='v_realisasi')
              {
                options.series[1].name='v_realisasi';
                options.series[1].data= nilai;
              }
               if(index=='b_rencana')
              {
                options.series[2].name='b_rencana';
                options.series[2].data= nilai;
              }
               if(index=='b_realisasi')
              {
                options.series[3].name='b_realisasi';
                options.series[3].data= nilai;
              } 
            })  
            chart = new Highcharts.Chart(options);  
          }
        });

  });
</script>


