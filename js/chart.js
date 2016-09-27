(function($) {

  cladeChart = function(config) {
    var chart = {
      chart: {
        type: 'column',
        backgroundColor: null,
        style: {
          fontFamily: 'Ubuntu, sans-serif'
        }
      },
      credits: {
        enabled: false
      },
      title: false,
      subtitle: false,
      legend: {
        enabled: false
      },
      xAxis: {
        type: 'category',
        labels: {
          style: {
            color: '#fff'
          }
        }
      },
      yAxis: {
        title: {
          text: config.title,
          style: {
            color: 'rgba(255,255,255,0.5)'
          }
        },
        labels: {
          style: {
            color: '#fff'
          }
        },
        min: 0,
        gridLineColor: 'rgba(0,0,0,0.1)'
      },
      plotOptions: {
        series: {
          borderWidth: 0,
          dataLabels: {
            enabled: true,
            color: '#fff',
            style: {
              textShadow: false
            }
          }
        }
      },
      tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b><br/>'
      },
      series: [{
        name: 'Año',
        color: config.color,
        // colorByPoint: true,
        groupPadding: 0
      }],
      exporting: {
        chartOptions: {
          title: {
            text: config.title
          },
          subtitle: {
            text: config.subtitle
          },
          yAxis: {
            title: false,
            labels: {
              style: {
                color: '#000'
              }
            }
          },
          xAxis: {
            labels: {
              style: {
                color: '#000'
              }
            }
          },
          plotOptions: {
            series: {
              dataLabels: {
                color: '#000'
              }
            }
          }
        }
      }
    };
    if(config.plotline) {
      // Plot line
      chart.yAxis.minRange = config.plotline;
      chart.yAxis.plotLines = [{
        value: config.plotline,
        color: config.color,
        dashStyle: 'shortdash',
        width: 3,
        label: {
          text: config.plotlineText,
          style: {
            color: '#fff',
            fontWeight: 500,
            textTransform: 'uppercase'
          }
        }
      }];
      // exporting plot line
      chart.exporting.chartOptions.yAxis.plotLines = [{
        value: config.plotline,
        color: config.color,
        dashStyle: 'shortdash',
        width: 3,
        label: {
          text: config.plotlineText,
          style: {
            color: '#000',
            fontWeight: 500,
            textTransform: 'uppercase'
          }
        }
      }];
    }
    // data
    chart.data = {
      csv: config.data
    };
    return $(config.element).highcharts(chart);
  };

})(jQuery);