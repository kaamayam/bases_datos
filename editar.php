<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$id = $nombre = $dir = $tel = $email = $fecha_nac = "";
$id_err = $nombre_err = $dir_err = $tel_err = $email_err = $fecha_nac_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

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
            mysqli_stmt_bind_param($stmt, $param_id, $param_nombre, $param_dir, $param_tel, $param_email, $param_fecha_nac);
            
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
    <title>Update Record</title>
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
                        <h2>Actualizar registros</h2>
                    </div>
                    <p>Por favor edite y suba los cambios</p>
                    <form action="<?php echo htmlspecialchars(basenombre($_SERVER['REQUEST_URI'])); ?>" method="post">
                         <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>id</label>
                            <input type="text" nombre="id" class="form-control" value="<?php echo $id; ?>">
                            <span class="help-block"><?php echo $id_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>nombre</label>
                            <input type="text" nombre="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($dir_err)) ? 'has-error' : ''; ?>">
                            <label>dir</label>
                            <textarea nombre="dir" class="form-control"><?php echo $dir; ?></textarea>
                            <span class="help-block"><?php echo $dir_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>email</label>
                            <input type="text" nombre="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tel_err)) ? 'has-error' : ''; ?>">
                            <label>Tel</label>
                            <textarea nombre="tel" class="form-control"><?php echo $tel; ?></textarea>
                            <span class="help-block"><?php echo $tel_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fecha_nac_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha</label>
                            <textarea nombre="fecha_nac" class="form-control"><?php echo $fecha_nac; ?></textarea>
                            <span class="help-block"><?php echo $fecha_nac_err;?></span>
                        </div>

                        <input type="hidden" nombre="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>