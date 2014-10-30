<div>
  <button class="btn btn-primary add-data" data-toggle="modal" data-target=".bs-example-modal"><i class="fa fa-plus"></i> Buat Proyek</button>
</div>

<!---
//list of projects -->
<table id="table-list-projects" class="table table-bordered responsive table-hover">
  <thead class="">
    <tr>
      <th>Nama Proyek</th>
      <th>Kontraktor</th>
      <th width="60px" class="dt-cols-center">Sisa Waktu</th>
      <th width="60px" class="dt-cols-center">Selesai (%)</th>
      <th width="60px" class="dt-cols-center">Deviasi (%)</th>
      <!-- <th></th> -->
    </tr>
  </thead>

  <tbody class="selectable">
    <?php foreach ($projects as $row) { ?>
    <tr object="<?php echo $row['ID'];?>">
        <td><?php echo $row['NAME'];?></td>
        <td><?php echo $row['VENDOR_NAME'];?></td>
        <td class="dt-cols-right"><?php echo ($row['DUE'] > 0) ? ceil($row['DUE']/7) : floor($row['DUE']/7);?> Minggu</td>
        <td class="dt-cols-right"><?php echo $row['PROGRESS'];?> %</td>
        <td class="dt-cols-right"><?php echo $row['DEVIATION'];?> %</td>
<!--         <td class="dt-cols-center">
          <a data-toggle="tooltip" title="Edit" class="tooltips edit-row" object="<?php echo $row['ID'];?> "><i class="fa fa-pencil"></i></a>
          <a data-toggle="tooltip" title="Hapus" class="tooltips delete-row" object="<?php echo $row['ID'];?>"><i class="fa fa-trash-o"></i></a>
        </td> -->
    </tr>
    <?php } ?>
  </tbody>
</table>

<div class="modal fade bs-example-modal" tabindex="-1" role="dialog" id="modal-add-project" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Buat Proyek Baru</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" id="form-add-project" method="POST" action="<?= base_url();?>project/add">
              <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
                        <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                    </div><!-- panel-btns -->
                    <p>( <span class="asterisk">*</span> ) Menandakan wajib diisi.</p>
                </div>
                <div class="panel-body">
                  <div class="errorForm"></div>
                  <div class="form-group">
                      <label class="col-sm-4 control-label">Judul Proyek<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <input type="text" name="name" class="form-control" required title="Kolom Judul Proyek wajib diisi!" />
                      </div>
                  </div><!-- form-group -->
              
                 <!--  <div class="form-group">
                      <label class="col-sm-4 control-label">Deskripsi<span class="asterisk">*</span></label>
                      <div class="col-sm-8">
                          <textarea name="description" class="form-control" />
                      </div>
                  </div> --><!-- form-group -->

                  <div class="form-group">
                      <label class="col-sm-4 control-label">Kontraktor<span class="asterisk">*</span></label>
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
                      <label class="col-sm-4 control-label">Pengawas<span class="asterisk">*</span></label>
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
                      <label class="col-sm-4 control-label">Tanggal Mulai<span class="asterisk">*</span></label>
                      <div class="col-sm-3">
                          <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="start-date" name="start-date" value="<?= date('d/m/Y');?>"/>
                      </div>
                      <label class="col-sm-2 control-label" >Tgl Selesai</label>
                      <div class="col-sm-3">
                          <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="end-date" name="end-date" value="<?= date('d/m/Y');?>"/>
                      </div>
                  </div><!-- form-group -->

<!--                   <div class="form-group">
                      <label class="col-sm-4 control-label">Durasi<span class="asterisk">*</span></label>
                      <div class="col-sm-2">
                          <input type="text" name="duration" class="form-control" required title="Kolom Durasi wajib diisi!" value="0" />
                      </div>
                      <label class="col-sm-5 control-label" style="text-align:left;">Minggu</label>
                  </div> --><!-- form-group -->


                  <div class="form-group">
                      <label class="col-sm-4 control-label">Nilai Proyek<span class="asterisk">*</span></label>
                      <div class="col-sm-5">
                          <input type="text" name="project-budget" class="form-control" required title="Kolom Nilai Proyek wajib diisi!" value="0" />
                      </div>
                  </div><!-- form-group -->


                 
                  <!-- Hidden Field -->
                  <input type="hidden" name="id" value="-1" />
                  <input type="hidden" name="is-edit" value="0" />
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

<script type="text/javascript">
  $(document).ready(function(){

    jQuery('#table-list-projects').DataTable({
      "responsive": true
    });

    jQuery('#table-list-projects tbody').on( 'click', 'tr', function () {
      var id = $(this).attr('object');
      window.location = "<?=base_url();?>#/project/view/" + id;
    });
 

    jQuery('#select-id-contractor, #select-id-supervisor').select2();
    
    jQuery('#start-date').datepicker({dateFormat : "dd/mm/yy"});
    jQuery('#end-date').datepicker({dateFormat : "dd/mm/yy"});

    // Submit add project
    $('#form-add-project').ajaxForm({
      success: function(a,b,c,d){
        $('#modal-add-project').modal('hide');
        $('.modal-backdrop').hide();
        projects();
      }
    });

    $("input[name='project-budget']").priceFormat({
      prefix: '',
      thousandsSeparator: '.',
      centsSeparator: ',',
      centsLimit: 0
    })

  });

</script>


