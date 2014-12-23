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
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/project/view/<?=$project['ID'];?>';return false;"><i class="fa fa-arrow-left mr5"></i> Detail Proyek</button>     
      </div>  

      <div class="btn-group">
        <button class="btn btn-default btn-sm" type="button" onclick="javascript:window.location = '<?=base_url();?>#/item/periode/<?=$project['ID'];?>'; return false;"><i class="fa fa-clock-o mr5"></i> Perencanaan</button>
      </div>

      <div class="btn-group">
        <button class="btn btn-default btn-sm add-data" type="button" data-toggle="modal" data-target=".modal-add-item"><i class="fa fa-plus mr5"></i> Tambah </button>
        <?=$btnImport;?>
        <a href="<?=base_url();?>item_task/export/<?=$project['ID'];?>" target="_blank" class="btn btn-default btn-sm export-data"><i class="fa fa-upload mr5"></i> Ekspor </a>
      </div>
    </div>
  </div>
</div>
<hr/>

<div class="container-dt">
  <table class="table table-bordered table-hover table-item-list" id="table-list-item" style="margin:0px!important;">
    <thead class="">
      <tr>
        <th class="text-center" width="30px">No.</th>
        <th width="150px">Uraian Pekerjaan</th>
        <th>Spesifikasi</th>
        <th class="text-center" width="30px">Satuan</th>
        <th class="text-center" width="30px">Vol</th>
        <th class="text-center" width="60px">Harga Satuan (Rp)</th>
        <th class="text-center" width="50px">Bobot (%)</th>
        <th class="text-center" width="80px">Jumlah (Rp)</th>
        <th width="50px"></th>
      </tr>
    </thead>

    <tfoot>
        <tr>
            <th colspan="6" style="text-align:right">Total:</th>
            <th class=" dt-cols-right"></th>
            <th class="col-total dt-cols-right"></th>
            <th></th>
        </tr>
    </tfoot>

    <tbody>
      <?= $rows;?>
    </tbody>
  </table>
</div>


