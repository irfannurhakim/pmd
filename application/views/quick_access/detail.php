<div class="media-options">
  <div class="pull-left">
   <h5><a href="<?=base_url();?>#/project/view/<?=$project['ID'];?>"><?=$project['NAME'];?></a></h5>  
  </div>
  <div class="pull-right">
    <div class="btn-toolbar">
      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/quick_access';return false;"><i class="fa fa-arrow-left mr5"></i> Daftar Proyek</button>    
      </div>  
    </div>
  </div>
</div>
<hr/>
<div class="row">
  <div class="col-md-12">
    <div class="row row-stat">
      <div class="col-md-4">
          <div class="panel panel-dark noborder">
              <div class="panel-heading noborder">
                  <div class="panel-btns">
                      <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                  </div>
                  <div class="panel-icon"><i class="fa fa-calendar"></i></div>
                  <div class="media-body">
                      <h5 class="md-title nomargin">Minggu Ke</h5>
                      <h1 class="mt5"><?=$weekNumber;?></h1>
                  </div>
                  <hr>
                  <div class="clearfix mt20">
                      <div class="pull-left">
                          <h5 class="md-title nomargin">Periode Awal</h5>
                          <h4 class="nomargin"><?=$startWeek;?></h4>
                      </div>
                      <div class="pull-right">
                          <h5 class="md-title nomargin">Periode Akhir</h5>
                          <h4 class="nomargin"><?=$endWeek;?></h4>
                      </div>
                  </div>
                  
              </div>
          </div>
      </div>

      <div class="col-md-4">
          <div class="panel panel-dark noborder">
              <div class="panel-heading noborder">
                  <div class="panel-btns">
                      <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                  </div>
                  <div class="panel-icon"><i class="fa fa-flag-checkered"></i></div>
                  <div class="media-body">
                      <h5 class="md-title nomargin">realisasi pengawas</h5>
                      <h1 class="mt5"><span id="total-progress">0</span> %</h1>
                  </div>
                  <hr>
                  <div class="clearfix mt20">
                      <div class="pull-left">
                          <h5 class="md-title nomargin">Minggu Kemarin</h5>
                          <h4 class="nomargin"><span id="total-previous-week">0</span> %</h4>
                      </div>
                      <div class="pull-right">
                          <h5 class="md-title nomargin">Minggu ini</h5>
                          <h4 class="nomargin"><span id="total-current-week">0</span> %</h4>
                      </div>
                  </div>
                  
              </div>
          </div>
      </div>

      <div class="col-md-4">
          <div class="panel panel-dark noborder">
              <div class="panel-heading noborder">
                  <div class="panel-btns">
                      <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                  </div>
                  <div class="panel-icon"><i class="fa fa-check-square-o"></i></div>
                  <div class="media-body">
                      <h5 class="md-title nomargin">realisasi kontraktor</h5>
                      <h1 class="mt5"><span id="total-progress-vendor">0</span> %</h1>
                  </div>
                  <hr>
                  <div class="clearfix mt20">
                      <div class="pull-left">
                          <h5 class="md-title nomargin">Minggu Kemarin</h5>
                          <h4 class="nomargin"><span id="total-previous-week-vendor">0</span> %</h4>
                      </div>
                      <div class="pull-right">
                          <h5 class="md-title nomargin">Minggu ini</h5>
                          <h4 class="nomargin"><span id="total-current-week-vendor">0</span> %</h4>
                      </div>
                  </div>
                  
              </div>
          </div>
      </div>                       
    </div>

    <table class="table table-bordered table-hover table-item-list responsive" id="tbl-realisasi">
      <thead>
        <tr>
          <th width="20px" rowspan="2" class="dt-cols-center">No</th>
          <th rowspan="2">Uraian Pekerjaan</th>
          <th rowspan="2" width="20px">Bobot Total</th>
          <th colspan="3" class="dt-cols-center">Volume</th>
          <th colspan="2" class="dt-cols-center">Bobot (%)</th>
          <th rowspan="2" class="dt-cols-center" width="60px">Ket.</th>
        </tr>
        <tr>
          <th width="20px" class="dt-cols-center">Rencana</th>
          <th width="20px" class="dt-cols-center">Realisasi Pengawas</th>
          <th width="20px" class="dt-cols-center">Realisasi Kontraktor</th>
          <th width="20px" class="dt-cols-center">Rencana</th>
          <th width="20px" class="dt-cols-center">Realisasi</th>                        
        </tr>
      </thead>
      <tbody class="selectable">
        <?php
          $i = 1;
          foreach ($items as $item) {
            $bobot = round((($item['UNIT_PRICE'] * $item['VOLUME']) / $project['BUDGET'] ) * 100, 3);
            $vol = ($item['VOLUME'] > 0) ? round((($item['SUPERVISOR_PROGRESS_VOLUME'] / $item['VOLUME']) * $bobot), 3) : 0;
        ?>
        <tr item-name="<?=$item['NAME'];?>" object="<?=$item['ID_ITEM_TASK'];?>" planningvolume="<?=round($item['VOLUME'], 3);?>" realizationbefore="<?=round($item['SUPERVISOR_PROGRESS_VOLUME'], 3);?>" realizationvendor="<?=round($item['VENDOR_PROGRESS_VOLUME'], 3);?>" bobot="<?=$bobot;?>">
          <td class="dt-cols-center"><?=(round($item['VOLUME'], 4) == round($item['SUPERVISOR_PROGRESS_VOLUME'], 4)) ? '<span class="label label-success">'.$i.'</span>' : $i ;?></td>          <td ><?=$item['NAME'];?></td>
          <td class="dt-cols-right"><?=$bobot;?></td>
          <td class="dt-cols-right"><?=round($item['VOLUME'], 3);?></td>
          <td class="dt-cols-right"><?=round($item['SUPERVISOR_PROGRESS_VOLUME'], 3);?></td>
          <td class="dt-cols-right"><?=round($item['VENDOR_PROGRESS_VOLUME'], 3);?></td>
          <td class="dt-cols-right"><?=round($item['WEIGHT_PLANNING'], 3);?></td>
          <td class="dt-cols-right"><?=$vol;?></td>
          <td class="dt-cols-center">
                <span class="badge" id="total-comment-<?=$item['ID_ITEM_TASK'];?>"><i class="fa fa-comments"></i> <?=($item['COMMENTS']) ? $item['COMMENTS'] : 0;?></span>
          </td>
        </tr>
        <?php $i++; } ?>

        <tfoot>
            <tr>
                <th colspan="2" style="text-align:right">Total:</th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th class="dt-cols-right"></th>
                <th></th>
            </tr>
        </tfoot>
      </tbody>
    </table>    
  </div>
