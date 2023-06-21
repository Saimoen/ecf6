<?php 

$selectedTypePeriode = $_POST['typePeriode'];
$selectedAnnee = $_POST['annee'];
$selectedNumero = $_POST['numeroDeLaPeriode'];

?>

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
                        <select name="annee" class="form-select" required>
                            <option selected disabled value="vide">Choisir l'année de votre DN</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                        </select>
                        </select>

                        <!-- Type période -->
                        <label for="typePeriode" class="form-label" required>Type de période :</label>
                        <select class="form-select" name="typePeriode" id="typePeriode" aria-label="Default select example">
                            <option selected disabled value="vide">Choisir le type de période</option>
                            <option value="ANNUEL">Annuel</option>
                            <option value="MENSUEL">Mensuel</option>
                            <option value="TRIMESTRIEL">Trimestriel</option>
                        </select>
                    </div>

                    <!-- Periode déclarée -->

                    <label for="periodeDeclaree" class="form-label">Période déclarée :</label>
                    <select name="numeroDeLaPeriode" class="form-select" aria-label="multiple select example" id="periodeDeclaree">
                        <option selected disabled >Choisir la période déclarée</option>
                    </select>
                    <button type="submit" id="submit" class="btn btn-primary mt-3">Suivant</button>
                </form>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</body>