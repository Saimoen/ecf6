<?php

/** create XML file */
$mysqli = new mysqli("localhost", "root", "Gregsaimoen12@", "ecfc6");

/* check connection */
if ($mysqli->connect_errno) {
    echo "Connect failed " . $mysqli->connect_error;
    exit();
}

$queryBulletin = "SELECT * FROM ecfc6.bulletin";
$queryLigneBulletin = "SELECT * FROM ecfc6.ligne_bulletin";
$queryRubrique = "SELECT distinct b.*, s.*, lb.*
FROM bulletin b
JOIN salaries s ON b.salarie_id = s.id
JOIN ligne_bulletin lb ON lb.bulletin_id = b.id";
$querySalaries = "SELECT * FROM ecfc6.salaries";
$querySociete = "SELECT * FROM ecfc6.societe";
$queryAssiette = "SELECT SUM(base) base FROM ecfc6.ligne_bulletin;";

$bulletinArray = array();
$ligneBulletinArray = array();
$rubriqueArray = array();
$salariesArray = array();
$societeArray = array();
$assietteArray = array();

/* Ajoute les informations de la table Salaries */
if ($result = $mysqli->query($querySalaries)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        array_push($salariesArray, $row);
    }

    if (count($salariesArray)) {
        createXMLfile($salariesArray, $bulletinArray, $assietteArray, $rubriqueArray, $societeArray);
    }

    /* free result set */
    $result->free();
}
/* Ajoute les informations de la table Bulletin */
if ($result = $mysqli->query($queryBulletin)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        array_push($bulletinArray, $row);
    }

    if (count($bulletinArray)) {
        createXMLfile($salariesArray, $bulletinArray, $assietteArray, $rubriqueArray, $societeArray);
    }

    /* free result set */
    $result->free();
}
/* Ajoute les informations de la table Rubrique */
if ($result = $mysqli->query($queryRubrique)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        array_push($rubriqueArray, $row);
    }

    if (count($rubriqueArray)) {
        createXMLfile($rubriqueArray, $bulletinArray, $assietteArray, $rubriqueArray, $societeArray);
    }

    /* free result set */
    $result->free();
}
/* Ajoute les informations de la table Societe */
if ($result = $mysqli->query($querySociete)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        array_push($societeArray, $row);
    }

    if (count($societeArray)) {
        createXMLfile($salariesArray, $bulletinArray, $assietteArray, $rubriqueArray, $societeArray);
    }

    /* free result set */
    $result->free();
}

if ($result = $mysqli->query($queryAssiette)) {

    /* fetch associative array */
    while ($row = $result->fetch_assoc()) {
        array_push($assietteArray, $row);
    }

    if (count($assietteArray)) {
        createXMLfile($salariesArray, $bulletinArray, $assietteArray, $rubriqueArray, $societeArray);
    }

    /* free result set */
    $result->free();
}

/* close connection */
$mysqli->close();


