<?php 



// session_start();

// // Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
// if (!isset($_SESSION["logueado"])) { 
//     header("location: ../../index.php?error=debe_loguearse");
//     exit;
// }
$personaid = $_GET['personaId'];

$sql = "SELECT * FROM tipo_contacto";

$rs_con = mysqli_query($conexion,$sql);

?>  
<head>
<script src="/autoparts_system/js/contactos.js"></script>

</head>

    

    
                <input type="hidden" id="persoid" personaid="<?php  echo $personaid; ?>">
                <div class="card-body-contactos">
                    <table class="table table-striped" id="listado-contactos">
                        <thead >
                            <tr>
                                <th>ID</th>
                                <th >Tipo Contacto</th>
                                <th>Valor</th>
                                <th>Acciones</th>
                            </tr>

                        </thead>
                        <tbody ><!-- id="listadoContacto" -->

                        </tbody>
                    </table>

                </div>

                 <!-- MODAL PERFIL -  AGREGAR CONTACTO--> 

                <div class="modal fade" id="agregarcontacto" tabindex="-1" role="dialog" aria-labelledby="agregarcontactotitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="agregarcontactotitle">Agregar Contacto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-dark">
                                <form method="POST" id="contacto-add" >
                                    <p>
                                        <div class="form-group">
                                            <input type="hidden" id="id" value="<?php  echo $personaid; ?>">
                                        </div>
                                    </p>
                                    <p>
                                        <div class="form-group">
                                            <label>Elegir un tipo de contacto:</label>
                                            <select id="tipocontacto"  > <!--onclick="selecttipocontacto()" -->
                                                <option value="" >--SELECCIONE--</option>
                                                <?php 
                                                    while ($row = $rs_con->fetch_assoc()) {
                                                    echo '<option VALUE="'.$row['tipo_contacto_id'].'">'.$row['tipo_contacto_descripcion'].'</option>' ;
                                                    };
                                                ?>
                                            </select>
                                            
                                        </div>
                                    </p>
                                    <p>
                                        <div class="form-group">
                                            <label>Valor:</label>
                                            <input type="text" id="valorcontacto">
                                         </div>   
                                    </p>
                                    <div class="modal-footer">
                                
                                        <button type="submit" class="btn btn-danger">Guardar</button>
                                    </div>

                                </form>
                            </div>
                           
                        </div>
                    </div>
                </div>
         

            

            <!-- Modal EDITAR-->
            <div class="modal fade" id="editarcontacto" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>

                        <div class="modal-body text-dark">
                            <form role="form" method="post" id="modificarcontacto">
                                <h3>Modificar datos de contacto </h3>
                                <input type="hidden" id="contactoidedit">
                                <p>
                                <div class="form-group">
                                    <label>Tipo de Contacto: </label>
                                        <select id="tipocontactoidedit">
                                            
                                        </select>
                                    
                                </div>
                                    
                                </p>
                                <p>
                                <div class="form-group">
                                <label>Valor</label>
                                    <input type="text" id="valoredit"  >
                                    </label>
                                    
                                </div>
                                    
                                </p>
                                
                                
                                <button type="submit" class="btn btn-danger">Actualizar</button>

                            </form>
                        </div>

                    </div> <!-- modal-content-->
                </div> <!--/.modal-dialog -->
            </div><!--/.modal EDITAR -->


    
    