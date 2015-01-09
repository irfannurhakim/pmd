<div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/project/view/<?=$project['ID'];?>';return false;"><i class="fa fa-arrow-left mr5"></i> Kembali</button>     
      </div>  

      <div class="btn-group">
        <button class="btn btn-default btn-sm choose-week" type="button" data-toggle="modal" data-target=".modal-filter-week"><i class="fa fa-clock-o mr5"></i> Pilih Minggu</button>
      </div>

      <div class="btn-group">
        <a href="<?=base_url();?>reports/weekly_report/<?=$id;?>/<?=$cur_week;?>/1" target="_blank" class="btn btn-default btn-sm export-data"><i class="fa fa-upload mr5"></i> Ekspor</a>
      </div>

    </div>
  </div>
</div>
<hr/>
<table border="0" cellpadding="0" cellspacing="5" >
  <tr>
    <td width="200px">Proyek/Kegiatan</td>
    <td>: <strong><?=$project['NAME'];?></strong></td>
  </tr>
  <tr>
    <td>Nomor Kontrak</td>
    <td>: <strong><?=$project['CONTRACT_NO'];?></strong></td>
  </tr>
  <tr>
    <td>Nilai Kontrak</td>
    <td>: <strong>Rp <?= number_format($project['BUDGET'],0,",",".");?></strong></td>
  </tr>
  <tr>
    <td>Kontraktor/Pelaksana</td>
    <td>: <strong><?=$vendor['AFFILIATION'];?></strong></td>
  </tr>
  <tr valign="top">
    <td>Pengawas</td>
    <td>
      <ul style="padding-left:20px">
      <strong>
      <?php
        foreach ($supervisor as $s) {
          echo '<li>' . $s['NAME'] . '</li>';
        }
      ;?>
      </strong></ul>
    </td>
  </tr>
