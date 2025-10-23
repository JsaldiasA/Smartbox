<?php
    require "../template/header.php";
?>


    <main class="container">
        <h1 class="text-center">Modificar Riego</h1>
        <a href="<?= BASE_URL ?>/views/riego" class="btn btn-outline-info"> Registro de Riego <i class="fa-regular fa-eye"></i></a>
        <br>
        <br>
        <form>
        <form id="frmIngreso">
            <div class="mb-3">
                <label for="txtSector" class="form-label">Sector</label>
                <input type="text" class="form-control" id="txtSector" placeholder="Nombre Sector" required>
            </div>
            <div class="mb-3">
                <label for="txtCuartel" class="form-label">Cuartel</label>
                <input type="text" class="form-control" id="txtCuartel" placeholder="Nombre Cuartel" required>
            </div>
            <div class="mb-3">
                <label for="dateFecha" class="form-label">Fecha riego</label>
                <input type="date" class="form-control" id="dateFecha" placeholder="dd-mm-aaaa" required>
            </div>
            <div class="mb-3">
                <label for="txtVolumen" class="form-label">Volumen (L)</label>
                <input type="number" class="form-control" id="txtVolumen" placeholder="Volumen en litros" required>
            </div>
            <div class="mb-3">
                <label for="txtTipo" class="form-label">Tipo</label>
                <input type="txt" class="form-control" id="txtTipo" placeholder="Programado/Ejecutado" required>
            </div>
            <div class="mb-3">
                <label for="dateMes" class="form-label">Mes</label>
                <input type="month" class="form-control" id="dateFecha" required>
            </div>
            <div class="mb-3">
                <label for="txtAno" class="form-label">Año</label>
                <input type="txt" class="form-control" id="txtAno" placeholder="2025" required>
            </div>
            
            <button type="submit" class="btn btn-info">Modificar <i class="fa-regular fa-pen-to-square"></i></button>
            </form>
        </form>
        <br>
        <br>       


    </main>
<?php
    require "../template/footer.php";
?>
