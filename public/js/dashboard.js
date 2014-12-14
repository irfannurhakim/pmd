// jQuery(document).ready(function(){
    
//   "use strict";

//   function showTooltip(x, y, contents) {
//   	jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
// 	    position: 'absolute',
// 	    display: 'none',
// 	    top: y + 5,
// 	    left: x + 5
//   	}).appendTo("body").fadeIn(200);
//   }
    
//   /*****SIMPLE CHART*****/
  
//   var newCust = [[0, 0], [1, 2], [2,3], [3, 12], [4, 25], [5, 50], [6, 70], [7, 90], [8, 95], [9, 98], [10, 100]];
//   var retCust = [[0, 0], [1, 1], [2,4], [3, 10], [4, 20], [5, 45], [6, 55]];
	
//   var plot = jQuery.plot(jQuery("#basicflot"),
// 	[{
//     data: newCust,
//     label: "Rencana",
//     color: null,
//   },
//         {
// 	    data: retCust,
// 	    label: "Realisasi",
// 	    color: null,
//         }
// 	],
// 	{
// 	    series: {
// 		lines: {
// 		    show: true
// 		},
// 		splines: {
// 		    show: true,
// 		    tension: 0.1,
// 		    lineWidth: 1,
// 		    fill: 0.0
// 		},
// 		shadowSize: 0
// 	    },
// 	    points: {
// 		show: true,
// 	    },
// 	    legend: {
// 		container: '#basicFlotLegend',
//                 noColumns: 0
// 	    },
// 	    grid: {
// 		hoverable: true,
// 		clickable: true,
// 		borderColor: '#ddd',
// 		borderWidth: 0,
// 		labelMargin: 5,
// 		backgroundColor: '#fff'
// 	    },
// 	    yaxis: {
// 		min: 0,
// 		max: 100,
// 		color: '#eee'
// 	    },
// 	    xaxis: {
// 		color: '#eee'
// 	    }
// 	});
		
// 	var previousPoint = null;
// 	jQuery("#basicflot").bind("plothover", function (event, pos, item) {
// 	jQuery("#x").text(pos.x.toFixed(2));
// 	jQuery("#y").text(pos.y.toFixed(2));
			
// 	if(item) {
// 	    if (previousPoint != item.dataIndex) {
// 		previousPoint = item.dataIndex;
						
// 		jQuery("#tooltip").remove();
// 		var x = item.datapoint[0].toFixed(2),
// 		y = item.datapoint[1].toFixed(2);
	 			
// 		showTooltip(item.pageX, item.pageY,
// 		item.series.label + " of " + x + " = " + y);
// 	    }
			
// 	} else {
// 	    jQuery("#tooltip").remove();
// 	    previousPoint = null;            
// 	}
		
//     });
		
//     jQuery("#basicflot").bind("plotclick", function (event, pos, item) {
// 	if (item) {
// 	    plot.highlight(item.series, item.datapoint);
// 	}
//     });
    
    
//     /*****CHART 2 *****/
    
//     var visitors = [[0, 0], [1, 2], [2,3], [3, 12], [4, 25], [5, 50], [6, 70], [7, 90], [8, 95], [9, 98], [10, 100]];
//     var unique = [[0, 0], [1, 1], [2,4], [3, 10], [4, 20], [5, 45], [6, 55], [7, 90], [8, 95], [9, 98]];
	
//     var plot = jQuery.plot(jQuery("#basicflot2"),
// 	[{
// 	    data: visitors,
// 	    label: "Rencana",
// 	},
//         {
// 	    data: unique,
// 	    label: "Realisasi",
//         }
// 	],
// 	{
// 	    series: {
// 		lines: {
// 		    show: true
// 		},
// 		splines: {
// 		    show: true,
// 		    tension: 0.1,
// 		    lineWidth: 1,
// 		    fill: 0.0
// 		},
// 		shadowSize: 0
// 	    },
// 	    points: {
// 		show: true
// 	    },
// 	    legend: {
// 		container: '#basicFlotLegend2',
//                 noColumns: 0
// 	    },
// 	    grid: {
// 		hoverable: true,
// 		clickable: true,
// 		borderColor: '#ddd',
// 		borderWidth: 0,
// 		labelMargin: 5,
// 		backgroundColor: '#fff'
// 	    },
// 	    yaxis: {
// 		min: 0,
// 		max: 100,
// 		color: '#eee'
// 	    },
// 	    xaxis: {
// 		color: '#eee'
// 	    }
// 	});
		
