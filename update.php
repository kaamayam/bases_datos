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
        $sql = "UPDATE clientes (id, nombre, dir, tel, email, fecha_nac) VALUES (?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt,"issssss", $param_id, $param_nombre, $param_dir, $param_tel, $param_email, $param_fecha_nac);
            
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM clientes WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $param_id = $row["id"];
                    $param_nombre = $row["nombre"];
                    $param_dir = $row["dir"];
                    $param_tel = $row["tel"];
                    $param_email =$row["email"];
                    $param_fecha_nac = $row["fecha_nac"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>