</div>

<div class="modal fade bs-example-modal" tabindex="-1" role="dialog" id="modal-add-realisasi" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Input Realisasi</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                </div>
                <div class="panel-body">
                  <form class="form-horizontal" id="form-add-realization" method="POST" action="<?= base_url();?>item_task/update_realization">
                    <div class="errorForm"></div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Nama Pekerjaan</label>
                      <div class="col-sm-9">
                        <input type="text" value="" class="form-control" readonly="readonly" name="item-name" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Vol. Perencanaan</label>
                      <div class="col-sm-2">
                        <input type="text" value="0" class="form-control" readonly="readonly" name="planning-volume" />
                      </div>
                      <label class="col-sm-2 control-label">Terealisasi</label>
                      <div class="col-sm-2">
                        <input type="text" value="0" class="form-control" readonly="readonly" name="real-volume" />
                      </div>
                      <label class="col-sm-1 control-label">Sisa</label>
                      <div class="col-sm-2">
                        <input type="text" value="0" class="form-control" readonly="readonly" name="unreal-volume" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label"></label>
                      <div class="col-sm-5">
                        <div class="ckbox ckbox-success">
                          <input type="checkbox" value="1" class="item-finished" name="item-finished" id="item-finished" />
                          <label for="item-finished">Pekerjaan telah selesai 100%?</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Vol. Realisasi<span class="asterisk">*</span></label>
                        <?php if($this->session->userdata('ID_USER_TYPE') == 3 || $this->session->userdata('ID_USER_TYPE') == 1 || $this->session->userdata('ID_USER_TYPE') == 2 ){ ?>
                        <div class="col-sm-2">
                          <input type="text" name="supervisor-volume" class="form-control" required title="Kolom Volume wajib diisi!" />
                        </div>
                        <?php } ?> 

                        <?php if($this->session->userdata('ID_USER_TYPE') == 4 || $this->session->userdata('ID_USER_TYPE') == 1 || $this->session->userdata('ID_USER_TYPE') == 2 ){ ?> 
                        <div class="col-sm-2">
                          <input type="text" name="vendor-volume" class="form-control" required title="Kolom Volume wajib diisi!"  />
                        </div>
                        <?php } ?>
                        <div class="col-sm-2">
                          <button class="btn btn-primary" id="btn-save-realization" type="submit">Simpan</button>
                        </div>
                    </div><!-- form-group -->

                    <!-- Hidden Field -->
                    <input type="hidden" name="id-item-task" value="-1" />
                    <input type="hidden" name="week-number" value="<?=$weekNumber;?>" />
                    <input type="hidden" name="start-week" value="<?=$startWeek;?>" />
                    <input type="hidden" name="end-week" value="<?=$endWeek;?>" />
                    <input type="hidden" name="bobot-item" value="-1" />
                    <input type="hidden" name="planning-item" value="-1" />
                    <input type="hidden" name="realization-before" value="-1" />
                    <input type="hidden" name="realization-vendor" value="-1" />
                    <input type="hidden" name="id-project" value="<?=$project['ID'];?>" />
                  </form>

                  <div class="mb30"></div>

                  <h5>Komentar</h5>
                  <hr style="margin-top:10px;" />
                  <form id="form-add-comment" action="<?=base_url();?>item_task/add_comment" method="POST">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="text-center">
                          <img class="img-circle img-offline" src="<?=base_url(). $this->session->userdata('PROFILE_IMAGE_URL');?>" alt="..." width="45px">
                          <span><?=$this->session->userdata('NAME');?></span>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <textarea rows="3" class="form-control" name="comment"></textarea>
                      <input type="hidden" name="id-item-task" value="-1" />
                      <input type="hidden" name="id-image-attachment" id="id-image-attachment" />
                    </div>
                  </div>
                  <div class="mb10"></div>
                  <div class="row">
                    <div class="col-md-2">    
                    </div>
                    <div class="col-md-6">
                      <div id="thumbnail-image">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <button class="btn btn-primary pull-right" id="btn-send-comment" type="submit">Kirim</button>
                      <button class="btn btn-default pull-right mr5 tooltips" title="Sertakan Foto" data-toggle="tooltip" type="button" id="btn-attach-image"><i class="fa fa-camera"></i></button>
                    </div>
                  </div>
                  </form>
                  <hr/>
                  <div class="activity-list">  

                  </div><!-- activity-list -->

                </div><!-- panel-body -->
              </div><!-- panel-default -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<form action="<?=base_url();?>item_task/add_attachment" method="POST" id="form-upload-attachment">
  <input type="file" style="display:none;" name="image-attachment" id="image-attachment" />
