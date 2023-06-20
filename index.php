<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/index.css">
    <title>EDN EDI</title>
</head>

<body>
    <?php require_once 'includes/header.php' ?>
    <div class="container content">
        <div class="card">
            <div class="card-header">
                EDN/EDI
            </div>
            <div class="card-body">
                <!--  <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                <form method="POST" action="genXML.php">
                    <div class="mb-3">

                        <!-- Annee -->

                        <label for="annee" class="form-label">Année :</label>
                        <select name="annee" class="form-select" id="">
                            <option selected disabled>Choisir l'année de votre DN</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                        </select>
                        </select>

                        <!-- Type période -->
                        <label for="typePeriode" class="form-label">Type de période :</label>
                        <select class="form-select" name="typePeriode" aria-label="Default select example">
                            <option selected disabled>Choisir le type de période</option>
                            <option value="ANNUELLE">Annuelle</option>
                            <option value="MENSUELLE">Mensuelle</option>
                            <option value="TRIMESTRIELLE">Trimestrielle</option>
                        </select>
                    </div>

                    <!-- Periode déclarée -->

                    <label for="periodeDeclaree" class="form-label">Période déclarée :</label>
                    <select name="numeroDeLaPeriode" class="form-select" aria-label="multiple select example">
                        <option selected disabled>Choisir la période déclarée</option>
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>
                        <option value="9">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>

                    <!--             <div class="d-flex flex-row">
                <label for="compteCotisant" class="form-label">N° Compte Cotisant :</label>
                <input type="text" class="form-control" id="compteCotisant">
                <p>/</p>
                <label for="suffixeCotisant" class="form-label">N° Suffixe Cotisant :</label>
                <input type="text" class="form-control" id="compteCotisant">
            </div> -->

                    <!-- Numero Compte Cotisant -->



                    <button type="submit" class="btn btn-primary mt-3">Suivant</button>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</body>