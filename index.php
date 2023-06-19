<?php

// Get the selected value from the AJAX request.
$selectedTypePeriode = $_POST['typePeriode'];
$selectedAnnee = $_POST['annee'];
$selectedNumeroDeLaPeriode = $_POST['numeroDeLaPeriode'];

$selected = $selectedAnnee . $selectedTypePeriode . $selectedNumeroDeLaPeriode;



// Do something with the selected value.
echo $selected;


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
    <div class="container">
        <form class="mt-5" method="POST" action="/">
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
                    <option value="A">Annuelle</option>
                    <option value="M">Mensuelle</option>
                    <option value="T">Trimestrielle</option>
                </select>
            </div>

            <!-- Periode déclarée -->

            <label for="periodeDeclaree" class="form-label">Période déclarée :</label>
            <select name="numeroDeLaPeriode" class="form-select" aria-label="multiple select example">
                <option selected disabled>Choisir la période déclarée</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>

<div class="d-flex flex-row">
<label for="compteCotisant" class="form-label">N° Compte Cotisant :</label>
<input type="text" class="form-control" id="compteCotisant">
<p>/</p>
<label for="suffixeCotisant" class="form-label">N° Suffixe Cotisant :</label>
<input type="text" class="form-control" id="compteCotisant">
</div>

            <!-- Numero Compte Cotisant -->

   

            <button type="submit" class="btn btn-primary <?php if ($selectedValue === 'annee') echo 'mt-3'; ?>">Suivant</button>
        </form>
    </div>
</body>