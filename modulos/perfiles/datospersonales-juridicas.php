<?php $personaid = $_GET['personaId'];?>
    
    <input type="hidden" id="persoid" personaid="<?php  echo $personaid; ?>">
    <div class="card-body-personales text-danger">
        <table class="table table-striped" id="listado-personajuridica">
            <thead >
                <tr>
                    <th>ID</th>
                    <th>Cuit</th>
                    <th>Razon Social</th>
                    <th>Habilitacion N°</th>
                    <th>Acciones</th>
                </tr>

            </thead>
            <tbody id="listadodatosper">
            </tbody>
        </table>

    </div>

    
     <!-- Modal EDITAR -->
     <div class="modal fade" id="editardatosperjuridicas" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-dark">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editardatosjuridicos">
                            <strong><h3>Modificar datos personales</h3></strong>
                            
                                <input type="hidden" id="personaidedit" >
                                                            
                                <p>
                                <div class="form-group">
                                <label>Cuit:</label>
                                    <input type="text" id="cuitedit" >
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Razon Social:</label>
                                    <input type="text" id="razonsocialedit">                   
                                </div>
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Nro Habilitacion</label>
                                    <input type="text" id="habilitacionedit">                       
                                </div>
                                </p>

                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal EDITAR -->

    <script src="perfil-juridico.js"></script>
                
            
           


    
    

