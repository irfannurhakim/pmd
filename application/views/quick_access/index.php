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
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th width="50px" rowspan="2" class="dt-cols-center">No</th>
                            <th width="250px" rowspan="2">Uraian Pekerjaan</th>
                            <th rowspan="2">Spesifikasi</th>
                            <th colspan="2" class="dt-cols-center">Volume</th>
                            <th colspan="3" class="dt-cols-center">Bobot</th>
                          </tr>
                          <tr>
                            <th width="20px">Rencana</th>
                            <th width="20px">Realisasi</th>
                            <th width="20px">Total</th>
                            <th width="20px">Rencana</th>
                            <th width="20px">Realisasi</th>                        
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $i = 1;

                            foreach ($items as $item) {
                              if($item['ID_PROJECT'] == $project['ID']){
                                $bobot = round((($item['UNIT_PRICE'] * $item['VOLUME']) / $project['BUDGET'] ) * 100, 4);
                          ?>
                          <tr>
                            <td><?=$i;?></td>
                            <td><?=$item['NAME'];?></td>
                            <td><?=$item['SPECIFICATION'];?></td>
                            <td class="dt-cols-right"><?=round($item['VOLUME'], 4);?></td>
                            <td class="dt-cols-right"><?=round($item['SUPERVISOR_PROGRESS_VOLUME'], 4);?></td>
                            <td class="dt-cols-right"><?=$bobot;?></td>
                            <td class="dt-cols-right"><?=round($item['WEIGHT_PLANNING'], 4);?></td>
                            <td class="dt-cols-right"><?=round((($item['SUPERVISOR_PROGRESS_VOLUME'] / $item['VOLUME']) * $bobot), 4);?></td>
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

<script type="text/javascript">
  $(document).ready(function(){
    jQuery('.select-week').select2();
  });
</script>
