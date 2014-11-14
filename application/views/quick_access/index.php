<div class="row">
    <div class="col-md-12">
        <div class="panel-group" id="accordion2">
          <?php foreach ($projects as $project) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapse-<?=$project['ID'];?>">
                            <?=$project['NAME'];?>
                        </a>
                        <span class="pull-right">
                          Item Selesai Minggu ini : 2 / 5
                        </span>
                    </h4>
                </div>
                <div id="collapse-<?=$project['ID'];?>" class="panel-collapse collapse">
                    <div class="panel-body">
                      <!-- <div class="row row-stat">
                          <div class="col-md-4">
                              <div class="panel panel-default">
                                  <div class="panel-heading noborder">
                                      <div class="panel-btns">
                                          <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                                      </div>
                                      <div class="panel-icon"><i class="fa fa-calendar"></i></div>
                                      <div class="media-body">
                                          <h5 class="md-title nomargin">progress perencanaan</h5>
                                          <h1 class="mt5">52%</h1>
                                      </div>
                                      <hr>
                                      <div class="clearfix mt20">
                                          <div class="pull-left">
                                              <h5 class="md-title nomargin">Kemarin</h5>
                                              <h4 class="nomargin">0.025%</h4>
                                          </div>
                                          <div class="pull-right">
                                              <h5 class="md-title nomargin">Minggu ini</h5>
                                              <h4 class="nomargin">0.1%</h4>
                                          </div>
                                      </div>
                                      
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="panel panel-default">
                                  <div class="panel-heading noborder">
                                      <div class="panel-btns">
                                          <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                                      </div>
                                      <div class="panel-icon"><i class="fa fa-flag-checkered"></i></div>
                                      <div class="media-body">
                                          <h5 class="md-title nomargin">progress realisasi</h5>
                                          <h1 class="mt5">23%</h1>
                                      </div>
                                      <hr>
                                      <div class="clearfix mt20">
                                          <div class="pull-left">
                                              <h5 class="md-title nomargin">Yesterday</h5>
                                              <h4 class="nomargin">0%</h4>
                                          </div>
                                          <div class="pull-right">
                                              <h5 class="md-title nomargin">This Week</h5>
                                              <h4 class="nomargin">0%</h4>
                                          </div>
                                      </div>
                                      
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="panel panel-default">
                                  <div class="panel-heading noborder">
                                      <div class="panel-btns">
                                          <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                                      </div>
                                      <div class="panel-icon"><i class="fa fa-check-square-o"></i></div>
                                      <div class="media-body">
                                          <h5 class="md-title nomargin">Item Pekerjaan Selesai</h5>
                                          <h1 class="mt5">23</h1>
                                      </div>
                                      <hr>
                                      <div class="clearfix mt20">
                                          <div class="pull-left">
                                              <h5 class="md-title nomargin">Yesterday</h5>
                                              <h4 class="nomargin">20</h4>
                                          </div>
                                          <div class="pull-right">
                                              <h5 class="md-title nomargin">This Week</h5>
                                              <h4 class="nomargin">12</h4>
                                          </div>
                                      </div>
                                      
                                  </div>
                              </div>
                          </div>                       
                         
                      </div> 

                      <div class="mb20"></div> -->
                      <div class="pull-right">
                      Pilih Minggu  
                        <select class="select-week" >
                          <option>Minggu ke-1</option>
                        </select>
                      </div>

                      <div class="mb10" style="clear:both;"></div>
                      <table class="table table-bordered responsive table-hover tbl-item-list">
                        <thead>
                          <tr>
                            <th width="50px" rowspan="2" class="dt-cols-center">No</th>
                            <th rowspan="2">Uraian Pekerjaan</th>
                            <th rowspan="2" width="20px">Bobot Total</th>
                            <th colspan="3" class="dt-cols-center">Volume</th>
                            <th colspan="2" class="dt-cols-center">Bobot Minggu ini</th>
<!--                        <th rowspan="2" width="50px"></th> -->
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
                              if($item['ID_PROJECT'] == $project['ID']){
                                $bobot = round((($item['UNIT_PRICE'] * $item['VOLUME']) / $project['BUDGET'] ) * 100, 4);
                          ?>
                          <tr object="<?=$item['ID'];?>">
                            <td><?=$i;?></td>
                            <td><?=$item['NAME'];?></td>
                            <td class="dt-cols-right"><?=$bobot;?></td>
                            <td class="dt-cols-right"><?=round($item['VOLUME'], 4);?></td>
                            <td class="dt-cols-right"><?=round($item['SUPERVISOR_PROGRESS_VOLUME'], 4);?></td>
                            <td class="dt-cols-right"><?=round($item['VENDOR_PROGRESS_VOLUME'], 4);?></td>
                            <td class="dt-cols-right"><?=round($item['WEIGHT_PLANNING'], 4);?></td>
                            <td class="dt-cols-right"><?=round((($item['SUPERVISOR_PROGRESS_VOLUME'] / $item['VOLUME']) * $bobot), 4);?></td>
<!--                             <td class="dt-cols-center">
                              <a data-toggle="tooltip" title="Input Realisasi" class="tooltips input-realisasi" object="<?php echo $item['ID'];?> "><i class="fa fa-pencil"></i></a>
                              <a data-toggle="tooltip" title="Detail" class="tooltips detail-realisasi                                                                                                                                           " object="<?php echo $item['ID'];?>"><i class="fa fa-external-link"></i></a>
                            </td> -->
                          </tr>
                          <?php
                                $i++;
                              }
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div><!-- panel -->
          <?php } ?>
        </div><!-- panel-group -->
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
                  <form class="form-inline" id="form-add-project" method="POST" action="<?= base_url();?>project/add">

                    <div class="errorForm"></div>
                    <div class="form-group">
                        <label class="sr-only">Volume<span class="asterisk">*</span></label>
                        <input type="text" name="name" class="form-control" required title="Kolom Volume wajib diisi!" placeholder="Volume" />
                    </div><!-- form-group -->

                    <!-- Hidden Field -->
                    <input type="hidden" name="id" value="-1" />

                    <button class="btn btn-primary">Simpan</button>
                  </form>
                  <hr/>
                  <h5>Komentar</h5>
                  <hr/>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="pull-left">
                          <img class="img-circle img-online" src="<?=base_url();?>public/images/photos/profile.png" alt="...">
                      </div>
                    </div>
                    <div class="col-md-10">
                      <textarea rows="4" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="mb10"></div>
                  <div class="row">
                    <div class="col-md-2">    
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-4">
                      <button class="btn btn-primary pull-right" >Kirim</button>
                      <button class="btn btn-default pull-right mr5 tooltips" title="Sertakan Foto" data-toggle="tooltip"><i class="fa fa-camera"></i></button>

                    </div>
                  </div>
                </div><!-- panel-body -->
              </div><!-- panel-default -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    jQuery('.select-week').select2();

    jQuery('.tbl-item-list tbody').on( 'click', 'tr', function () {
      $('#modal-add-realisasi').modal('show');
    });

  });
</script>