function createXMLfile($salariesArray, $bulletinArray, $assietteArray, $rubriqueArray, $societeArray)
{
    /* Gestion du formulaire */
    $originalString = "120623/001";
    $formattedString = str_replace('/', '', $originalString);

    $selectedTypePeriode = $_POST['typePeriode'];
    $selectedAnnee = $_POST['annee'];
    $selectedNumero = $_POST['numeroDeLaPeriode'];

    if (isset($selectedTypePeriode) && isset($selectedAnnee) && isset($selectedNumero)) {

        $selected = $selectedAnnee . nameFile() . formatPeriode();

        $filePath = "DN-" . $selected .  '-' . $formattedString . '-' . '012' . '.xml';

        $dom = new DOMDocument('1.0', 'ISO-8859-1');

        $doc = $dom->createElement('doc');
        $dom->appendChild($doc);

        /* En-tête */

        $entete = $dom->createElement('entete');
        $doc->appendChild($entete);

        $type = $dom->createElement('type', 'DN');
        $entete->appendChild($type);

        $version = $dom->createElement('version', 'VERSION_2_0');
        $entete->appendChild($version);

        $emetteur = $dom->createElement('emetteur', 'Comptagest');
        $entete->appendChild($emetteur);

        $dateGeneration = $dom->createElement('dateGeneration', '2023-01-17T15:30:18');
        $entete->appendChild($dateGeneration);

        $logiciel = $dom->createElement('logiciel');
        $entete->appendChild($logiciel);

        $editeur = $dom->createElement('editeur', 'MONEDITEUR');
        $logiciel->appendChild($editeur);

        $nom = $dom->createElement('nom', 'MONPROGICIEL');
        $logiciel->appendChild($nom);

        $versionLogiciel = $dom->createElement('version', '10.2.1');
        $logiciel->appendChild($versionLogiciel);

        $dateVersion = $dom->createElement('dateVersion', '2022-12-25');
        $logiciel->appendChild($dateVersion);

        /* En-tête */

        /* Corps */

        $corps = $dom->createElement('corps');
        $doc->appendChild($corps);

        $periode = $dom->createElement('periode');
        $corps->appendChild($periode);

        $typePeriode = $dom->createElement('type', $selectedTypePeriode);
        $periode->appendChild($typePeriode);

        $annee = $dom->createElement('annee', $selectedAnnee);
        $periode->appendChild($annee);

        $numero = $dom->createElement('numero', $selectedNumero);
        $periode->appendChild($numero);

        $attributs = $dom->createElement('attributs');
        $corps->appendChild($attributs);

        $complementaire = $dom->createElement('complementaire', 'false');
        $attributs->appendChild($complementaire);

        $contratAlternance = $dom->createElement('contratAlternance', 'false');
        $attributs->appendChild($contratAlternance);

        $pasAssureRemunere = $dom->createElement('pasAssureRemunere', 'false');
        $attributs->appendChild($pasAssureRemunere);

        $pasDeReembauche = $dom->createElement('pasDeReembauche', 'false');
        $attributs->appendChild($pasDeReembauche);

        $employeur = $dom->createElement('employeur');
        $corps->appendChild($employeur);

        for ($i = 0; $i < count($societeArray); $i++) {
            $numeroEmployeur = $dom->createElement('numero', format_number($societeArray[$i]['numerocafat']));
            $employeur->appendChild($numeroEmployeur);

            $suffixe = $dom->createElement('suffixe', '001');
            $employeur->appendChild($suffixe);

            $nomEmployeur = $dom->createElement('nom', $societeArray[$i]['enseigne']);
            $employeur->appendChild($nomEmployeur);

            $rid = $dom->createElement('rid', format_rid($societeArray[$i]['ridet']));
            $employeur->appendChild($rid);

            $codeCotisation = $dom->createElement('codeCotisation', '001');
            $employeur->appendChild($codeCotisation);

            $tauxATPrincipal = $dom->createElement('tauxATPrincipal', $societeArray[$i]['tauxat']);
            $employeur->appendChild($tauxATPrincipal);
        }


        $assures = $dom->createElement('assures');
        $corps->appendChild($assures);

        for ($i = 0; $i < count($salariesArray); $i++) {
            $assure = $dom->createElement('assure');
            $assures->appendChild($assure);

            $numeroAssure = $dom->createElement('numero', $salariesArray[$i]['numcafat']);
            $assure->appendChild($numeroAssure);

            $nomAssure = $dom->createElement('nom', $salariesArray[$i]['nom']);
            $assure->appendChild($nomAssure);

            $prenomsAssure = $dom->createElement('prenoms', $salariesArray[$i]['prenom']);
            $assure->appendChild($prenomsAssure);

            $dateNaissanceAssure = $dom->createElement('dateNaissance', $salariesArray[$i]['dnaissance']);
            $assure->appendChild($dateNaissanceAssure);

            $codeAT = $dom->createElement('codeAT', 'PRINCIPAL');
            $assure->appendChild($codeAT);

            $etablissementRID = $dom->createElement('etablissementRID', '001');
            $assure->appendChild($etablissementRID);

            $codeCommune = $dom->createElement('codeCommune', '05');
            $assure->appendChild($codeCommune);

            $nombreHeures = $dom->createElement('nombreHeures', formatFloat($bulletinArray[$i]['nombre_heures']));
            $assure->appendChild($nombreHeures);

            $remuneration = $dom->createElement('remuneration', $bulletinArray[$i]['brut']);

            $assiettes = $dom->createElement('assiettes');
            $assure->appendChild($assiettes);

            $assure->appendChild($remuneration);
            if ($rubriqueArray[$i]['rubrique_id'] = 57) {
                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'RUAMM');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }

            if ($rubriqueArray[$i]['rubrique_id'] = 67) {

                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'FIAF');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }

            if ($rubriqueArray[$i]['rubrique_id'] = 56) {

                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'RETRAITE');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }

            if ($rubriqueArray[$i]['rubrique_id'] = 64) {

                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'FORMATION_PROFESSIONNELLE');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }

            if ($rubriqueArray[$i]['rubrique_id'] = 65) {

                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'FSH');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }

            if ($rubriqueArray[$i]['rubrique_id'] = 56) {

                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'PRESTATIONS_FAMILIALES');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }

            if ($rubriqueArray[$i]['rubrique_id'] = 68) {

                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'FDS');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }

            if ($rubriqueArray[$i]['rubrique_id'] = 56) {

                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'CHOMAGE');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }

            if ($rubriqueArray[$i]['rubrique_id'] = 62) {

                $assiette = $dom->createElement('assiette');
                $assiettes->appendChild($assiette);
                $type = $dom->createElement('type', 'ATMP');
                $assiette->appendChild($type);

                $valeur = $dom->createElement('valeur', round($rubriqueArray[$i]['base']));
                $assiette->appendChild($valeur);
            }
        }

        /* Décompte */

        $decompte = $dom->createElement('decompte');
        $cotisations = $dom->createElement('cotisations');


        $corps->appendChild($decompte);
        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'RUAMM');
        $tranche = $dom->createElement('tranche', 'TRANCHE_1');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 15.52)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($tranche);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);


        $corps->appendChild($decompte);

        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'RUAMM');
        $tranche = $dom->createElement('tranche', 'TRANCHE_2');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 5)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($tranche);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);


        $corps->appendChild($decompte);

        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'FIAF');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 0.2)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);

        $corps->appendChild($decompte);

        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'RETRAITE');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 14)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);

        $corps->appendChild($decompte);

        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'ATMP_PRINCIPAL');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 0.72)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);


        $corps->appendChild($decompte);

        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'CCS');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 2)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);


        $corps->appendChild($decompte);

        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'FORMATION_PROFESSIONNELLE');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 0.25)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);

        $corps->appendChild($decompte);

        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'FSH');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 2)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);

        $corps->appendChild($decompte);

        $decompte->appendChild($cotisations);

        $cotisation = $dom->createElement('cotisation');
        $cotisations->appendChild($cotisation);

        $type = $dom->createElement('type', 'FDS');
        $assiette = $dom->createElement('assiette', round($assietteArray[0]['base']));
        $valeur = $dom->createElement('valeur', round(calculValeur($rubriqueArray[$i]['base'], 0.075)));

        $cotisation->appendChild($type);
        $cotisation->appendChild($assiette);
        $cotisation->appendChild($valeur);

        $deductions = $dom->createElement('deductions');
        $decompte->appendChild($deductions);

        /* Corps */

        $dom->save($filePath);
    } else {
        header("HTTP/1.1 404 Not Found");
    }
}



