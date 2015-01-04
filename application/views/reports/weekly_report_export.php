<?php
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=report_project".$id."_minggu".$cur_week.".xls");
  header("Pragma: no-cache");
  header("Expires: 0");

  if(!empty($item_list)){
?>
<b><?=$project['NAME'];?></b>
<br /><br />
<table border="1">
  <thead>
    <tr>
      <th width="50px" rowspan="2" class="dt-cols-center">No</th>
      <th rowspan="2">Item Pekerjaan</th>
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
      <td class="dt-cols-right"><?=$bobot;?></td>
      <td class="dt-cols-right"><?=round($item['WEIGHT_PLANNING'], 4);?></td>
      <td class="dt-cols-right"><?=$vol;?></td>
    </tr>
    <?php $i++; } ?>
  </tbody>
</table>    
<?php
  } else { echo '<div class="alert alert-info text-center">Belum ada data tersedia.</div>'; }
?>

