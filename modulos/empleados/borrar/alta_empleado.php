<?php

require ('../../php/conexion.php');

session_start();

// Si no existe la variable de sesión logueado, entonces el usuario debe loguearse.
if (!isset($_SESSION["logueado"])) {
  header("location: ../../index.php?error=debe_loguearse");
  exit;
}


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nuevo Empleado</title>
</head>
<body>
  <div align="center">


    <p>
      <a href="listado.php">Lista de Empleados</a> ||
      <a href="buscar_empleado.php">Buscar</a> 
    </p>
    <br>

    <form method="POST" action="procesamiento/procesar_alta.php">

      <h3>Ingrese los datos del nuevo Empleado</h3>
      <p>
        <label>Escriba su nombre: </label>
        <input type="text" name="nombre">
        </label>
      </p>
      <p>
        <label>Escriba su apellido </label>
        <input type="text" name="apellido" >
        </label>
      </p>
      <p>
        <label>Escriba su DNI:</label>
        <input type="text" name="dni" >
        </label>
      </p>
      <p>
        <label>Escriba su Cuil:</label>
        <input type="text" name="cuil" >
        </label>
      </p>
      
      <p>Genero:
      <label><input type="radio" name="sexo" value="femenino">Femenino </label>
      <label><input type="radio" name="sexo" value="masculino">Masculino </label>
      <label><input type="radio" name="sexo" value="otro">Otro </label><br>
      </p>
      
      
      <p>
        <label>Fecha de Nacimiento</label>
        <input type="date" name="fchNac" placeholder="
        AAAA/MM/DD">
        </label>
      </p>
      <p>
        <label>Nacionalidad</label>
        <input type="text" name="nacionalidad">
        </label>
      </p>
      <p>
        <label>Perfil de empleado</label>
        <select name="perfil">
        <option value="">--SELECCIONE--</option>
        <?php 
        $perfil = $conexion->query("SELECT * FROM perfiles") or die ("Error de SQL");
        while ($row = $perfil->fetch_assoc()) {
          echo '<option VALUE="'.$row['perfil_id'].'">'.$row['perfil_descripcion'].'</option>'  ;
        }

        ?>
      </select>
      </p>

      <p>
        <label>Ingrese un nombre de usuario</label>
        <input type="text" name="name_user">
        </label>
      </p>
      <p>
        <label>Ingrese una contraseña</label>
        <input type="text" name="password_user">
        </label>
      </p>


      <p>
        <button type="button" onclick="window.history.go(-1); return false;">Cancelar</button> &nbsp;
        <input type="submit" value="Guardar">
      </p>
    </form>
  </div>
</body>
</html>