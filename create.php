<?php
// Iarchivo de configuracion o conexion
require_once "config.php";
 
// Inicializando variables
$id = $nombre = $dir = $tel = $email = $fecha_nac = "";
$id_err = $nombre_err = $dir_err = $tel_err = $email_err = $fecha_nac_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){  // Usamos metodo post para insertar en la base de datos

    // Identificardor **************
    // (Hay que verificar que este identificador no este antes de insertarlo, capturar el error del sql)
    $input_id = trim($_POST["id"]);
    if(empty($input_id)){
        $id_err = "Ingrese un id.";
    } elseif(!ctype_digit($input_id)){
        $id_err = "Por favor verifique su identificación";
    } else{
        $id = $input_id;
    }
    
    // nombre *****************************
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $nombre_err = "Por favor ingrese su nombre";     
    } else{
        $nombre = $input_nombre;
    }
    
    // dir ********************************
    $input_dir = trim($_POST["dir"]);
    if(empty($input_dir)){
        $dir_err = "Por favor ingrese su dirección";     
    } else{
        $dir = $input_dir;
    }
    
    // tel ***********
    $input_tel = trim($_POST["tel"]);
    if(empty($input_tel)){
        $tel_err = "Por favor ingrese su telefono ";     
    } else{
        $tel = $input_tel;
    }

    // email ***************
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Ingrese su email.";     
    } else{
        $email = $input_email;
    }

    // fecha_nac ******************
    $input_fecha_nac = trim($_POST["fecha_nac"]);
    if(empty($input_fecha_nac)){
        $fecha_nac_err = "Ingrese su fecha de nacimiento";     
    } else{
        $fecha_nac = $input_fecha_nac;
    }


    // Check input errors before inserting in database
    if(empty($nombre_err) && empty($dir_err) && empty($tel_err) && empty($email_err) &&  empty($fecha_nac_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO clientes (id, nombre, dir, tel, email, fecha_nac) VALUES (?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_id, $param_nombre, $param_dir, $param_tel, $param_email, $param_fecha_nac);
            
            // Set parameters
            $param_id = $id;
            $param_nombre = $nombre;
            $param_dir = $dir;
            $param_tel = $tel;
            $param_email = $email;
            $param_fecha_nac = $fecha_nac;


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Crear Cliente</h2>
                    </div>
                    <p>Por favor, diligencie la siguiente información.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                        <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                            <label>Identificacion</label>
                            <input type="text" name="id" class="form-control" value="<?php echo $id; ?>">
                            <span class="help-block"><?php echo $id_err;?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($dir_err)) ? 'has-error' : ''; ?>">
                            <label>Direccion</label>
                            <input type="text" name="dir" class="form-control" value="<?php echo $dir; ?>">
                            <span class="help-block"><?php echo $dir_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($tel_err)) ? 'has-error' : ''; ?>">
                            <label>Telefono</label>
                            <input type="text" name="tel" class="form-control" value="<?php echo $tel; ?>">
                            <span class="help-block"><?php echo $tel_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <textarea name="email" class="form-control"><?php echo $email; ?></textarea>
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($fecha_nac_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de nacimimiento</label>
                            <input type="text" name="fecha_nac" class="form-control" value="<?php echo $fecha_nac; ?>">
                            <span class="help-block"><?php echo $fecha_nac_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Guardar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>