</table>
<div class="mb10"></div>
  <?php
    if(!empty($item_list)){
  ?>
 <table class="table table-bordered table-hover table-item-list responsive" id="tbl-realisasi">
      <thead style="text-align:center">
        <tr class="dt-cols-center">
          <td rowspan="4">No</td>
          <td rowspan="4">Item Pekerjaan</td>
          <td rowspan="3">Satuan</td>
          <td colspan="6">Volume Pekerjaan</td>
          <td colspan="6">Bobot Pekerjaan</td>
          <td rowspan="3">Ket.</td>
        </tr>
        <tr>
          <td rowspan="2">Kontrak</td>
          <td colspan="2">Rencana</td>
          <td colspan="3">Realisasi</td>
          <td rowspan="2">Kontrak</td>
          <td colspan="2">Rencana</td>
          <td colspan="3">Realisasi</td>
        </tr>
        <tr>
          <td style="padding:4px">Mg ini</td>
          <td style="padding:4px">Jml sd Mg ini</td>
          <td style="padding:4px">Jml Mg Lalu</td>
          <td style="padding:4px">Mg ini</td>
          <td style="padding:4px">Jml sd Mg ini</td>
          <td style="padding:4px">Mg ini</td>
          <td style="padding:4px">Jml sd Mg ini</td>
          <td style="padding:4px">Jml Mg Lalu</td>
          <td style="padding:4px">Mg ini</td>
          <td style="padding:4px">Jml sd Mg ini</td>
        </tr>
        <tr>
          <td width="50px">a</td>
          <td width="50px">b</td>
          <td width="50px">c</td>
          <td width="50px">d</td>
          <td width="50px">e</td>
          <td width="50px">f</td>
          <td width="50px">g</td>
          <td width="50px">h</td>
          <td width="50px">i</td>
          <td width="50px">j</td>
          <td width="50px">k</td>
          <td width="50px">l</td>
          <td width="50px">m</td>
          <td width="50px">n</td>
        </tr>
      </thead>
      <tbody class="selectable">
        <?php
          $i = 1;
          $totalB = 0;
          $totalC = 0;
          $totalD = 0;
          $totalE = 0;
          $totalF = 0;
          $totalG = 0;
          $totalH = 0;
          $totalI = 0;
          $totalJ = 0;
          $totalK = 0;
          $totalL = 0;
          $totalM = 0;
          foreach ($item_list as $item) {
            if($this->session->userdata('ID_USER_TYPE') == 4){
              $realCumulative = $item['VENDOR_PROGRESS_VOLUME'];
              $bobotWeekBefore = $item['TOTAL_PERCENTAGE_BEFORE_VENDOR'];
              $bobotNow = $item['TOTAL_PERCENTAGE_NOW_VENDOR'];

            } else {
              $realCumulative = $item['SUPERVISOR_PROGRESS_VOLUME'];
              $bobotWeekBefore = $item['TOTAL_PERCENTAGE_BEFORE'];
              $bobotNow = $item['TOTAL_PERCENTAGE_NOW'];
            }

            $bobot = round((($item['UNIT_PRICE'] * $item['VOLUME']) / $project['BUDGET'] ) * 100, 3);
            $vol = ($item['VOLUME'] > 0) ? round((($realCumulative / $item['VOLUME']) * $bobot), 3) : 0;


        ?>
        <tr object="<?=$item['ID_ITEM_TASK'];?>" planningvolume="<?=round($item['VOLUME'], 3);?>" realizationbefore="<?=round($item['SUPERVISOR_PROGRESS_VOLUME'], 3);?>" bobot="<?=$bobot;?>">
          <td class="dt-cols-center"><?=$i;?></td>                            
          <td ><?=$item['NAME'];?></td>
          <td class="dt-cols-center"><?=$item['UNIT'];?></td>
          <td class="dt-cols-right"><?=round($item['VOLUME'], 3);?></td>
          <td class="dt-cols-right"><?=round(($item['PERCENTAGE_PLAN_CURRENT']/$item['WEIGHT_PLANNING']) * $item['VOLUME'], 3);?></td>
          <td class="dt-cols-right"></td>
          <td class="dt-cols-right"><?=round(($bobotWeekBefore/$item['WEIGHT_PLANNING']) * $item['VOLUME'], 3);?></td>          
          <td class="dt-cols-right"><?=round(($bobotNow/$item['WEIGHT_PLANNING']) * $item['VOLUME'], 3);?></td>
          <td class="dt-cols-right"><?=round($realCumulative, 3);?></td>
          <td class="dt-cols-right"><?=round($item['WEIGHT_PLANNING'], 3);?></td>
          <td class="dt-cols-right"><?=round($item['PERCENTAGE_PLAN_CURRENT'], 3);?></td>
          <td class="dt-cols-right"></td>
          <td class="dt-cols-right"><?=round($bobotWeekBefore, 3);?></td>
          <td class="dt-cols-right"><?=round($bobotNow, 3);?></td>
          <td class="dt-cols-right"><?=$vol;?></td>
          <td class="dt-cols-right"></td>
        </tr>

        <?php 
          $i++;
          $totalB += round($item['VOLUME'], 3);
          $totalC += round($item['PERCENTAGE_PLAN_CURRENT'] / 100 * $total_kontrak_volume, 3);
          $totalE += round(($bobotWeekBefore/100) * $total_kontrak_volume, 3);
          $totalF += round(($bobotNow/100) * $total_kontrak_volume, 3);
          $totalG += round($realCumulative, 3);
          $totalH += round($item['WEIGHT_PLANNING'], 3);
          $totalI += round($item['PERCENTAGE_PLAN_CURRENT'], 3);
          $totalK += round($bobotWeekBefore, 3);
          $totalL += round($bobotNow, 3); 
          $totalM += $vol;
        } ?>

        <tfoot>
          <tr>
            <th colspan="3" style="text-align:right">Total</th>
            <th class="dt-cols-right"><?=$totalB;?></th>
            <th class="dt-cols-right"><?=$totalC;?></th>
            <th class="dt-cols-right"></th>
            <th class="dt-cols-right"><?=$totalE;?></th>
            <th class="dt-cols-right"><?=$totalF;?></th>
            <th class="dt-cols-right"><?=$totalG;?></th>
            <th class="dt-cols-right"><?=$totalH;?></th>
            <th class="dt-cols-right"><?=$totalI;?></th>
            <th class="dt-cols-right"></th>
            <th class="dt-cols-right"><?=$totalK;?></th>
            <th class="dt-cols-right"><?=$totalL;?></th>
            <th class="dt-cols-right"><?=$totalM;?></th>
            <th class="dt-cols-right"></th>
          </tr>
        </tfoot>
      </tbody>
    </table>    
  <?php
    }else{ echo '<div class="alert alert-info text-center">Belum ada data tersedia.<br />Silahkan pilih minggu pada tombol di atas.</div>'; }
  ?>

<!-- <div class="container-dt" id="chart" style="margin-top:20px;height:300px;"></div>
 -->

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
        }
      });
    });
  });
</script>


