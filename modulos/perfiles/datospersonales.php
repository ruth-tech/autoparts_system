<?php $personaid = $_GET['personaId'];?>
    
    <input type="hidden" id="persoid" personaid="<?php  echo $personaid; ?>">
    <div class="card-body-personales text-danger">
        <table class="table table-striped " id="listado-datosper">
            <thead >
                <tr>
                    <th>Apellido y Nombre</th>
                    <th>DNI</th>
                    <th>CUIL</th>
                    <th>Sexo</th>
                    <th>Fecha Nac.</th>
                    <th>Nacionalidad</th>
                    <th>Acciones</th>
                </tr>

            </thead>
            <tbody > <!-- id="listadodatosper"-->
            </tbody> 
        </table>

    </div>

     <!-- Modal EDITAR-->
     <div class="modal fade" id="editardatospersonales" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-dark">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editardatosper">
                            <strong><h3>Modificar datos personales </h3></strong>
                            
                                <input type="hidden" id="personaidedit" >
                                                            
                                <p>
                                <div class="form-group">
                                <label>Nombre:</label>
                                    <input type="text" id="nombreedit" >
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Apellido</label>
                                    <input type="text" id="apellidoedit">                   
                                </div>
                                </p>

                                <p>
                                <div class="form-group">
                                <label>DNI</label>
                                    <input type="text" id="dniedit">                       
                                </div>
                                </p>

                                <p>
                                <div class="form-group">
                                <label>CUIL</label>
                                    <input type="text" id="cuiledit">                       
                                </div>
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Fecha Nac.:</label>
                                    <input type="date" id="fechaedit">                       
                                </div>
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Nacionalidad</label>
                                    <input type="text" id="nacionalidadedit">                    
                                </div>
                                </p>
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal EDITAR -->

    <script src="perfil-personal.js"></script>
                
            
           