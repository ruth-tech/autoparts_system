<?php $personaid = $_GET['personaId'];?>


    

    
    <input type="hidden" id="persoid" personaid="<?php  echo $personaid; ?>">
    <div class="card-body-personales text-danger">
        <p>LISTADO DE Perfiles</p>
        <table class="table table-striped " id="listado-head">
            <thead >
                <tr>
                    <th >Descripcion</th>
                    
                </tr>

            </thead>
            <tbody id="listadoUsuarios">

            </tbody> 
        </table>

    </div>

     

    <script src="/autoparts_system/js/perfiles.js"></script>
                
            
           