var ctx = document.getElementById("mychart3").getContext("2d");
var mychart = new Chart(ctx,{
    type:"doughnut",
    data:{
        labels:['Ventas','Compras', 'Creditos', 'Cta Cte'],
        datasets:[{
            label:'Estadisticas generales',
            data:[35,10,50,19],
            backgroundColor:[
                'rgb(66, 134, 244)',
                'rgb(74, 135, 72)',
                'rgb(135, 80, 255)',
                'rgb(229, 89, 50)'
            ]

        }]
    },
    options:{
        
        scales:{
            yAxes:[{
                ticks:{
                    beginAtZero:true
                }
            }]
        }
    }
})
