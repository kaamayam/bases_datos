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
                        <h2 class="pull-left">Datalles de clientes32343423</h2>
                        <a href="create.php" class="btn btn-success pull-right">Agregar nuevo cliente</a>
                    </div>


                     <!--esta conexion se hace con la base de datos para buscar por nombres o id-->
                     <?php
                        include_once 'config.php';
                        $sentencia_select=$link->prepare('SELECT * FROM ferreamayadb ORDER BY id DESC');
                        $sentencia_select->execute();
                        $resultado=$sentencia_select->fetchAll();

                        // metodo buscar
                        if(isset($_POST['btn_buscar'])){
                            $buscar_text=$_POST['buscar'];
                            $select_buscar=$link->prepare(
                                'SELECT * FROM ferreamayadb WHERE nombre LIKE :campo;'
                            );

                            $select_buscar->execute(array(
                                ':campo' =>"%".$buscar_text."%"
                            ));

                            $resultado=$select_buscar->fetchAll();
                        }
                    ?>

                    <!-- BUSCAR -->
                    <div>
                        <form action=""  method="post">
                        <input type="text" name="buscar" placeholder="buscar nombre"
                         value="<?php if(isset($buscar_text)) echo $buscar_text; ?>" >
                        <input type="submit" class="btn" name="btn_buscar" value="Buscar nuevo cliente">
                        </form>
                    </div>






                    <!-- Query Mostrar -->
                    <?php
                    // Include config file (para la conexion)
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM ferreamayadb";

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
                                        echo "<th>Fecah de Nacimiento</th>";
                                        echo "<th>Opciones</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";


                                 //<!-- buscar -->
                                foreach($resultado as $fila):?>
                                    <tr>
                                        <td><?php echo $fila['ID']; ?></td>
                                        <td><?php echo $fila['Nombre']; ?></td>
                                        <td><?php echo $fila['Apellido']; ?></td>
                                        <td><?php echo $fila['Correo']; ?></td>
                                        <td><?php echo $fila['FechaNac']; ?></td>
                                        <td><a href="update.php?id=<?php echo $fila[$id]; ?>" class="btn__update"> Editar cliente</a></td>
                                        <td><a href="delete.php?id=<?php echo $fila[$id]; ?>" class="btn__delete"> Eliminar cliente</a></td>
                                    </tr>

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
                                endforeach
                        
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
                        } else{
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