</form>




<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      url: "<?=base_url();?>quick_access/insight/<?=$project['ID'];?>/<?=$weekNumber;?>",
      dataType: "json",
      success: function(res){
        if(res.status == 'ok'){
          $('#total-progress').html(Math.round(res.data[0].TOTAL_PERCENTAGE * 1000) / 1000);
          $('#total-current-week').html(Math.round(res.data[0].TOTAL_PERCENTAGE_NOW * 1000) / 1000);
          $('#total-previous-week').html(Math.round(res.data[0].TOTAL_PERCENTAGE_BEFORE * 1000) / 1000);
          $('#total-progress-vendor').html(Math.round(res.data[0].TOTAL_PERCENTAGE_VENDOR * 1000) / 1000);
          $('#total-current-week-vendor').html(Math.round(res.data[0].TOTAL_PERCENTAGE_NOW_VENDOR * 1000) / 1000);
          $('#total-previous-week-vendor').html(Math.round(res.data[0].TOTAL_PERCENTAGE_BEFORE_VENDOR * 1000) / 1000);
        }
      }
    });  

    $('.item-finished').change(function(){
      var isChecked = $(this).is(':checked');
      var maxVol = $("input[name='planning-volume']").val();

      if(isChecked){
        $("input[name='supervisor-volume']").val(maxVol);
        $("input[name='vendor-volume']").val(maxVol);
      } else {
        $("input[name='supervisor-volume']").val('');
        $("input[name='vendor-volume']").val('');
      }
    });

    jQuery('.select-week').select2();

    jQuery("#tbl-realisasi").DataTable({
      paging : false,
      ordering: false,
      responsive: false,
      footerCallback: function ( row, data, start, end, display ) {
          var api = this.api(), data;
          var total = 0;
          var totalBobot = 0;
          var tBobot = 0, tVRencana = 0, tVRealP = 0, tVRealS = 0, tBRencana = 0, tBRencana = 0, tBRealisasi = 0;
          // Remove the formatting to get integer data for summation
          var intVal = function ( i ) {
              return typeof i === 'string' ? i.replace(/[.]/g, '')*1 : typeof i === 'number' ? i : 0;
          };

          var floatVal = function ( i ) {
              return typeof i === 'string' ? parseFloat(i*1) : typeof i === 'number' ? parseFloat(i) : 0;
          };

          if(data.length > 1){
            // Total over all pages
            tBobot = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                });
            tVRencana = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                });
            tVRealP = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                });          
            tVRealS = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                });
            tBRencana = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                });
            tBRealisasi = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return floatVal(a) + floatVal(b);
                });
          } 
          
          // Update footer
          $( api.column( 2 ).footer() ).html(
              Math.round(tBobot * 1000) / 1000
          );
          $( api.column( 3 ).footer() ).html(
              Math.round(tVRencana * 1000) / 1000
          );
          $( api.column( 4 ).footer() ).html(
              Math.round(tVRealP * 1000) / 1000
          );
          $( api.column( 5 ).footer() ).html(
              Math.round(tVRealS * 1000) / 1000
          );
          $( api.column( 6 ).footer() ).html(
              Math.round(tBRencana * 1000) / 1000
          );
          $( api.column( 7 ).footer() ).html(
              Math.round(tBRealisasi * 1000) / 1000
          );
      }
    });

    $('.table-item-list tbody').on( 'click', 'tr', function () {
      $('#modal-add-realisasi').modal('show');

      var id = $(this).attr('object');
      var vol = $(this).attr('planningvolume');
      var bi = $(this).attr('bobot');
      var rb = $(this).attr('realizationbefore');
      var rv = $(this).attr('realizationvendor');
      var unreal = (vol - rb) * 1;
      var itemName = $(this).attr('item-name');

      $("input[name='id-item-task']").val(id);
      $("input[name='planning-volume']").val(vol);
      $("input[name='planning-item']").val(vol);
      $("input[name='bobot-item']").val(bi);
      $("input[name='realization-before']").val(rb);
      $("input[name='realization-vendor']").val(rv);
      $("input[name='real-volume']").val(rb);
      $("input[name='unreal-volume']").val(unreal);
      $("input[name='item-name']").val(itemName);
      $("input[name='supervisor-volume']").val('');
      $("input[name='vendor-volume']").val('');
      $('#item-finished').removeAttr('checked');


      loadComment(id);
    });

    $('#form-add-realization').ajaxForm({
      clearForm: true,
      dataType: 'json',
      beforeSubmit: function(a,b,c){
        if(($("input[name='supervisor-volume']").val()*1 > $("input[name='planning-item']").val()*1) || ($("input[name='vendor-volume']").val()*1 > $("input[name='planning-item']").val()*1)){
          alert('Nilai Realisasi tidak boleh LEBIH dari Volume Perencanaan!');
          return false;
        }
        $('#btn-save-realization').html("Menyimpan...");
        $('#btn-save-realization').attr("disable", "disable");
        // if(($("input[name='supervisor-volume']").val()*1 <= $("input[name='realization-before']").val()*1) || ($("input[name='vendor-volume']").val()*1 <= $("input[name='realization-before']").val()*1)){
        //   alert('Nilai Realisasi tidak boleh KURANG dari volume yang telah Teralisasi!');
        //   return false;
        // }      
      },
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

          location.reload();
        } else {
          jQuery.gritter.add({
            title: 'Error',
            text: 'Terjadi kesalahan, silahkan refresh browser anda!',
            class_name: 'growl-danger',
            image: false,
            sticky: false,
            time: ''
          });
        }

        $('#btn-save-realization').html("Simpan");
        $('#btn-save-realization').removeAttr("disable");
      },
      error: function(){
        jQuery.gritter.add({
          title: 'Error',
          text: 'Terjadi kesalahan, silahkan refresh browser anda!',
          class_name: 'growl-danger',
          image: false,
          sticky: false,
          time: ''
        });

        $('#btn-save-realization').html("Simpan");
        $('#btn-save-realization').removeAttr("disable");
      }
    });

    $('#form-add-comment').ajaxForm({
      clearForm: true,
      dataType: 'json',
      beforeSubmit: function(){
        $('#btn-send-comment').html("Mengirim...");
        $('#btn-send-comment').attr("disable", "disable");
      },
      success: function(a,b,c,d){
        if(a.status == 'ok'){
          loadComment(a.data.c);
          $('#thumbnail-image').html('');
          $('#id-image-attachment').val('');
        } else {
          jQuery.gritter.add({
            title: 'Error',
            text: 'Terjadi kesalahan, silahkan refresh browser anda!',
            class_name: 'growl-danger',
            image: false,
            sticky: false,
            time: ''
          });
        }

        $('#btn-send-comment').html("Kirim");
        $('#btn-send-comment').removeAttr("disable");
      },
      error: function(){
        jQuery.gritter.add({
          title: 'Error',
          text: 'Terjadi kesalahan, silahkan refresh browser anda!',
          class_name: 'growl-danger',
          image: false,
          sticky: false,
          time: ''
        });
        
        $('#btn-send-comment').html("Kirim");
        $('#btn-send-comment').removeAttr("disable");
      }
    });

    $('#btn-attach-image').click(function(){
      $('#image-attachment').trigger('click');
    });

    $('#image-attachment').change(function(){
      $('#form-upload-attachment').submit();
    });

    $('#form-upload-attachment').ajaxForm({
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
          $('#thumbnail-image').append('<img src="<?=base_url();?>uploads/'+a.file_name+'" style="width:32px;height:32px;border:1px #ddd solid;" class="mr5" title="'+a.original_file_name+'" data-toggle="tooltip"/>');
          var val = $('#id-image-attachment').val();
          $('#id-image-attachment').val(val + ',' + a.id);
        }

        $('#btn-attach-image').html('<i class="fa fa-camera"></i>');
      },
      error: function(e){
        jQuery.gritter.add({
          title: 'Error',
          text: e,
          class_name: 'growl-danger',
          image: false,
          sticky: false,
          time: ''
        });

        $('#btn-attach-image').html('<i class="fa fa-camera"></i>');
      },
      uploadProgress: function(e,position,total,percentComplete){
        $('#btn-attach-image').html(percentComplete + " %");
      }
    });
  });

  function loadComment(id){
      //LOAD COMMENT
      $.ajax({
        url: '<?=base_url();?>item_task/get_comment/' + id,
        dataType: 'json',
        beforeSend: function(){
          var html = '<div class="text-center mt20"><img alt="" src="<?=base_url();?>public/images/loaders/loader19.gif"></div>';
          $('.activity-list').html(html);
        }
      })
      .done(function(res){
        if(res.status == 'ok'){
          var html = '';
          for (var i = 0; i < res.data.length; i++) {
            var imageHtml = '';
            if(res.data[i].images.length > 0){
              imageHtml = '<ul class="uploadphoto-list">';
              for (var j = 0; j < res.data[i].images.length; j++) {
                imageHtml += '<li><a href="<?=base_url();?>uploads/'+res.data[i].images[j].FILE_NAME+'" data-rel="prettyPhoto"><img src="<?=base_url();?>uploads/'+res.data[i].images[j].FILE_NAME+'" class="thumbnail img-responsive" alt="" /></a></li>';
              };   
              imageHtml += '</ul>';
            }

            html += '<div class="media">' +
                      '<a class="pull-left" href="#">' + 
                          '<img class="media-object img-circle" src="<?=base_url();?>'+res.data[i].PROFILE_IMAGE_URL+'" alt="" />' + 
                      '</a>' +
                      '<div class="media-body">' +
                          '<strong>' + res.data[i].NAME + '</strong><br />' +
                          '<small class="text-muted">'+ res.data[i].CREATED /**moment(res.data[i].CREATED, 'DD/MM/YYYY HH:mm:ss').fromNow()**/ +'</small>' + 
                          
                          '<div class="media blog-media">' +
                            '<div class="media-body">' +
                                '<p>'+ res.data[i].POST +'</p>' + 
                            '</div>' +
                          '</div>' + 
                          imageHtml +
                      '</div>'+
                    '</div>';
          };

          $('.activity-list').html(html);
          $('#total-comment-' + id ).html('<i class="fa fa-comments"></i> ' + res.data.length);
          jQuery("a[data-rel^='prettyPhoto']").prettyPhoto();
        }
      })
      .fail(function(e){

      });
    }
</script>