/* Formatage de données */


function format_number($number)
{
    // Split the number into two parts: the main number and the suffix.
    $number_parts = explode("/", $number);
    $main_number = $number_parts[0];

    // Pad the main number with zeros to make it 4 digits long.
    $main_number = str_pad($main_number, 4, "0", STR_PAD_LEFT);

    // Format the number into the desired format.
    $formatted_number = sprintf($main_number);

    return $formatted_number;
}

function format_suffix($suffix)
{
    // Split the number into two parts: the main number and the suffix.
    $number_parts = explode("/", $suffix);
    $main_number = $number_parts[1];

    // Pad the main number with zeros to make it 4 digits long.
    $main_number = str_pad($main_number, 3, "0", STR_PAD_LEFT);

    // Format the number into the desired format.
    $formatted_number = sprintf($main_number);

    return $formatted_number;
}

function format_rid($rid)
{
    // Split the number into two parts: the main number and the suffix.
    $number_parts = explode(".", $rid);
    $main_number = $number_parts[0];

    // Pad the main number with zeros to make it 4 digits long.
    $main_number = str_pad($main_number, 6, "0", STR_PAD_LEFT);

    // Format the number into the desired format.
    $formatted_number = sprintf($main_number);

    return $formatted_number;
}

/* Nom de fichier */


function nameFile()
{
    $selectedTypePeriode = $_POST['typePeriode'];


    if ($selectedTypePeriode === "ANNUEL") {
        return "A";
    } elseif ($selectedTypePeriode === "MENSUEL") {
        return "M";
    } elseif ($selectedTypePeriode === "TRIMESTRIEL") {
        return "T";
    }
}

function formatPeriode()
{
    $selectedNumeroDeLaPeriode = $_POST['numeroDeLaPeriode'];
    if ($selectedNumeroDeLaPeriode === "1") {
        return "01";
    } elseif ($selectedNumeroDeLaPeriode === "2") {
        return "02";
    } elseif ($selectedNumeroDeLaPeriode === "3") {
        return "03";
    } elseif ($selectedNumeroDeLaPeriode === "4") {
        return "04";
    } elseif ($selectedNumeroDeLaPeriode === "5") {
        return "05";
    } elseif ($selectedNumeroDeLaPeriode === "6") {
        return "06";
    } elseif ($selectedNumeroDeLaPeriode === "7") {
        return "07";
    } elseif ($selectedNumeroDeLaPeriode === "8") {
        return "08";
    } elseif ($selectedNumeroDeLaPeriode === "9") {
        return "09";
    } elseif ($selectedNumeroDeLaPeriode === "10") {
        return "10";
    } elseif ($selectedNumeroDeLaPeriode === "11") {
        return "11";
    } elseif ($selectedNumeroDeLaPeriode === "12") {
        return "12";
    }
}


function formatFloat($float)
{
    $number = number_format($float, 2, '.', '');
    $length = strlen($number);

    if ($length <= 6) {
        return $number;
    } else {
        return substr($number, 0, 3) . '.' . substr($number, 3, 2);
    }
}

function calculValeur($base, $taux)
{
    return ($base * $taux) / 100;
}