// 	var previousPoint = null;
// 	jQuery("#basicflot2").bind("plothover", function (event, pos, item) {
// 	jQuery("#x").text(pos.x.toFixed(2));
// 	jQuery("#y").text(pos.y.toFixed(2));
			
// 	if(item) {
// 	    if (previousPoint != item.dataIndex) {
// 		previousPoint = item.dataIndex;
						
// 		jQuery("#tooltip").remove();
// 		var x = item.datapoint[0].toFixed(2),
// 		y = item.datapoint[1].toFixed(2);
	 			
// 		showTooltip(item.pageX, item.pageY,
// 		item.series.label + " of " + x + " = " + y);
// 	    }
			
// 	} else {
// 	    jQuery("#tooltip").remove();
// 	    previousPoint = null;            
// 	}
		
//     });
		
//     jQuery("#basicflot2").bind("plotclick", function (event, pos, item) {
// 	if (item) {
// 	    plot.highlight(item.series, item.datapoint);
// 	}
//     });
    
    
//     /*****CHART 3 *****/
    
//     var impressions = [[0, 0], [1, 2], [2,3], [3, 12], [4, 25], [5, 50], [6, 70], [7, 90], [8, 95], [9, 98], [10, 100]];
//     var uniqueimpressions = [[0, 0], [1, 1], [2,4], [3, 10]];
	
//     var plot = jQuery.plot(jQuery("#basicflot3"),
// 	[{
// 	    data: impressions,
// 	    label: "Rencana",
// 	},
//         {
// 	    data: uniqueimpressions,
// 	    label: "Realisasi",
//         }
// 	],
// 	{
// 	    series: {
// 		lines: {
// 		    show: true
// 		},
// 		splines: {
// 		    show: true,
// 		    tension: 0.1,
// 		    lineWidth: 1,
// 		    fill: 0.0
// 		},
// 		shadowSize: 0
// 	    },
// 	    points: {
// 		show: true
// 	    },
// 	    legend: {
// 		container: '#basicFlotLegend3',
//                 noColumns: 0
// 	    },
// 	    grid: {
// 		hoverable: true,
// 		clickable: true,
// 		borderColor: '#ddd',
// 		borderWidth: 0,
// 		labelMargin: 5,
// 		backgroundColor: '#fff'
// 	    },
// 	    yaxis: {
// 		min: 0,
// 		max: 100,
// 		color: '#eee'
// 	    },
// 	    xaxis: {
// 		color: '#eee'
// 	    }
// 	});
		
// 	var previousPoint = null;
// 	jQuery("#basicflot3").bind("plothover", function (event, pos, item) {
// 	jQuery("#x").text(pos.x.toFixed(2));
// 	jQuery("#y").text(pos.y.toFixed(2));
			
// 	if(item) {
// 	    if (previousPoint != item.dataIndex) {
// 		previousPoint = item.dataIndex;
						
// 		jQuery("#tooltip").remove();
// 		var x = item.datapoint[0].toFixed(2),
// 		y = item.datapoint[1].toFixed(2);
	 			
// 		showTooltip(item.pageX, item.pageY,
// 		item.series.label + " of " + x + " = " + y);
// 	    }
			
// 	} else {
// 	    jQuery("#tooltip").remove();
// 	    previousPoint = null;            
// 	}
		
//     });
		
//     jQuery("#basicflot3").bind("plotclick", function (event, pos, item) {
// 	if (item) {
// 	    plot.highlight(item.series, item.datapoint);
// 	}
//     });
    
// });