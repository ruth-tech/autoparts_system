<?php

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'debe_loguearse':
            $mensaje = 'Debe iniciar sesión.';
            break;

        case 'login_error':
            $mensaje = 'Usuario o Password incorrecto.';
            break;
        
        /*case 'usuario_inactivo':
            $mensaje = 'Usuario inactivo. Consulte con el administrador.';
            break;*/
    }
}

?>

<html>
<head>

    <title>Login de usuario</title>
    

    <?php require 'php/head_link.php';?>


    <!-- Nuestro CSS -->
    <link rel="stylesheet" href="css/login-style.css">
    

    <title>Login de usuario</title>

    <?php require 'php/head_script.php';?>
    <script src="js\login.js"></script>

   
</head>

<body>
       <div class="alert alert-danger" style="display: none;"> 
           <?php if (isset($mensaje)): ?>
    		<?php echo '<script> alerta("'.$mensaje.'") </script>' ?>
            <?php endif; ?>
        </div>
    <div class="container">
        <div class="row">
			<div class="col-md-5 mx-auto">
                <div id="first">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <img src="img\Logo.png" alt="img-user" width="300px" height="110px">
                            </div>
                        </div>
                        <form action="php/procesar_index.php" method="post" id="form" name="login"> 

                            <div class="form-group">

                                <label for="exampleInputEmail1">Email o Usuario</label>
                                <input type="text" name="txtUsuario"  class="form-control" id="txtUsuario" >
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" name="txtPassword" id="txtPassword"  class="form-control" >
                            </div>
                            <div class="form-group">
                                <p class="text-center">Al ingresar aceptas nuestros <a href="#">Terminos y condiciones.</a></p>
                            </div>
                            <div class="col-md-12 text-center ">
                                <button id="ingresar" type="submit" class=" btn btn-block mybtn btn-danger tx-tfm">Ingresar</button>
                            </div>
                            
                        </form>
                    
                    </div>
                </div>
                <div id="second">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1 >Registrarme</h1>
                            </div>
                        </div>
                        <form action="#" name="registration">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombres</label>
                                <input type="text"  name="firstname" class="form-control" id="firstname" aria-describedby="emailHelp" placeholder="Enter Firstname">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Apellidos</label>
                                <input type="text"  name="lastname" class="form-control" id="lastname" aria-describedby="emailHelp" placeholder="Enter Lastname">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email o nombre de usuario</label>
                                <input type="email" name="email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Contraseña</label>
                                <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                            </div>
                            <div class="col-md-12 text-center mb-3">
                                <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Registrarme gratis</button>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <p class="text-center"><a href="#" id="signin">¿Ya tienes una cuenta?</a></p>
                                </div>
                            </div>
                                    
                        </form>
                    </div>
                </div>  
            </div>
		</div>
    </div>   
         

     

    
       




    
</body>
</html>