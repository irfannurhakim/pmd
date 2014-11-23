<div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/projects';return false;"><i class="fa fa-arrow-left mr5"></i> Daftar Proyek</button>    
      </div>  
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/item/project/<?=$project['ID'];?>'; return false;"><i class="fa fa-list-ul mr5"></i> Item Pekerjaan</button>
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/item/periode/<?=$project['ID'];?>'; return false;"><i class="fa fa-clock-o mr5"></i> Rencana Pekerjaan</button>
      </div>
      <div class="btn-group">
          <button class="btn btn-default btn-sm" type="button"><i class="fa fa-trash-o mr5"></i> Hapus</button>
      </div>
    </div>
  </div>
</div>
<hr/>
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="text-center">
          <p>Saat ini,</p>
          <h4>Minggu ke-<?=$weekNumber;?></h4>
          <p>Tgl <?=$startWeek . ' - ' . $endWeek;?></p>
        </div>
      </div><!-- panel-body -->
    </div>
  
    <div class="panel panel-default">
<!--     <div class="panel-heading">
      <h3 class="panel-title">Statistik Proyek</h3>
    </div> -->
      <div class="panel-body">
        <h5>Rencana (50%)</h5>
        <div class="progress">
          <div style="width: 50%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-success">
              <span class="sr-only">50% Complete (success)</span>
          </div>
        </div>
        <h5>Pekerjaan Selesai (40%)</h5>
        <div class="progress">
          <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
              <span class="sr-only">40% Complete (success)</span>
          </div>
        </div>
        <h5>Sisa Waktu (60%)</h5>
        <div class="progress">
          <div style="width: 60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-success">
              <span class="sr-only">40% Complete (success)</span>
          </div>
        </div>
        <h5>Deviasi (-10%)</h5>
        <div class="progress">
          <div style="width: 10%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar" class="progress-bar progress-bar-warning">
              <span class="sr-only">40% Complete (success)</span>
          </div>
        </div>         
      </div>     
    </div>

  </div>

  <div class="col-md-6">
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
            <label class="col-sm-4 control-label">Nomor Kontrak</label>
            <div class="col-sm-8">
              <input class="form-control" name="contract-no" value="<?=$project['CONTRACT_NO'];?>" >
            </div>
          </div><!-- form-group -->
          <div class="form-group">
            <label class="col-sm-4 control-label">Kontraktor / Pelaksana</label>
            <div class="col-sm-8">
              <select id="select-id-contractor" data-placeholder="Pilih kontraktor" class="width300" name="id-contractor">
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
              <select id="select-id-supervisor" data-placeholder="Pilih pengawas" multiple class="width300" name="id-supervisor[]">
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
                  <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="start-date" name="start-date" value="<?=date_format(date_create($project['START_DATE']), 'd/m/Y');?>"/>
              </div>
              <label class="col-sm-2 control-label" >Selesai</label>
              <div class="col-sm-3">
                  <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="end-date" name="end-date" value="<?=date_format(date_create($project['FINISH_DATE']), 'd/m/Y');?>"/>
              </div>
          </div><!-- form-group -->
          <div class="form-group">
            <label class="col-sm-4 control-label">Nilai Proyek</label>
            <div class="col-sm-8">
              <input class="form-control" name="project-budget" value="<?=$project['BUDGET'];?>" >
            </div>
          </div><!-- form-group -->
        </div>
        <div class="panel-footer">
            <button class="btn btn-primary mr5" type="submit">Simpan Perubahan</button>
        </div><!-- panel-footer -->
      </div>
    </form>
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
  </div>
</div>

<div class="row">
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h5>Aktifitas Terakhir</h5>
      </div>
      <div class="panel-body">
        <div class="activity-list">  
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object img-circle" src="<?=base_url();?>public/images/photos/user1.png" alt="" />
                </a>
                <div class="media-body">
                    <strong>Ray Sin</strong> started following <strong>Eileen Sideways</strong>. <br />
                    <small class="text-muted">Yesterday at 3:30pm</small>
                </div>
            </div><!-- media -->
            
        </div><!-- activity-list -->
        <hr/>
        <button class="btn btn-white btn-block">Show More</button>
      </div>
    </div>
    
  </div>
  <div class="col-md-9"></div>
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

    jQuery('#select-id-supervisor').select2();
    jQuery('#select-id-supervisor').select2('val', supervisorSelected);

    jQuery('#select-status-project').select2();

    jQuery('#start-date').datepicker({dateFormat : "dd/mm/yy"});
    jQuery('#end-date').datepicker({dateFormat : "dd/mm/yy"});

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
            title: 'Upss..',
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
      success: function(a,b,c,d){
        if(a){
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
            title: 'Upss..',
            text: 'Terjadi Kesalahan, silahkan refresh halaman ini.',
            class_name: 'growl-danger',
            image: false,
            sticky: false,
            time: ''
          });
        }
      }
    });

  });
    
</script>