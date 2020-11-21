<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_id = trim($_POST["id"]);
    if(empty($input_id)){
        $name_err = "Ingrese un id.";
    } elseif(!filter_var($input_id, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $id = $input_id;
    }
    
    // Validate address
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $address_err = "Please enter an address.";     
    } else{
        $nombre = $input_nombre;
    }
    
    // Validate salary
    $input_dir = trim($_POST["dir"]);
    if(empty($input_dir)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_dir)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $dir = $input_dir;
    }
    
    // Validate salary
    $input_tel = trim($_POST["tel"]);
    if(empty($input_tel)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_tel)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $tel = $input_tel;
    }

    // Validate salary
    $input_email = trim($_POST["email"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_email)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $email = $input_email;
    }


    // Validate salary
    $input_fecha_nac = trim($_POST["fecha_nac"]);
    if(empty($input_fecha_nac)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_fecha_nac)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $fecha_nac = $input_fecha_nac;
    }


    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO clientes (id, nombre, dir, tel, email, fecha_nac) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_nombre, $param_dir, $param_tel, $param_email, $param_fecha_nac);
            
            // Set parameters
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $dir; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $tel; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $email; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $fecha_nac; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
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