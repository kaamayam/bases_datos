<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>

<!-- *****************************************Cuerpo*********************************************** -->
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Header -->
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Datalles de Clientes</h2>
                        <a href="create.php" class="btn btn-success pull-right">Agregar nuevo cliente</a>
                    </div>


                    <form name="form" action="" method="post">
                        <input type="text" name="subject" placeholder="Nombre y enter" >
                        <a href="index.php" class="btn btn-success pull-right">Ver todo</a>
                    </form>

                  
                  
                    <!-- Query Mostrar -->
                    <?php

                  
                    include_once 'config.php';

                    if (!empty($_POST['subject'])){
                        $buscar = $_POST['subject'];
                    }else{
                        $buscar = "";
                    }


                    $sql = "SELECT * FROM clientes WHERE nombre LIKE '%$buscar%'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){

                            echo "<table class='table table-bordered table-striped'>";

                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Identificador</th>";
                                        echo "<th>Nombre</th>";
                                        echo "<th>Direccion</th>";
                                        echo "<th>Telefono</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Fecha de Nacimiento</th>";
                                        echo "<th>Opciones</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";


                                 //<!-- buscar -->
                        
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nombre'] . "</td>";
                                        echo "<td>" . $row['dir'] . "</td>";
                                        echo "<td>" . $row['tel'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['fecha_nac'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }

                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo "<p class='lead'><em>No records were found.</em></p>";



                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
                    // Close connection *****************
                    mysqli_close($link);
                    ?>

                    

                </div>
            </div>        
        </div>
    </div>
</body>
</html>