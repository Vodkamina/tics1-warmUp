
<?php
include_once "conexion.php";
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>

    <title>Simulador de costos de financiamiento</title>
</head>

<body>
    <header>
        <h2 class="text-center">Simulador de costos de financiamiento</h2>
    </header>
    <form id="formDatos" enctype="multipart/form-data">
        <div id="marginCenter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Ingreso de datos -->
                        <div class="form-group">
                            <label for="nombreProducto">Nombre producto</label>
                            <input type="text" class="form-control" id="nombreProducto" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="tienda">Tienda</label>
                            <input type="text" class="form-control" id="tienda" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="PrecioAlContado">Precio al contado</label>
                            <input type="number" class="form-control" id="PrecioAlContado" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="valorCuotaMensual">Valor cuota mensual</label>
                            <input type="number" class="form-control" id="valorCuotaMensual" step=".01" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="cuotas">N° de cuotas</label>
                            <input type="number" class="form-control" id="cuotas" placeholder="" required>
                        </div>
                        <center><button type="submit" id="btnCalcular" class="btn btn-primary">Calcular</button></center>
                        <!-- Resutados -->
                        <h3 class="text-center">Resultados</h3>
                        <ul class="list-group" id="resultados">
                            <li class="list-group-item">Costo total del credito: <span id="valor"></span></li>
                            <li class="list-group-item">CAE: <span id="cae"></span></li>
                        </ul>
                        <div id="resultadosbtns">
                            <center><button type="submit" id="btnLimpiar" class="btn btn-danger">Cancelar</button>
                                <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar en la base de datos</button>
                            </center>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="tabla">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Tabla -->
                        <div class="table-responsive">
                            <table id="tablaDatos" class="table table-striped table-hover table-light">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#id</th>
                                        <th scope="col">Nombre producto</th>
                                        <th scope="col">Tienda</th>
                                        <th scope="col">N° cuotas</th>
                                        <th scope="col">Cuota mensual</th>
                                        <th scope="col">Precio al contado</th>
                                        <th scope="col">Costo total</th>
                                        <th scope="col">CAE %</th>
                                        <th scope="col">Opción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $conexion = conect();
                                        $query = "SELECT * from tabla_datos";
                                        $result = mysqli_query($conexion,$query);
                                        foreach($result as $arr){
                                            
                                    ?>
                                    <tr>
                                        <td><?php echo $arr["id"]; ?></td>
                                        <td><?php echo $arr["nombreProducto"]; ?></td>
                                        <td><?php echo $arr["tienda"]; ?></td>
                                        <td><?php echo $arr["cuotas"]; ?></td>
                                        <td><?php echo $arr["valorCuotaMensual"]; ?></td>
                                        <td><?php echo $arr["PrecioAlContado"]; ?></td>
                                        <td><?php echo $arr["costoTotal"]; ?></td>
                                        <td><?php echo $arr["CAE"]; ?></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
    <!-- Datatables -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

    <script type="text/javascript" src="javascript.js"></script>
</body>

</html>