<div class="row">
    <div class="col-md-12">
        <div class="panel-group" id="accordion2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2">
                            Project Satu
                        </a>
                        <span class="pull-right">
                          Item Selesai Minggu ini : 2 / 5
                        </span>
                    </h4>
                </div>
                <div id="collapseOne2" class="panel-collapse collapse in">
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
                        <select id="select-week" >
                          <option>Minggu ke-1</option>
                        </select>
                      </div>
                      <div class="mb10" style="clear:both;"></div>
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th width="50px" rowspan="2">No</th>
                            <th width="250px" rowspan="2">Uraian Pekerjaan</th>
                            <th rowspan="2">Spesifikasi</th>
                            <th colspan="2">Rencana</th>
                            <th colspan="2">Realisasi</th>
                          </tr>
                          <tr>
                            <th width="20px">Volume</th>
                            <th width="20px">Bobot</th>
                            <th width="20px">Volume</th>
                            <th width="20px">Bobot</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                </div>
            </div><!-- panel -->
        </div><!-- panel-group -->
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    jQuery('#select-week').select2();

  });
</script>
