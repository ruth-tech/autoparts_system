var ctx = document.getElementById("mychart2").getContext("2d");
var mychart = new Chart(ctx,{
    type:"line",
    data:{
        labels:['Formosa','Corrientes','Chaco','Interior Formosa'],
        datasets:[{
            label:'Estadisticas de ventas',
            data:[45,20,15, 30]
            // backgroundColor:[
            //     'rgb(66, 134, 244)',
            //     'rgb(74, 135, 72)',
            //     'rgb(135, 80, 255)',
            //     'rgb(229, 89, 50)'
            // ]

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
