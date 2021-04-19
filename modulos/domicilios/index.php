<?php 

// require '../../php/conexion.php';

$personaid = $_GET['personaId'];

$sql = "SELECT * FROM tipo_domicilios";

$rs_dom = mysqli_query($conexion,$sql);

$sql = "SELECT * FROM paises";

$rs_paises=mysqli_query($conexion,$sql);


?> 

<head>
<script src="/autoparts_system/js/domicilios.js"></script>
</head>
    

    
                <input type="hidden" id="personaid" personaid="<?php  echo $personaid; ?>">
                <div class="card-body-domicilios text-danger">
                    <table class="table table-striped" id="listado-domicilio">
                        <thead>
                            <tr>
                                <th >Tipo Domicilio</th>
                                <th>Barrio</th>
                                <th>Calle</th>
                                <th>Altura</th>
                                <th>Torre</th>
                                <th>Piso</th>
                                <th>Manzana</th>
                                <th>Sector</th>
                                <th>Parcela</th>
                                <th>Acciones</th>
                            </tr>
                        </thead> 
                        <tbody id="listadodomicilio" >            
                        </tbody>
                                                
                    </table>

                </div>
            
            <!-- Modal AGREGAR -->
        <div class="modal fade" id="agregardomicilio" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-dark">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            
                            <form role="form" method="post" id="agregardomi">
                                <h3>Ingrese los datos del domicilio</h3>
                                <p>
                                <div class="form-group">
                                    <input type="hidden" id="idpersona" value="<?php  echo $personaid; ?>">
                                </div>
                                </p>

                                <p>
                                <div class="form-group">
                                    <label>Tipo de domicilio: </label>
                                    <select id="tipodomicilio"  > 
                                        <option value="" >--SELECCIONE--</option>
                                        <?php 
                                            while ($row = $rs_dom->fetch_assoc()) {
                                            echo '<option VALUE="'.$row['tipo_domicilio_id'].'">'.$row['tipo_domicilio_descripcion'].'</option>' ;
                                            };
                                        ?>
                                    </select>
                                    
                                </div>                                    
                                </p>  

                                <p>
                                <div class="form-group">
                                    <label>Pais:
                                    <select name="paises" id="paises" class="form-control col-10">
                                    <option value="" >--SELECCIONE--</option>
                                        <?php 
                                            while ($row = $rs_paises->fetch_assoc()) {
                                            echo '<option VALUE="'.$row['id'].'">'.$row['pais'].'</option>' ;
                                            };
                                        ?>
                                    </select>
                                    </label>

                                    <label>Provincia:
                                    <select name="provincias" id="provincias" class="form-control col-10">
                                    <option value="" >--SELECCIONE--</option>
                                    </select>
                                    </label>

                                    <label>Localidad:
                                    <select name="localidades" id="localidades" class="form-control col-10">
                                    <option value="" >--SELECCIONE--</option>
                                    </select>
                                    </label>
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Barrio:</label>
                                    <input type="text" id="barrio" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Calle:</label>
                                    <input type="text" id="calle" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                
                                <p>
                                <div class="form-group">
                                <label>Altura:</label>
                                <input type="text" id="altura">
                                    
                                </div>                            
                                </p>
                                
                                
                                <p>
                                <div class="form-group">
                                <label>Torre:</label>
                                    <input type="text" id="torre" >
                                    </label>
                                    
                                </div>
                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Piso</label>
                                    <input type="text" id="piso" >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Manzana:</label>
                                    <input type="text" id="manzana" >
                                    </label>
                                </div>                                
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Sector:</label>
                                    <input type="text" id="sector" >
                                    </label>
                                </div>                                
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Parcela:</label>
                                    <input type="text" id="parcela" >
                                    </label>
                                </div>                                
                                </p>
                                
                                <button type="submit" class="btn btn-danger">Agregar</button>

                            </form>
                        </div>

                    </div><!--/.modal-content -->
                </div> <!--/.modal-dialog -->
            </div><!--/.modal AGREGAR-->

            

            <!-- Modal EDITAR -->
            <div class="modal fade" id="editardomicilio" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-dark">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form role="form" method="post" id="editardomi">
                                <h3>Modificar datos del domicilio </h3>
                               
                                <input type="hidden" id="id_domi" >
                                <p>
                                <div class="form-group">
                                    <label>Tipo domicilio: </label>
                                    <select id="tipo_domi" ></select>        
                                </div>                                   
                                </p>

                                <p>
                                <div class="form-group">
                                    <label>Localidad: </label>
                                    <select id="localidad_domi" ></select>        
                                </div>                                   
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Barrio: </label>
                                    <input type="text" id="barrio_domi"  >
                                    
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Calle:</label>
                                    <input type="text" id="calle_domi" >
                                    
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                    <label>Altura:</label>
                                    <input type="text" id="altura_domi" >
                                    </label>
                                    
                                </div>
                                    
                                </p>                        
                                
                                <p>
                                <div class="form-group">
                                <label>Torre:</label>
                                    <input type="text" id="torre_domi"  >
                                    
                                </div>
                                    
                                </p>

                                <p>
                                <div class="form-group">
                                <label>Piso:</label>
                                    <input type="text" id="piso_domi" >
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Manzana:</label>
                                    <input type="text" id="manzana_domi" >
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Sector:</label>
                                    <input type="text" id="sector_domi" >
                                    
                                </div>
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Parcela:</label>
                                    <input type="text" id="parcela_domi" >
                                    
                                </div>
                                </p>
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div> <!--/.modal-content-->
                </div> <!--/.modal-dialog -->
            </div><!--/.modal EDITAR -->
 
   
    
