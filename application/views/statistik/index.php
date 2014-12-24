
<div class="container-dt">
  <table id="table-list-statistik" class="table table-bordered responsive table-hover">
    <thead class="">
      <tr>
        <th>Nama Proyek</th>
        <th>Kontraktor</th>
        <th width="60px" class="dt-cols-center">Sisa Waktu</th>
        <th width="60px" class="dt-cols-center">Selesai (%)</th>
<!--         <th width="60px" class="dt-cols-center">Deviasi (%)</th>
 -->        <!-- <th></th> -->
      </tr>
    </thead>

    <tbody class="selectable">
      <?php foreach ($projects as $row) { 
        if($row['FROM_START'] > 0){
          $sisaWaktuSpan = '<span class="label label-default">Belum Mulai</span>';
          $deviation = '<span class="badge">0 %</span>';
        } else {
          $sisaWaktu = ($row['DUE'] > 0) ? ceil($row['DUE']/7) : floor($row['DUE']/7);
          $sisaWaktuSpan = ($sisaWaktu >= 0) ? (($sisaWaktu < 2) ? '<span class="label label-warning">'.$sisaWaktu.' Minggu</span>' : '<span class="label label-primary">'.$sisaWaktu.' Minggu</span>') : '<span class="label label-success">Selesai</span>';
          $deviation = ($row['DEVIATION'] < 20) ? '<span class="badge">'.$row['DEVIATION'] .' %</span>' : '<span class="badge badge-danger">'.$row['DEVIATION'] .' %</span>';
        }

      ?>
      <tr object="<?=$row['ID'];?>">
          <td><?=$row['NAME'];?></td>
          <td><?=$row['VENDOR_NAME'];?></td>
          <td class="dt-cols-right"><?=$sisaWaktuSpan;?></td>
          <td class="dt-cols-right"><span class="badge"><?=round($row['PROGRESS'],4);?> %</span></td>
<!--           <td class="dt-cols-right"><?=$deviation;?></td>
 -->      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    jQuery('#table-list-reports').DataTable({
      "responsive": false,
      "order": [[ 2, "asc" ]]
    });

    jQuery('#table-list-statistik tbody').on( 'click', 'tr', function () {
      var id = $(this).attr('object');
      window.location = "<?=base_url();?>#/statistik/detail/" + id;
    });
    
  });
</script>


