

<div class="card-body text-danger">
<table class="table table-striped table-responsive" id="lista-pedidos-pendientes">
    <thead class="thead-dark">
        <tr>
            <th >ID</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Vendedor</th>           
            <th>Total</th>
            <th>Estado</th>
            <th>Detalles</th>
            <th>Acciones</th>
        </tr>

    </thead>
    <tbody>
    
    
    </tbody>
</table>

</div>

<!-- <script>
    $(document).ready(function(){
        listarpendientes();
    })
    

    var listarpendientes = function(){
    var tableP = $('#lista-pedidos-pendientes').dataTable({
        "ajax":{
            "method":"POST",
            "url":"/autoparts_system/modulos/pedidos/pendientes/listaPendientes.php"
        },
        "columns":[
            {"datos":"pedido_id"},
            {"datos":"pedido_fecha"},
            {"datos":"nombreCliente"},
            {"datos":"nombreEmpleado"},
            {"datos":"pedido_total"},
            {"datos":"pedido_estado_descripcion",
                render: function(data, type, row){
                    console.log('El contenido de datos es : '+data);
                    sev='';
                    switch (data){
                    case 'PENDIENTE':
                        sev = '<span class="badge badge-warning badge-pill">'+data+'</span>';
                        break;
                    
                    }
                    // console.log('Content of sev is : '+sev);
                    return sev;
                }
            },
            {"datos":"pedido_id",
                "fnCreatedCell": function(nTd, sData, oData, iRow, iCol){
                    $(nTd).html("<a href='autoparts_system/modulos/pedidos/individuales/index.php?pedidoid="+oData.pedido_id+"'>Ver</a>")
                }
            },
            {"defaultContent":"<button class='btn btn-warning'><i class='far fa-edit'></i></button> <button class='btn btn-danger'><i class='far fa-trash-alt'></i></button>"}
        ],
        "language":idioma_espaniol
    });
}
</script> -->