<?php
    require "../template/header.php";
?>


    <main class="container">
        <h1 class="text-center">Registro de Riego</h1>
        <a href="ingresar-riego.php" class="btn btn-outline-info">  Registrar Riego <i class="fa-regular fa-plus"></i></a>

        <table id="tbriego" class="table">
                <tr>
                    <th scope="row">#</th>
                    <td scope="col">Sector</td>
                    <td scope="col">Cuartel</td>
                    <td scope="col">Fecha</td>
                    <td scope="col">Volumen (L)</td>
                    <td scope="col">Tipo</td>
                    <td scope="col">Mes</td>
                    <td scope="col">Año</td>
                    <td scope="col">Opciones</td>
                </tr>
            </thead>
            <tbody id="tblBodyRiego">
                
            </tbody>
        </table>



    </main>
<?php
    require "../template/footer.php";
?>
<script src="../template/js/functions-riego.js"></script>
