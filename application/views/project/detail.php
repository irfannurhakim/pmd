<div class="media-options">
  <div class="pull-left">
   <h5><?=$project['NAME'];?></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:history.go(-1);return false;"><i class="fa fa-arrow-left mr5"></i> Daftar Proyek</button>     
      </div>  
      <div class="btn-group">
          <button class="btn btn-default btn-sm" type="button"><i class="fa fa-pencil mr5"></i> Edit</button>
          <button class="btn btn-default btn-sm" type="button"><i class="fa fa-trash-o mr5"></i> Hapus</button>
      </div>
    </div>
  </div>
</div>
<hr/>
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-8">

        <form class="form-horizontal form-bordered">
          <div class="panel panel-default">

            <div class="panel-body nopadding">  
              <div class="form-group">
                <label class="col-sm-4 control-label">Nomor Kontrak</label>
                <div class="col-sm-8">
                  <input class="form-control" name="contract-no" value="<?=$project['CONTRACT_NO'];?>" readonly>
                </div>
              </div><!-- form-group -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Nilai Proyek</label>
                <div class="col-sm-8">
                  <input class="form-control" name="project-budget" value="<?=$project['BUDGET'];?>" readonly>
                </div>
              </div><!-- form-group -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Kontraktor / Pelaksana</label>
                <div class="col-sm-8">

                </div>
              </div><!-- form-group -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Pengawas</label>
                <div class="col-sm-8">
                  
                </div>
              </div><!-- form-group -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Waktu Pelaksanaan</label>
                <div class="col-sm-8">
                
                </div>
              </div><!-- form-group -->

            </div>
          </div>
        </form>
      </div>

      <div class="col-md-4">
        <div class="media-manager-sidebar">         
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
</div>


<script type="text/javascript">
  $(document).ready(function(){
    $("input[name='project-budget']").priceFormat({
      prefix: '',
      thousandsSeparator: '.',
      centsSeparator: ',',
      centsLimit: 0
    });

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

  });
    
</script>