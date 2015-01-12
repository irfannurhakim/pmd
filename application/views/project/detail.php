<?php
  $btnDelete = ''; 
  $disabled = 'disabled';
  if(($this->session->userdata('ID_USER_TYPE') == 1) || ($this->session->userdata('ID_USER_TYPE') == 6)){ 
    $btnDelete = '<button class="btn btn-default btn-sm" type="button" id="button-delete-project" object="'.$project['ID'].'"><i class="fa fa-trash-o mr5"></i> Hapus</button>';
    $disabled = '';
  }

?>
<!-- testttttt
 --><div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?> </h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/projects';return false;"><i class="fa fa-arrow-left mr5"></i> Daftar Proyek</button>    
      </div>  
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/item/project/<?=$project['ID'];?>'; return false;"><i class="fa fa-list-ul mr5"></i> Item</button>
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/item/periode/<?=$project['ID'];?>'; return false;"><i class="fa fa-clock-o mr5"></i> Perencanaan</button>
      </div>
      <div class="btn-group">
        <?=$btnDelete;?>
      </div>
    </div>
  </div>
</div>
<hr/>
<div class="row">
  <div class="col-md-9">
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="text-center">
            <?php if($isStarted && !$isFinished){ ?>
              <p>Saat ini,</p>
              <h4>Minggu ke-<?=$weekNumber;?></h4>
              <p>Tgl <?=$startWeek . ' - ' . $endWeek;?></p>
            <?php } else if($isFinished){ ?>

            <?php } else { ?>
              <p>Proyek Dimulai</p>
              <h4><?=$countDown;?> Hari Lagi</h4>
            <?php } ?>
            </div>
            <button class="btn <?=$buttonStatusType;?> btn-bordered btn-block" ><?=$statusLabel;?></button>
          </div><!-- panel-body -->
        </div>

        <div class="panel panel-default">
          <div class="panel-body nopadding">
            <?php 
              $proyekChecked = '';
              if($project['IS_FINISHED'] == 1){
                $proyekChecked = 'checked="checked"';
              } 
            ?>
              <form class="form-bordered" >
                <div class="form-group">
                    <div class="col-sm-12 control-label">
                      <div class="ckbox ckbox-success">
                        <input <?=$disabled;?> type="checkbox" value="1" class="project-finished" name="project-finished" id="project-finished" <?=$proyekChecked;?> />
                        <label for="project-finished">Proyek Selesai?</label>
                      </div>
                    </div>
                </div>
                <div class="form-group">
