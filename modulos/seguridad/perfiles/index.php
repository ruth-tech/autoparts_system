


                
             
                    <div class="btn-group fa-pull-right">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#add-perfil"><i class="fas fa-plus"></i>
                            Agregar perfil
                        </button>

                    </div>                  
               
                
               <div class="card-body">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Permisos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row= $perfil->fetch_assoc()):?>
                                <tr>
                                    <td><?php echo $row['id'];?></td>
                                    <td><?php echo $row['nombre'];?></td>
                                    <td><a class='btn btn-outline-danger' href='/autoparts_system/modulos/seguridad/usuarios/accesos_usuarios.php?perfil=<?php echo $row['id'];?>'>Ver</a></td>
                                    
                                </tr>
                            <?php endwhile; ?>
                            
                        </tbody>
                    </table>
               </div>




          