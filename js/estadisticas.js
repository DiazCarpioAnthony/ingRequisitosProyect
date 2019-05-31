var miData = new Array(listaMontos.length);

function cargarHighChart(){
    
    for (var i = 0; i < listaMontos.length; i++) {
        miData[i] = {
            name: listaTipos[i]+" - "+(listaMontos[i]).toFixed(2) + " "+ miTipoMoneda,
            y: listaMontos[i],
        }
    }

    Highcharts.chart('cont_graf_circ', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Resumen de los gastos'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },

        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: miData
        }]
        
    });
}

cargarHighChart();
