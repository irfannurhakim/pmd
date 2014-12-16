                <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                      <form class="form form-search" action="http://themepixels.com/demo/webpage/chain/search-results.html">
                        <input type="search" class="form-control" placeholder="Cari">
                      </form>
                  </div>
                  <div class="col-md-3"></div>
                </div>
                <div class="mb30"></div>
                <div class="" id="carousel-graph">
                    <?php foreach ($projects as $project) { ?>
                      <div class="col-md-12">
                          <div class="panel panel-default">
                              <div class="panel-body padding15">
                                  <div class="title-section">
                                    <h5 class="md-title mt0 mb10"><a href="<?=base_url();?>#/project/view/<?=$project['ID'];?>"><?= $project['NAME'];?></a></h5>
                                  </div>
                                  <div id="legend-curvas-<?=$project['ID'];?>" class="flotLegend"></div>
                                  <div id="curvas-<?=$project['ID'];?>" class="flotChart"></div>
                              </div><!-- panel-body -->
                              <div class="panel-footer">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div>
                                        <div id="gauge_<?=$project['ID'];?>"></div>
                                      </div><!-- tinystat -->
                                    </div><!-- col-md-7 -->
                                    <div class="col-md-6">
                                      <span class="sublabel">Rencana (<?=$project['TOTAL_PLANNING'];?> %)</span>
                                      <div class="progress progress-xs progress-metro">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?=$project['TOTAL_PLANNING'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$project['TOTAL_PLANNING'];?>%"></div>
                                      </div><!-- progress -->
                                      
                                      <span class="sublabel">Realisasi (<?=$project['TOTAL_PERCENTAGE'];?> %)</span>
                                      <div class="progress progress-xs progress-metro">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?=$project['TOTAL_PERCENTAGE'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$project['TOTAL_PERCENTAGE'];?>%"></div>
                                      </div><!-- progress -->
                                      
                                      <span class="sublabel">Sisa Waktu (<?=$project['REMAINING_DAYS'];?> %)</span>
                                      <div class="progress progress-xs progress-metro">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?=$project['REMAINING_DAYS'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$project['REMAINING_DAYS'];?>%"></div>
                                      </div><!-- progress -->
                                      
                                    </div><!-- col-md-5 -->
                                  </div><!-- row -->
                              </div><!-- panel-footer -->
                          </div><!-- panel -->
                      </div>             
                    <?php } ?>
                </div><!-- row -->
                <div class="mb20"></div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-right">
                            <a href="#" class="tooltips mr5" data-toggle="modal" title="Settings" id="btn-setting-sorting" data-target=".bs-example-modal"><span class="fa fa-cog"></span></a>
                          </div><!-- panel-btns -->
                          <h3 class="panel-title">Statistik Umum <span class="tahun-berjalan"><?=date('Y');?></span></h3>
                        </div>

                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-4">
                              <h5 class="md-title">Top 5 Kontraktor</h5>
                              <div class="list-group people-group" id="list-contractors">
                                      
                              </div><!-- list-group -->
                            </div>

                            <div class="col-md-4">
                              <h5 class="md-title">Top 5 Pengawas</h5>
                                <div class="list-group people-group" id="list-supervisors">
                                </div><!-- list-group -->
                            </div>

                            <div class="col-md-4">
                              <div class="panel panel-dark noborder">
                                <div class="panel-heading noborder">
                                  <div class="panel-btns">
                                    <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                                  </div><!-- panel-btns -->
                                  <div class="panel-icon"><i class="fa fa-shopping-cart"></i></div>
                                  <div class="media-body">
                                    <h5 class="md-title nomargin">Total Nilai Proyek Tahun <span class="tahun-berjalan"><?=date('Y');?></h5>
                                    <h1 class="mt5"><span id="total-nilai-proyek">0</span></h1>
                                  </div><!-- media-body -->
                                  <hr>
                                  <div class="panel-icon"><i class="fa fa-suitcase"></i></div>
                                  <div class="media-body">
                                    <h5 class="md-title nomargin">Jumlah Proyek <span class="tahun-berjalan"><?=date('Y');?></h5>
                                    <h1 class="mt5"><span id="total-jumlah-proyek">0</span></h1>
                                  </div><!-- media-body -->
                                  <div class="clearfix mt20">
                                    <div class="pull-left">
                                      <h5 class="md-title nomargin">Selesai</h5>
                                      <h4 class="nomargin"><span id="total-proyek-selesai">0</span></h4>
                                    </div>
                                    <div class="pull-right">
                                      <h5 class="md-title nomargin">Berlangsung</h5>
                                      <h4 class="nomargin"><span id="total-proyek-belangsung">0</span></h4>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="panel-icon"><i class="fa fa-users"></i></div>
                                  <div class="media-body">
                                    <h5 class="md-title nomargin">Jumlah Kontraktor</h5>
                                    <h1 class="mt5"><span id="total-jumlah-kontraktor">0</span></h1>
                                  </div><!-- media-body -->
                                  <hr/>
                                  <div class="panel-icon"><i class="fa fa-pencil-square-o"></i></div>
                                  <div class="media-body">
                                    <h5 class="md-title nomargin">Jumlah Pengawas</h5>
                                    <h1 class="mt5"><span id="total-jumlah-pengawas">0</span></h1>
                                  </div><!-- media-body -->
                              </div><!-- panel -->      
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> 
                </div><!-- row -->

<div class="modal fade bs-example-modal" tabindex="-1" role="dialog" id="modal-sorting-setting" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Atur Pengurutan</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form class="form-horizontal" id="form-sorting-setting" action="#">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="errorForm"></div>
             
                  <div class="form-group">
                      <label class="col-sm-6 control-label">Urutkan Kontraktor Berdasarkan</label>
                      <div class="col-sm-6">
                        <select id="select-sorting-kontraktor" data-placeholder="Pilih tipe user" class="col-sm-6" name="sort-kontraktor">
                            <option value="0">Nilai Proyek</option>
                            <option value="1">Jumlah Proyek</option>
                        </select>
                      </div>
                  </div><!-- form-group -->

<!--                   <div class="form-group">
                      <label class="col-sm-6 control-label">Urutkan Pengawas Berdasarkan</label>
                      <div class="col-sm-6">
                        <select id="select-sorting-pengawas" data-placeholder="Pilih tipe user"  class="col-sm-6" name="sort-pengawas">
                            <option value="1">Nilai Proyek</option>
                            <option value="1">Jumlah Proyek</option>
                        </select>
                      </div>
                  </div> -->

                  <div class="form-group">
                      <label class="col-sm-6 control-label">Berdasarkan Tahun</label>
                      <div class="col-sm-6">
                        <select id="select-sorting-year" data-placeholder="Pilih tipe user"  class="col-sm-6" name="sort-pengawas">
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                        </select>
                      </div>
                  </div><!-- form-group -->

                </div><!-- panel-body -->
                <div class="panel-footer">
                    <button class="btn btn-primary mr5" type="submit" id="btn-submit-setting">Submit</button>
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

<script src="<?= base_url();?>public/js/dashboard.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
    drawChart();

    jQuery('#select-sorting-pengawas, #select-sorting-kontraktor, #select-sorting-year').select2({
      minimumResultsForSearch: -1
    });

    loadTopStat(0, <?=date('Y');?>);

    $('#btn-submit-setting').click(function(){
      var sortType = $('#select-sorting-kontraktor').val();
      var year = $('#select-sorting-year').val();

      loadTopStat(sortType, year);

      $('#modal-sorting-setting').modal('hide');
      return false;
    });

    $('#carousel-graph').owlCarousel({
      items: 3,
      paginationNumbers: true
    });
  });

  function loadTopStat(sortType, year){
    $.ajax({
      url: '<?=base_url();?>home/topstat/' + sortType + '/' + year,
      dataType: 'json'
    })
    .done(function(res){
      if(res.status == 'ok'){
        var contractors = res.contractors;
        var supervisors = res.supervisors;
        var projects = res.project;
        var others = res.others;
        var a = '',
            b = '';
        for (var i = 0; i < contractors.length; i++) {
          a += '<a href="#" class="list-group-item">'
              + '<div class="media">'
              +    '<div class="pull-left">'
              +        '<img class="img-circle img-offline" src="<?=base_url();?>public/images/photos/profile.png" alt="...">'
              +    '</div>'
              +    '<div class="media-body">'
              +        '<h4 class="media-heading">'+ contractors[i]['NAME']+'</h4>'
              +        '<small>Rp. <span class="format-money">'+ contractors[i]['JML_NILAI_PROYEK']+'</span> ('+contractors[i]['JML_PROYEK']+' Proyek)</small>'
              +    '</div>'
            + '</div>'
          + '</a>';
        }

        for (var i = 0; i < supervisors.length; i++) {
          b += '<a href="#" class="list-group-item">'
              + '<div class="media">'
              +    '<div class="pull-left">'
              +        '<img class="img-circle img-offline" src="<?=base_url();?>public/images/photos/profile.png" alt="...">'
              +    '</div>'
              +    '<div class="media-body">'
              +        '<h4 class="media-heading">'+ supervisors[i]['NAME']+'</h4>'
              +        '<small>'+supervisors[i]['JML_PROYEK']+' Proyek</small>'
              +    '</div>'
            + '</div>'
          + '</a>';
        } 

        $('#list-contractors').html(a);
        $('#list-supervisors').html(b);
        $('.tahun-berjalan').text(year);
        $(".format-money").priceFormat({
          prefix: '',
          thousandsSeparator: '.',
          centsSeparator: ',',
          centsLimit: 0
        });
        $('#total-nilai-proyek').text(formatNumber(projects[0].SUM_TOTAL_BUDGET * 1));
        $('#total-jumlah-proyek').text(projects[0].COUNT_TOTAL_PROJECT);
        $('#total-proyek-belangsung').text(<?=count($projects);?>);
        $('#total-proyek-selesai').text(projects[0].COUNT_TOTAL_PROJECT - <?=count($projects);?> * 1);
        $('#total-jumlah-kontraktor').text(others[0].COUNT_CONTRACTOR);
        $('#total-jumlah-pengawas').text(others[0].COUNT_SUPERVISOR);
      }
    })
    .fail(function(){
    });
  }

  var ranges = [
    { divider: 1e15 , suffix: ' RT' },
    { divider: 1e12 , suffix: ' T' },
    { divider: 1e9 , suffix: ' M' }
  ];

  function formatNumber(n) {
    for (var i = 0; i < ranges.length; i++) {
      if (n >= ranges[i].divider) {
        return (n / ranges[i].divider).toFixed(3) + ranges[i].suffix;
      }
    }
    return n.toFixed(3);
  }

  function showTooltip(x, y, contents) {
   jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
     position: 'absolute',
     display: 'none',
     top: y + 5,
     left: x + 5
   }).appendTo("body").fadeIn(200);
  }

  function drawChart() {
    var options = {
      width: 400, height: 120,
      redFrom: 15, redTo: 100,
      yellowFrom:10, yellowTo: 15,
      minorTicks: 5
    };

    <?php foreach ($projects as $project) { ?>
     
    var data_<?=$project['ID'];?> = google.visualization.arrayToDataTable([
      ['Label', 'Value'],
      ['Deviasi', <?=$project['TOTAL_PLANNING'] - $project['TOTAL_PERCENTAGE'];?>]
    ]);

    var chart_<?=$project['ID'];?> = new google.visualization.Gauge(document.getElementById("gauge_<?=$project['ID'];?>"));

    chart_<?=$project['ID'];?>.draw(data_<?=$project['ID'];?>, options);
    
    var dataPlan_<?=$project['ID'];?> = <?=$project['PLAN'];?>;
    var dataReal_<?=$project['ID'];?> = <?=$project['REAL'];?>;

    var plot = jQuery.plot(jQuery("#curvas-<?=$project['ID'];?>"),
    [{
      data: dataPlan_<?=$project['ID'];?>,
      label: "Rencana",
      color: null,
    },
    {
      data: dataReal_<?=$project['ID'];?>,
      label: "Realisasi",
      color: null,
    }],
    {
      series: {
        lines: {
          show: true
        },
        splines: {
          show: true,
          tension: 0.1,
          lineWidth: 1,
          fill: 0.0
        },
        shadowSize: 0
      },
      points: {
        show: true,
      },
      legend: {
        container: "#legend-curvas-<?=$project['ID'];?>", 
        noColumns: 0
      },
      grid: {
        hoverable: true,
        clickable: true,
        borderColor: '#ddd',
        borderWidth: 0,
        labelMargin: 5,
        backgroundColor: '#fff'
      },
      yaxis: {
        min: 0,
        max: 100,
        color: '#eee'
      },
      xaxis: {
        color: '#eee',
        min: 0
      }
    });
    
    // var previousPoint = null;
    // jQuery("#curvas-<?=$project['ID'];?>").bind("plothover", function (event, pos, item) {
    //   jQuery("#x").text(pos.x.toFixed(2));
    //   jQuery("#y").text(pos.y.toFixed(2));
        
    //   if(item) {
    //     if (previousPoint != item.dataIndex) {
    //       previousPoint = item.dataIndex;
        
    //       jQuery("#tooltip").remove();
    //       var x = item.datapoint[0].toFixed(2),
    //       y = item.datapoint[1].toFixed(2);
              
    //       showTooltip(item.pageX, item.pageY,
    //       item.series.label + " of " + x + " = " + y);
    //     }
        
    //   } else {
    //     jQuery("#tooltip").remove();
    //     previousPoint = null;            
    //   }  
    
    // });
      
    // jQuery("#basicflot").bind("plotclick", function (event, pos, item) {
    //   if (item) {
    //     plot.highlight(item.series, item.datapoint);
    //   }
    // });    

    <?php } ?>


  }
</script>
