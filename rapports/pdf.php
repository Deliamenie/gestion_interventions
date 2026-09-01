<?php

ob_start();

require_once __DIR__ . '/../fpdf/fpdf.php';
include("../config/db.php");


/* =========================
   VÉRIFIER L'ID
========================= */

if (!isset($_GET['id'])) {
    ob_end_clean();
    die("Rapport introuvable.");
}

$id = intval($_GET['id']);


/* =========================
   RÉCUPÉRER LE RAPPORT
========================= */

$sql = "SELECT * FROM rapports WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    ob_end_clean();
    die("Rapport introuvable.");
}

$rapport = mysqli_fetch_assoc($result);


/* =========================
   CRÉER LE PDF
========================= */

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetTitle("Rapport d'intervention");


/* =========================
   LOGO
========================= */

$logo = __DIR__ . "/../assets/images/logo.png";

if (file_exists($logo)) {

    $pdf->Image(
        $logo,
        15,
        10,
        40
    );

    $pdf->Ln(35);}

/* =========================
   ESPACE SOUS LE LOGO
========================= */

$pdf->Ln(35);


/* =========================
   TITRE
========================= */

$pdf->SetFont('Arial', 'B', 18);

$pdf->Cell(
    0,
    15,
    utf8_decode("RAPPORT D'INTERVENTION"),
    0,
    1,
    'C'
);

$pdf->Ln(5);


/* =========================
   INFORMATIONS
========================= */

$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(
    40,
    10,
    utf8_decode("Titre :"),
    0,
    0
);

$pdf->SetFont('Arial', '', 12);

$pdf->MultiCell(
    0,
    10,
    utf8_decode($rapport['titre'])
);


$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(
    40,
    10,
    utf8_decode("Date :"),
    0,
    0
);

$pdf->SetFont('Arial', '', 12);

$pdf->Cell(
    0,
    10,
    utf8_decode($rapport['date_rapport']),
    0,
    1
);


$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(
    40,
    10,
    utf8_decode("Auteur :"),
    0,
    0
);

$pdf->SetFont('Arial', '', 12);

$pdf->Cell(
    0,
    10,
    utf8_decode($rapport['auteur']),
    0,
    1
);

$pdf->Ln(10);


/* =========================
   CONTENU DU RAPPORT
========================= */

$pdf->SetFont('Arial', 'B', 14);

$pdf->Cell(
    0,
    10,
    utf8_decode("Contenu du rapport"),
    0,
    1
);

$pdf->SetFont('Arial', '', 12);

$pdf->MultiCell(
    0,
    8,
    utf8_decode($rapport['contenu'])
);


/* =========================
   PHOTO DU RAPPORT
========================= */

if (!empty($rapport['photo'])) {

    $photo = __DIR__ . "/../uploads/" . $rapport['photo'];

    if (file_exists($photo)) {

        $dimensions = getimagesize($photo);

        if ($dimensions) {

            $largeur_originale = $dimensions[0];
            $hauteur_originale = $dimensions[1];

            /*
             * Taille maximale de la photo
             */
            $largeur_max = 100;
            $hauteur_max = 100;

            /*
             * Calcul des proportions
             */
            $ratio = min(
                $largeur_max / $largeur_originale,
                $hauteur_max / $hauteur_originale
            );

            $largeur = $largeur_originale * $ratio;
            $hauteur = $hauteur_originale * $ratio;


            /*
             * Vérifier l'espace disponible
             */
            $espace_restant =
                $pdf->GetPageHeight()
                - $pdf->GetY()
                - 20;


            if ($hauteur > $espace_restant) {

                $pdf->AddPage();

            }

            $pdf->Ln(10);

            $pdf->SetFont('Arial', 'B', 14);

            $pdf->Cell(
                0,
                10,
                utf8_decode("Photo du rapport"),
                0,
                1
            );


            /*
             * Centrer la photo
             */
            $x = (210 - $largeur) / 2;

            $pdf->Image(
                $photo,
                $x,
                $pdf->GetY(),
                $largeur,
                $hauteur
            );
        }
    }
}


/* =========================
   TÉLÉCHARGEMENT
========================= */

ob_end_clean();

$pdf->Output(
    'D',
    'rapport_' . $rapport['id'] . '.pdf'
);

exit;

?>