<!--                   <label class="col-sm-6 control-label">Tgl Selesai</label>
 -->                  <div class="col-sm-12">
                      <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="is-finished-date" name="is-finished-date" value="<?=date_format(date_create($project['IS_FINISHED_DATE']), 'd/m/Y');?>" <?=$disabled;?> <?=$isFinished ? 'disabled' : '';?> />
                  </div>
                </div><!-- form-group -->
              </form>
          </div>
        </div>
      
        <div class="panel panel-default">
          <div class="panel-body">
            <h5>Rencana (<?=round($info[0]['TOTAL_PLANNING'], 3);?>%)</h5>
            <div class="progress">
              <div style="width: <?=$info[0]['TOTAL_PLANNING'];?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-success">
                  <span class="sr-only"><?=$info[0]['TOTAL_PLANNING'];?>% Complete (success)</span>
              </div>
            </div>
            <h5>Realisasi (<?=round($info[0]['TOTAL_PERCENTAGE'], 3);?>%)</h5>
            <div class="progress">
              <div style="width: <?=$info[0]['TOTAL_PERCENTAGE'];?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
                  <span class="sr-only"><?=$info[0]['TOTAL_PERCENTAGE'];?>% Complete (success)</span>
              </div>
            </div>
            <h5>Sisa Waktu (<?=round($remainingDays, 3);?>%)</h5>
            <div class="progress">
              <div style="width: <?=$remainingDays;?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-success">
                  <span class="sr-only"><?=$remainingDays;?>% Complete (success)</span>
              </div>
            </div>
            <h5>Deviasi (<?=round($info[0]['TOTAL_PERCENTAGE']-$info[0]['TOTAL_PLANNING'], 3);?>%)</h5>
            <div class="progress">
            <?php 
              $deviation = $info[0]['TOTAL_PERCENTAGE'] - $info_extended[0]['TOTAL_PLANNING'];
              $progressBarColor = ($deviation < -10) ? 'progress-bar-danger' : (($deviation > 0 ) ? 'progress-bar-success' : 'progress-bar-warning');
            ?>
              <div style="width: <?=abs($info_extended[0]['TOTAL_PLANNING']-$info[0]['TOTAL_PERCENTAGE']);?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar" class="progress-bar <?=$progressBarColor;?>">
                  <span class="sr-only"><?=$info_extended[0]['TOTAL_PLANNING']-$info[0]['TOTAL_PERCENTAGE'];?>% Complete (success)</span>
              </div>
            </div>         
          </div>     
        </div>

        <div class="panel panel-default">
          <div class="panel-body">
            <a class="btn btn-primary btn-block" href="<?=base_url();?>#/weekly_report/detail/<?=$project['ID'];?>"><i class="fa fa-bar-chart-o"></i> Laporan Mingguan</a>
          </div>
        </div>

      </div>

      <div class="col-md-8">
        <form class="form-horizontal form-bordered" id="form-edit-project" method="POST" action="<?= base_url();?>project/add">
          <div class="panel panel-default">
            <div class="panel-body nopadding">  
              <!-- <div class="form-group">
                <label class="col-sm-4 control-label">Status Proyek</label>
                <div class="col-sm-8">
                  <select id="select-status-project" data-placeholder="Pilih Status" class="width300" name="id-status-project" readonly>
                    <option value="1">Aktif</option>
                    <option value="2">Tidak Aktif</option>
                    <option value="3">Selesai</option>
                  </select>
                </div>
              </div> -->
              <input type="hidden" name="id-project" value="<?=$project['ID'];?>" />
              <div class="form-group">
                <label class="col-sm-4 control-label">Nama Proyek</label>
                <div class="col-sm-8">
                  <input class="form-control" name="name" value="<?=$project['NAME'];?>"  <?=$disabled;?> />
                </div>
              </div><!-- form-group -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Nomor Kontrak</label>
                <div class="col-sm-8">
                  <input class="form-control" name="contract-no" value="<?=$project['CONTRACT_NO'];?>"  <?=$disabled;?> />
                </div>
              </div><!-- form-group -->
              <div class="form-group">
                  <label class="col-sm-4 control-label">Deskripsi</label>
                  <div class="col-sm-8">
                      <textarea name="description" class="form-control" rows="5" 
                  <input class="form-control" name="name" value="<?=$project['NAME'];?>" <?=$disabled;?> ><?=$project['DESCRIPTION'];?></textarea>
                  </div>
              </div> <!-- form-group -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Kontraktor / Pelaksana</label>
                <div class="col-sm-8">
                  <select id="select-id-contractor" data-placeholder="Pilih kontraktor" class="width300" name="id-contractor" <?=$disabled;?> >
                    <?php foreach ($user as $row) { ?>
                    <?php if($row['ID_USER_TYPE'] == 4){ ?>
                        <option value="<?php echo $row['ID'];?>"><?php echo $row['AFFILIATION'] . " - " . $row['NAME'];?></option>
                    <?php }; 
                    }; ?>                                          
                  </select>
                </div>
              </div><!-- form-group -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Pengawas</label>
                <div class="col-sm-8">
                  <select id="select-id-supervisor" data-placeholder="Pilih pengawas" multiple class="width300" name="id-supervisor[]" <?=$disabled;?> >
                    <?php foreach ($user as $row) { ?>
                    <?php if($row['ID_USER_TYPE'] == 3){ ?>
                        <option value="<?php echo $row['ID'];?>"><?php echo $row['NAME'];?></option>
                    <?php }; 
                    }; ?>                                          
                  </select>
                </div>
              </div><!-- form-group -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Waktu Pelaksanaan</label>
                  <div class="col-sm-3">
                      <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="start-date" name="start-date" value="<?=date_format(date_create($project['START_DATE']), 'd/m/Y');?>" <?=$disabled;?> />
                  </div>
                  <label class="col-sm-2 control-label" >Selesai</label>
                  <div class="col-sm-3">
                      <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="end-date" name="end-date" value="<?=date_format(date_create($project['FINISH_DATE']), 'd/m/Y');?>" <?=$disabled;?> />
                  </div>
              </div><!-- form-group -->
              <div class="form-group">
                  <label class="col-sm-4 control-label">Tanggal SPK</label>
                  <div class="col-sm-3">
                      <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="spk-date" name="spk-date" value="<?=@date_format(date_create($project['SPK_DATE']), 'd/m/Y');?>" <?=$disabled;?>/>
                  </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label">Nilai Proyek Tanpa PPN</label>
                <div class="col-sm-8">
                  <input class="form-control" name="project-budget" value="<?=$project['BUDGET'];?>" <?=$disabled;?> />
                </div>
              </div><!-- form-group -->
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary mr5" type="submit" <?=$disabled;?> >Simpan Perubahan</button>
            </div><!-- panel-footer -->
          </div>
        </form>
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h5>Aktifitas Terakhir</h5>
          </div>
          <div class="panel-body">
            <div class="activity-list">  
                
            </div><!-- activity-list -->
            <!-- <hr/>
            <button class="btn btn-white btn-block">Show More</button> -->
          </div>
        </div>
        
      </div>
    </div>

  </div>

  <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-body">
        <button class="btn btn-primary btn-block" id="btn-trigger-upload">Unggah Dokumen</button>
        <form id="form-upload-document" method="POST" action="<?=base_url();?>document/add">
          <input type="file" style="display:none;" name="input-upload-document" id="input-upload-document" />
          <input type="hidden" name="input-id-project" value="<?=$project['ID'];?>" />
        </form>
        <div class="mb30"></div>
        <h5 class="lg-title">Dokumen Kontrak</a></h5>
        <ul class="folder-list">
        <?php 
        if($document){
          foreach ($document as $row) { ?>
          <li>
            <a href="<?=base_url();?>document/view/<?=$row['HASH_CODE_URL'];?>" target="_blank">
              <i class="fa fa-file-o"></i><span class="pull-right btn-delete-document" data-toggle="tooltip" title="Hapus" object="<?=$row['ID'];?>">&times;</span><?=$row['ORIGINAL_FILE_NAME'];?>
            </a>
          </li>
          <?php } 
          } else { ?>
          <li><a href="#" id="no-document-li"> Belum Ada Dokumen</a></li>
          <?php }?>
        </ul>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-body nopadding">
           <form class="form-bordered" id="form-add-notice" method="POST" action="<?=base_url();?>project/update_notice/<?=$project['ID'];?>">
              <?php foreach ($notices as $a) { 
                $checked = '';
                foreach ($notice as $b) {
                  if($b['NOTICE_TYPE'] == $a['ID'] && $b['TYPE_HISTORY'] == 1){
                    $checked = 'checked="checked"';
                  }                  
                }
              ?>
              <div class="form-group">
                  <div class="col-sm-12 control-label">
                     <div class="ckbox ckbox-danger">
                        <input <?=$disabled;?> type="checkbox" id="notice-<?=$a['ID'];?>" name="notice-<?=$a['ID'];?>" class="notice-choice" value="<?=$a['ID'];?>" <?=$checked;?> />
                        <label for="notice-<?=$a['ID'];?>"><?=$a['NAME'];?></label>
                    </div>
                  </div>
              </div>
              <?php } ;?>
            </form>
        </div>
      </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $("input[name='project-budget']").priceFormat({
      prefix: '',
      thousandsSeparator: '.',
      centsSeparator: ',',
      centsLimit: 0
    });

    jQuery('#select-id-contractor').select2();
    jQuery('#select-id-contractor').select2('val', "<?=$project['ID_VENDOR'];?>");

    var supervisorSelected = [];
    <?php 
      foreach ($supervisor as $row) {
        echo 'supervisorSelected.push('.$row["ID_USER"].');';
      }
    ?>

    jQuery('#select-id-supervisor, #select-status-project').select2();
    jQuery('#select-id-supervisor').select2('val', supervisorSelected);

    jQuery('#start-date, #end-date, #spk-date, #is-finished-date').datepicker({dateFormat : "dd/mm/yy"});

    $('#btn-trigger-upload').click(function(){
      $('#input-upload-document').trigger('click');
    });

    $('#input-upload-document').change(function(){
      $('#form-upload-document').submit();
    });

    $('#form-upload-document').ajaxForm({
      clearForm: true,
      dataType: 'json',
      success: function(a,b,c,d){
        if(a.error){
          jQuery.gritter.add({
            title: 'Error',
            text: a.error,
            class_name: 'growl-danger',
            image: false,
            sticky: false,
            time: ''
          });
        } else {
          $('#no-document-li').remove();
          var newdoc = '<li><a href="<?=base_url();?>document/view/'+a.hash_code_url+'" target="_blank"><i class="fa fa-file-o"></i><span class="pull-right btn-delete-document" data-toggle="tooltip" title="Hapus" object="'+a.id+'">&times;</span>'+a.original_file_name+'</a></li>';
          $('.folder-list').append(newdoc);   
        }

        $('#btn-trigger-upload').html('Unggah Dokumen');
      },
      error: function(e){

      },
      uploadProgress: function(e,position,total,percentComplete){
        $('#btn-trigger-upload').html('Mengunggah ' + percentComplete + " %");
      }
    });

    $('.folder-list').delegate('.btn-delete-document','click', function(){
      var self = this;
      var id = $(self).attr('object');
      var c = confirm("Apakah anda yakin untuk menghapus data ini?");
      if(c){
        $.ajax({
          url: '<?=base_url();?>document/remove/' + id,
          dataType: 'json'
        })
        .done(function(a){
          if(a.status == 0){
            $(self).parent().parent().remove();
          }
        })
        .fail(function(e){
          
        });
      }
      return false;
    });

    // edit project
    $('#form-edit-project').ajaxForm({
      dataType: 'json',
      success: function(a,b,c,d){
        if(a.status == 'ok'){
          jQuery.gritter.add({
            title: 'Info',
            text: 'Simpan perubahan berhasil.',
            class_name: 'growl-info',
            image: false,
            sticky: false,
            time: ''
          });
        } else {
          jQuery.gritter.add({
            title: 'Error',
            text: 'Terjadi Kesalahan, silahkan refresh halaman ini.',
            class_name: 'growl-danger',
            image: false,
            sticky: false,
            time: ''
          });
        }
      },
      error: function(){
        jQuery.gritter.add({
          title: 'Error',
          text: 'Terjadi Kesalahan, silahkan refresh halaman ini.',
          class_name: 'growl-danger',
          image: false,
          sticky: false,
          time: ''
        });
      }
    });

    /** checkbox surat peringatan */
    $('.notice-choice').change(function(){
      var isChecked = $(this).is(':checked');
      var name = $(this).next().html();
      var value = $(this).val();
      var self = this;

      var c = confirm("Apakah anda yakin untuk mengubah status proyek?");
      if(c){
        $.ajax({
          url: "<?=base_url();?>project/update_notice/<?=$project['ID'];?>",
          type: 'POST',
          dataType: 'json',
          data: {
            'name': name,
            'is-checked' : (isChecked) ? 1 : 0,
            'value' : value
          }
        })
        .done(function(a){
          if(a.status == 'ok'){
            jQuery.gritter.add({
              title: 'Info',
              text: 'Simpan perubahan berhasil.',
              class_name: 'growl-info',
              image: false,
              sticky: false,
              time: ''
            });
          } else {
            toggleCheck(isChecked, self);
          }
        })
        .fail(function(){
          toggleCheck(isChecked, self);
        })
      } else {
        toggleCheck(isChecked, self);
      }
      return false;
    });

    function toggleCheck(isChecked, ctx){
      if(isChecked){
        $(ctx).removeAttr('checked');
      } else {
        $(ctx).attr('checked', 'checked');
      }      
    }

    /* checkbox surat selesai */
    $('.project-finished').change(function(){
      var isChecked = $(this).is(':checked');
      var name = $(this).next().html();
      var value = $(this).val();
      var self = this;
      var finishDate = $('#is-finished-date').val();
      var question = "Apakah anda yakin akan membatalkan penetapan waktu selesainya proyek ini?";

      if(isChecked){
        question = "Apakah anda yakin menetapkan proyek selesai pada tanggal "+finishDate+"?";
      } 

      var c = confirm(question);
      if(c){
        $.ajax({
          url: "<?=base_url();?>project/set_finish/<?=$project['ID'];?>",
          type: 'POST',
          dataType: 'json',
          data: {
            'name': name,
            'is-checked' : (isChecked) ? 1 : 0,
            'value' : value,
            'is-finished-date' : finishDate
          }
        })
        .done(function(a){
          if(a.status == 'ok'){
            jQuery.gritter.add({
              title: 'Info',
              text: 'Simpan perubahan berhasil.',
              class_name: 'growl-info',
              image: false,
              sticky: false,
              time: ''
            });
            location.reload();
          } else {
            toggleCheck(isChecked, self);
          }
        })
        .fail(function(){
          toggleCheck(isChecked, self);
        })
      } else {
        toggleCheck(isChecked, self);
      }
      return false;
    });


    $.ajax({
      url: "<?=base_url();?>project/load_log/<?=$project['ID'];?>",
      dataType: 'json'
    })
    .done(function(res){
      if(res.status == 'ok'){
        var html = '';
        
        for(var i=0;i<res.data.length;i++){
          html += '<div class="media">'
                    + '<a class="pull-left" href="#">'
                    +   '<img class="media-object img-circle" src="<?=base_url();?>public/images/photos/user1.png" alt="" />'
                    + '</a>'
                    + '<div class="media-body">'
                    +   '<strong>'+res.data[i].USERNAME+'</strong> <br />'+ decodeHtml(res.data[i].DESCRIPTION) + '<br />'
                    +   '<small class="text-muted">' + res.data[i].CREATED + '</small>'
                    + '</div>'
                + '</div>';
        }

        $('.activity-list').append(html);
      }
    })
    .fail(function(){

    });

    function decodeHtml(html) {
      var txt = document.createElement("textarea");
      txt.innerHTML = html;
      return txt.value;
    }

    $('#button-delete-project').click(function(){
      var id = $(this).attr('object');
      if (confirm('Apakah anda yakin menghapus Proyek ini ?')) { 
        $.ajax({
          url: '<?php echo base_url();?>project/remove/' + id,
          dataType: 'json'
        })
        .done(function(response, textStatus, jqhr){
          if(response.status == 'ok'){
            jQuery.gritter.add({
              title: 'Info',
              text: 'Hapus proyek berhasil, Halaman akan dialihkan...',
              class_name: 'growl-info',
              image: false,
              sticky: false,
              time: ''
            });
            window.location.replace("<?=base_url();?>#/projects");
          } else {
            jQuery.gritter.add({
              title: 'Error',
              text: 'Terjadi Kesalahan, silahkan refresh halaman ini.',
              class_name: 'growl-danger',
              image: false,
              sticky: false,
              time: ''
            });
          }
        })
        .fail(function(){
          jQuery.gritter.add({
            title: 'Error',
            text: 'Terjadi Kesalahan, silahkan refresh halaman ini.',
            class_name: 'growl-danger',
            image: false,
            sticky: false,
            time: ''
          });
        });
      }

      return false;
    });
  });
    
</script>