<div class="modal fade modal-add-item" tabindex="-1" role="dialog" id="modal-add-item" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Buat Item Baru</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" id="form-add-item" method="POST" action="<?= base_url();?>item_task/add">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                </div>
                <div class="panel-body">
                  <div class="errorForm"></div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Parent Item</label>
                      <div class="col-sm-8">
                          <select id="select-id-parent" data-placeholder="Pilih Item"  class="width300" name="id-parent">
                            <option value="0">Level Pekerjaan Teratas</option>
                            <?php foreach ($item_list as $row) { ?>
                                <option value="<?php echo $row['ID'];?>"><?php echo $row['NAME'];?></option>
                            <?php }; ?>
                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Nama Item<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="name" id="name" class="form-control" required title="Kolom Nama Item wajib diisi!" />
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Spesifikasi<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <textarea name="specification" id="specification" rows="3" class="form-control" required title="Kolom Spesifikasi wajib diisi!" class="col-sm-8"></textarea>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Volume<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <input type="text" name="volume" id="volume" class="form-control" required title="Kolom Volume wajib diisi!" value="0" />
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Satuan<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <input type="text" name="unit" id="unit" class="form-control" required title="Kolom Satuan wajib diisi!"  />
                      </div>
                  </div>

                   <div class="form-group">
                      <label class="col-sm-4 control-label">Harga Satuan<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <input type="text" name="unit_price" id="unit_price" class="form-control" required title="Kolom Value wajib diisi!" value="0" />
                      </div>
                  </div>

                  <!-- Hidden Field -->
                  <input type="hidden" name="id" id="id" value="-1" />
                  <input type="hidden" name="is-edit" id="is-edit" value="0" />
                  <input type="hidden" name="id-project" id="id-project" value="<?=$project['ID'];?>" />
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-primary mr5" type="submit">Submit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div><!-- panel-footer -->
              </div><!-- panel-default -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-import" tabindex="-1" role="dialog" id="modal-import" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Impor dari Excel</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" id="form-import" method="POST" action="<?= base_url();?>item_task/import">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                </div>
                <div class="panel-body">
                  <div class="errorForm"></div>
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Nama Item<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="file" name="import-file" id="import-file" class="form-control" required title="File belum ditentukan!" />
                      </div>
                  </div>

                  <!-- Hidden Field -->
                  <input type="hidden" name="id-project" id="id-project" value="<?=$project['ID'];?>" />
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-primary mr5" type="submit" id="btn-process-import">Proses</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div><!-- panel-footer -->
              </div><!-- panel-default -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    var table = $('#table-list-item').DataTable({
      paging : false,
      ordering : false,
      footerCallback: function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var total = 0;
            var totalBobot = 0;
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ? i.replace(/[.]/g, '')*1 : typeof i === 'number' ? i : 0;
            };

            var floatVal = function ( i ) {
                return typeof i === 'string' ? parseFloat(i*1) : typeof i === 'number' ? parseFloat(i) : 0;
            };
 
            if(data.length > 1){
              // Total over all pages
              total = api
                  .column( 7 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  });

              var budget = <?=$project['BUDGET'];?>;
              totalBobot = (total/budget) * 100;
            } 
            
            // Update footer
            $( api.column( 7 ).footer() ).html(
                'Rp. '+ total
            );


            $( api.column( 6 ).footer() ).html(
                totalBobot.toPrecision(3)
            );
        }
    });
    //new $.fn.dataTable.FixedHeader( table );

    jQuery('#select-id-parent').select2();

    $('.add-data').click(function(){
      $('#form-add-item').trigger('reset');
      //$('#select-id-parent').select2('data', null);
    });
    // Submit add item
    $('#form-add-item').ajaxForm({
      clearForm: true,
      success: function(a,b,c,d){
        $('#modal-add-item').modal('hide');
        $('.modal-backdrop').hide();

        //reset status
        $("#is-edit").val('0');

        location.reload();
        //itemProject(<?=$id;?>);
      }
    });

    $('.edit-row').click(function(){
      var id = $(this).attr('object');
      //$("select #select-id-parent option[value='"+id+"']").attr('disabled',true);

      $.ajax({
        url: '<?php echo base_url();?>item_task/id/' + id,
        dataType: 'json'
      })
      .done(function(response, textStatus, jqhr){
        if(response.status == "ok"){
          $('#select-id-parent').val(response.data.ID_PARENT).trigger('change');
          $("#name").val(response.data.NAME);
          $("#specification").val(response.data.SPECIFICATION);
          $("#volume").val(response.data.VOLUME);
          $("#unit").val(response.data.UNIT);
          $("#unit_price").val(response.data.UNIT_PRICE);
          $("#id").val(response.data.ID);
          $("#is-edit").val('1');
        }
      })
      .fail(function(){

      });

      $('.modal-add-item').modal('show');
    });

    $('.delete-row').click(function(){
      var id = $(this).attr('object');
      
      if (confirm('Apakah anda yakin menghapus item ini ?')) { 
        $.ajax({
          url: '<?php echo base_url();?>item_task/remove/' + id,
          dataType: 'json'
        })
        .done(function(response, textStatus, jqhr){
          location.reload();
        })
        .fail(function(){

        });
      }
    });

    $('#form-import').ajaxForm({
      clearForm: true,
      dataType: 'json',
      success: function(a,b,c,d){
        if(a.status == 'ok'){
          $('#modal-import').modal('hide');
          $('.modal-backdrop').hide();

          jQuery.gritter.add({
            title: 'Info',
            text: a.message,
            class_name: 'growl-info',
            image: false,
            sticky: false,
            time: ''
          });
          setTimeout(function(){location.reload()}, 2000);
        } else {
          jQuery.gritter.add({
            title: 'Upss..',
            text: 'Terjadi Kesalahan',
            class_name: 'growl-danger',
            image: false,
            sticky: false,
            time: ''
          });

          $('#btn-process-import').html('Proses');
        }
      },
      error: function(e){
        jQuery.gritter.add({
          title: 'Upss..',
          text: 'Terjadi Kesalahan!<br/>Pastikan format file excel sudah benar.',
          class_name: 'growl-danger',
          image: false,
          sticky: false,
          time: ''
        });

        $('#btn-process-import').html('Proses');
      },
      uploadProgress: function(e,position,total,percentComplete){
        $('#btn-process-import').html('Sedang Memproses... ' + percentComplete + " %");
      }
    });

    $("input[name='unit_price'], .col-total").priceFormat({
      prefix: '',
      thousandsSeparator: '.',
      centsSeparator: ',',
      centsLimit: 0
    });
  });
</script>


