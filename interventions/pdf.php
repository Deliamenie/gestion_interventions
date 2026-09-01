<?php

ob_start();

require_once __DIR__ . '/../fpdf/fpdf.php';
include("../config/db.php");


/* =========================================================
   VERIFICATION DE L'ID
========================================================= */

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de l'intervention manquant.");
}

$id = intval($_GET['id']);


/* =========================================================
   RECUPERER L'INTERVENTION
========================================================= */

$sql = "SELECT * FROM intervention WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Intervention introuvable.");
}

$row = mysqli_fetch_assoc($result);


/* =========================================================
   FONCTIONS
========================================================= */

function txt($text)
{
    return utf8_decode((string)($text ?? ''));
}

function val($row, $field)
{
    return isset($row[$field]) ? trim((string)$row[$field]) : '';
}


/*
   Vérifie si une valeur contient un texte.
   Cela permet de fonctionner avec :
   "LAN"
   "LAN, RF"
   "LAN - Matériel"
   etc.
*/
function selected($value, $search)
{
    $value = strtolower(trim((string)$value));
    $search = strtolower(trim((string)$search));

    return strpos($value, $search) !== false;
}


/* =========================================================
   CLASSE PDF
========================================================= */

class PDF extends FPDF
{
    public $green = array(76, 145, 45);
    public $lightGreen = array(235, 244, 231);
    public $lightBlue = array(238, 243, 247);
    public $border = array(100, 150, 80);


    /* =====================================================
       HEADER
    ===================================================== */

    function Header()
    {
        $logo = __DIR__ . '/../assets/images/logo.png';


        /* -------------------------------------------------
           LOGO PETIT
        ------------------------------------------------- */

        if (file_exists($logo)) {

            $this->Image(
                $logo,
                12,
                7,
                17,
                0,
                'PNG'
            );
        }


        /* -------------------------------------------------
           TITRE
        ------------------------------------------------- */

        $this->SetDrawColor(
            76,
            145,
            45
        );

        $this->SetTextColor(
            45,
            65,
            45
        );

        $this->SetFont(
            'Arial',
            'B',
            11
        );

        $this->SetXY(
            105,
            10
        );

        $this->Cell(
            90,
            9,
            txt("FICHE D'INTERVENTION"),
            1,
            1,
            'C'
        );
    }


    /* =====================================================
       BARRE SECTION
    ===================================================== */

    function Section($title, $height = 6)
    {
        $this->SetFillColor(
            76,
            145,
            45
        );

        $this->SetDrawColor(
            76,
            145,
            45
        );

        $this->SetTextColor(
            35,
            55,
            40
        );

        $this->SetFont(
            'Arial',
            'B',
            7.5
        );

        $this->Cell(
            190,
            $height,
            txt($title),
            1,
            1,
            'C',
            true
        );

        $this->SetTextColor(
            35,
            35,
            35
        );
    }


    /* =====================================================
       CASE A COCHER
    ===================================================== */

    function Checkbox($x, $y, $text, $checked = false, $width = 30)
    {
        $this->SetDrawColor(
            80,
            80,
            80
        );

        $this->Rect(
            $x,
            $y + 1,
            3,
            3
        );

        if ($checked) {

            $this->SetFont(
                'Arial',
                'B',
                7
            );

            $this->SetXY(
                $x - 0.2,
                $y - 0.5
            );

            $this->Cell(
                4,
                5,
                'X',
                0,
                0,
                'C'
            );
        }

        $this->SetFont(
            'Arial',
            '',
            6.5
        );

        $this->SetXY(
            $x + 5,
            $y
        );

        $this->Cell(
            $width,
            5,
            txt($text),
            0,
            0,
            'L'
        );
    }


    /* =====================================================
       TEXTE DANS UNE ZONE
    ===================================================== */

    function TextArea($text, $height)
    {
        $x = $this->GetX();
        $y = $this->GetY();

        $this->SetDrawColor(
            100,
            150,
            80
        );

        $this->Rect(
            $x,
            $y,
            190,
            $height
        );

        $this->SetXY(
            $x + 3,
            $y + 2
        );

        $this->SetFont(
            'Arial',
            '',
            7
        );

        $this->MultiCell(
            184,
            4,
            txt($text),
            0,
            'L'
        );

        $this->SetY(
            $y + $height
        );
    }
}


/* =========================================================
   CREATION PDF
========================================================= */

$pdf = new PDF(
    'P',
    'mm',
    'A4'
);

$pdf->SetMargins(
    10,
    8,
    10
);

$pdf->SetAutoPageBreak(
    false
);

$pdf->AddPage();


/* =========================================================
   INFORMATIONS DU HAUT
========================================================= */

$pdf->SetTextColor(
    35,
    35,
    35
);

$pdf->SetFont(
    'Arial',
    'B',
    7.5
);


/* DATE */

$pdf->SetXY(
    10,
    29
);

$pdf->Cell(
    85,
    6,
    txt("Date : " . val($row, 'date')),
    0,
    0,
    'L'
);


/* RESPONSABLE */

$pdf->SetXY(
    105,
    29
);

$pdf->Cell(
    85,
    6,
    txt(
        "Responsable Intervention : " .
        val($row, 'responsable_intervention')
    ),
    0,
    1,
    'L'
);


/* HEURE ARRIVEE */

$pdf->SetXY(
    10,
    35
);

$pdf->Cell(
    85,
    6,
    txt(
        "Heure d'arrivée : " .
        val($row, 'heure_arrivee')
    ),
    0,
    0,
    'L'
);


/* HEURE DEPART */

$pdf->SetXY(
    105,
    35
);

$pdf->Cell(
    85,
    6,
    txt(
        "Heure de départ : " .
        val($row, 'heure_depart')
    ),
    0,
    1,
    'L'
);


/* =========================================================
   INFORMATIONS GENERALES
========================================================= */

$pdf->SetY(42);

$pdf->Section(
    "INFORMATIONS GENERALES",
    6
);

$generalY = $pdf->GetY();


/* CADRE */

$pdf->SetDrawColor(
    100,
    150,
    80
);

$pdf->SetFillColor(
    250,
    252,
    249
);

$pdf->Rect(
    10,
    $generalY,
    190,
    38,
    'DF'
);


/* SEPARATIONS */

$pdf->Line(
    80,
    $generalY,
    80,
    $generalY + 38
);

$pdf->Line(
    145,
    $generalY,
    145,
    $generalY + 38
);


/* ---------------------------------------------------------
   COLONNE 1
--------------------------------------------------------- */

$pdf->SetFont(
    'Arial',
    '',
    7
);

$pdf->SetXY(
    13,
    $generalY + 2
);

$pdf->Cell(
    64,
    5,
    txt("Ticket ID : " . val($row, 'ticket_id')),
    0,
    1
);

$pdf->Cell(
    64,
    5,
    txt("Nom Client : " . val($row, 'client_id')),
    0,
    1
);

$pdf->Cell(
    64,
    5,
    txt("Localisation : " . val($row, 'localisation')),
    0,
    1
);

$pdf->Cell(
    64,
    5,
    txt("Tel : " . val($row, 'telephone')),
    0,
    1
);

$pdf->Cell(
    64,
    5,
    txt(
        "Sous contrat maintenance : " .
        val($row, 'sous_contrat_maintenance')
    ),
    0,
    1
);

$pdf->Cell(
    64,
    5,
    txt(
        "Equipements protégés : " .
        val($row, 'equipement_proteges')
    ),
    0,
    1
);


/* ---------------------------------------------------------
   COLONNE 2 : CLASSE DE SERVICE
--------------------------------------------------------- */

$pdf->SetXY(
    84,
    $generalY + 3
);

$pdf->SetFont(
    'Arial',
    'B',
    7
);

$pdf->Cell(
    55,
    5,
    txt("Classe de service :"),
    0,
    1
);

$classe = val($row, 'classe_service');


$pdf->Checkbox(
    85,
    $generalY + 9,
    "Corporate",
    selected($classe, "corporate"),
    35
);

$pdf->Checkbox(
    85,
    $generalY + 15,
    "Matrix Pro",
    selected($classe, "matrix pro"),
    35
);

$pdf->Checkbox(
    85,
    $generalY + 21,
    "Matrix Home",
    selected($classe, "matrix home"),
    35
);

$pdf->Checkbox(
    85,
    $generalY + 27,
    "Matrix Flotte",
    selected($classe, "matrix flotte"),
    35
);


/* ---------------------------------------------------------
   COLONNE 3 : DEBIT
--------------------------------------------------------- */

$pdf->SetXY(
    149,
    $generalY + 3
);

$pdf->SetFont(
    'Arial',
    'B',
    7
);

$pdf->Cell(
    45,
    5,
    txt("Débit souscrit :"),
    0,
    1
);

$debit = val(
    $row,
    'debit_souscrit'
);


$pdf->Checkbox(
    150,
    $generalY + 9,
    "256 kb",
    selected($debit, "256"),
    25
);

$pdf->Checkbox(
    150,
    $generalY + 15,
    "512 KB",
    selected($debit, "512"),
    25
);

$pdf->Checkbox(
    150,
    $generalY + 21,
    "1024 kb",
    selected($debit, "1024"),
    25
);

$pdf->Checkbox(
    150,
    $generalY + 27,
    "2048 kb",
    selected($debit, "2048"),
    25
);


/* =========================================================
   PANNE SIGNALEE
========================================================= */

$pdf->SetY(
    $generalY + 38
);

$pdf->Section(
    "PANNE SIGNALEE",
    6
);

$pdf->SetFont(
    'Arial',
    '',
    7
);

$pdf->SetFillColor(
    250,
    252,
    249
);

$pdf->Cell(
    190,
    8,
    txt(val($row, 'panne_signalee')),
    1,
    1,
    'L',
    true
);


/* =========================================================
   NATURE DE LA PANNE
========================================================= */

$pdf->Section(
    "NATURE DE LA PANNE",
    6
);

$natureY = $pdf->GetY();

$pdf->SetDrawColor(
    100,
    150,
    80
);

$pdf->Rect(
    10,
    $natureY,
    190,
    13
);

$nature = val(
    $row,
    'nature_panne'
);


/* PREMIERE LIGNE */

$pdf->Checkbox(
    13,
    $natureY + 2,
    "Énergie",
    selected($nature, "énergie") || selected($nature, "energie"),
    22
);

$pdf->Checkbox(
    42,
    $natureY + 2,
    "RF",
    selected($nature, "rf"),
    14
);

$pdf->Checkbox(
    61,
    $natureY + 2,
    "LAN",
    selected($nature, "lan"),
    18
);

$pdf->Checkbox(
    84,
    $natureY + 2,
    "Matériel",
    selected($nature, "matériel") || selected($nature, "materiel"),
    28
);

$pdf->Checkbox(
    118,
    $natureY + 2,
    "Routeur",
    selected($nature, "routeur"),
    25
);

$pdf->Checkbox(
    148,
    $natureY + 2,
    "PoE",
    selected($nature, "poe"),
    18
);

$pdf->Checkbox(
    171,
    $natureY + 2,
    "Alimentation",
    selected($nature, "alimentation"),
    28
);


/* DEUXIEME LIGNE */

$pdf->Checkbox(
    13,
    $natureY + 8,
    "Network",
    selected($nature, "network"),
    28
);

$pdf->Checkbox(
    48,
    $natureY + 8,
    "POP",
    selected($nature, "pop"),
    20
);

$pdf->Checkbox(
    75,
    $natureY + 8,
    "Autres (à spécifier)",
    selected($nature, "autres"),
    50
);


/* =========================================================
   DETAILS PRESTATIONS
========================================================= */

$pdf->SetY(
    $natureY + 13
);

$pdf->Section(
    "DETAILS PRESTATIONS",
    6
);

$detailsY = $pdf->GetY();


/* Zone plus petite pour garder tout sur une page */

$pdf->TextArea(
    val($row, 'details_prestations'),
    43
);


/* =========================================================
   PERFORMANCES OBTENUES
========================================================= */

$pdf->Section(
    "PERFORMANCES OBTENUES",
    6
);


/* HEADER */

$pdf->SetFont(
    'Arial',
    'B',
    7
);

$pdf->SetFillColor(
    235,
    240,
    244
);

$pdf->Cell(
    100,
    6,
    txt("Latence"),
    1,
    0,
    'L',
    true
);

$pdf->Cell(
    28,
    6,
    txt("SLA normal"),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    62,
    6,
    txt("Performance Obtenue"),
    1,
    1,
    'C',
    true
);


/* DONNEES */

$pdf->SetFont(
    'Arial',
    '',
    6.8
);

$performances = array(

    array(
        "Latence client---BST",
        "1-10ms",
        val($row, 'performance_bst')
    ),

    array(
        "Latence client---Passerelle",
        "1-10ms",
        val($row, 'performance_passerelle')
    ),

    array(
        "Latence client---8.8.8.8",
        "90-150ms",
        val($row, 'performance_8888')
    ),

    array(
        "Latence interco",
        "20-100ms",
        val($row, 'performance_interco')
    )
);


foreach ($performances as $p) {

    $pdf->Cell(
        100,
        5,
        txt($p[0]),
        1
    );

    $pdf->Cell(
        28,
        5,
        txt($p[1]),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        62,
        5,
        txt($p[2]),
        1,
        1
    );
}


/* =========================================================
   APPRECIATION QUALITE SERVICE
========================================================= */

$pdf->Section(
    "APPRECIATION DE LA QUALITE DE SERVICE APRES INTERVENTION (RESERVE CLIENT)",
    6
);

$qualiteY = $pdf->GetY();

$pdf->Rect(
    10,
    $qualiteY,
    190,
    12
);

$qualite = val(
    $row,
    'qualite_service'
);


$pdf->Checkbox(
    15,
    $qualiteY + 2,
    "Excellente",
    selected($qualite, "excellente"),
    35
);

$pdf->Checkbox(
    15,
    $qualiteY + 7,
    "Bonne",
    selected($qualite, "bonne"),
    30
);

$pdf->Checkbox(
    80,
    $qualiteY + 2,
    "Assez-bien",
    selected($qualite, "assez"),
    35
);

$pdf->Checkbox(
    80,
    $qualiteY + 7,
    "Mauvaise",
    selected($qualite, "mauvaise"),
    35
);


/* =========================================================
   EVALUATION PRESTATION
========================================================= */

$pdf->SetY(
    $qualiteY + 12
);

$pdf->Section(
    "EVALUATION DE LA PRESTATION (RESERVE CLIENT)",
    6
);


/* HEADER */

$pdf->SetFont(
    'Arial',
    'B',
    6.8
);

$pdf->SetFillColor(
    235,
    240,
    244
);

$pdf->Cell(
    100,
    6,
    txt("Critère"),
    1,
    0,
    'L',
    true
);

$pdf->Cell(
    28,
    6,
    txt("Note (1 à 10)"),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    62,
    6,
    txt("Commentaire"),
    1,
    1,
    'C',
    true
);


/* CRITERES */

$pdf->SetFont(
    'Arial',
    '',
    6.5
);

$criteres = array(
    "Pertinence du diagnostic et clarté des explications apportées",
    "Résolution de la problématique remontée",
    "Attitude professionnelle (politesse, courtoisie, ponctualité)"
);


foreach ($criteres as $index => $critere) {

    $note = '';
    $commentaire = '';

    /*
       On met la note/commentaire enregistrés
       sur la première ligne.
    */

    if ($index == 0) {

        $note = val(
            $row,
            'note_sur_10'
        );

        $commentaire = val(
            $row,
            'commentaire'
        );
    }


    $pdf->Cell(
        100,
        5,
        txt($critere),
        1
    );

    $pdf->Cell(
        28,
        5,
        txt($note),
        1,
        0,
        'C'
    );

    $pdf->Cell(
        62,
        5,
        txt($commentaire),
        1,
        1
    );
}


/* =========================================================
   SIGNATURES
========================================================= */

$pdf->SetFont(
    'Arial',
    'B',
    7
);

$pdf->SetFillColor(
    76,
    145,
    45
);

$pdf->SetTextColor(
    35,
    55,
    40
);

$pdf->Cell(
    95,
    6,
    txt("POUR MATRIX TELECOMS / NOM ET FONCTION"),
    1,
    0,
    'C',
    true
);

$pdf->Cell(
    95,
    6,
    txt("POUR LE CLIENT / NOM ET FONCTION"),
    1,
    1,
    'C',
    true
);


/* NOMS */

$pdf->SetTextColor(
    35,
    35,
    35
);

$pdf->SetFont(
    'Arial',
    '',
    6.8
);

$pdf->Cell(
    95,
    5,
    txt(
        val(
            $row,
            'nom_fonction_matrix_telecoms'
        )
    ),
    1,
    0,
    'C'
);

$pdf->Cell(
    95,
    5,
    txt(
        val(
            $row,
            'nom_fonction_client'
        )
    ),
    1,
    1,
    'C'
);


/* =========================================================
   ZONES SIGNATURE
========================================================= */

$signatureY = $pdf->GetY();

$pdf->Cell(
    95,
    15,
    '',
    1,
    0
);

$pdf->Cell(
    95,
    15,
    '',
    1,
    1
);


/* =========================================================
   SIGNATURE MATRIX
========================================================= */

if (!empty($row['signature_matrix_telecoms'])) {

    $signature = $row['signature_matrix_telecoms'];

    if (strpos($signature, 'base64,') !== false) {

        $signature = explode(
            'base64,',
            $signature
        )[1];
    }

    $data = base64_decode(
        $signature
    );

    if ($data !== false) {

        $file = sys_get_temp_dir()
              . '/matrix_signature_' . $id . '.png';

        file_put_contents(
            $file,
            $data
        );

        if (file_exists($file)) {

            $pdf->Image(
                $file,
                22,
                $signatureY + 1,
                65,
                12
            );
        }
    }
}


/* =========================================================
   SIGNATURE CLIENT
========================================================= */

if (!empty($row['signature_client'])) {

    $signature = $row['signature_client'];

    if (strpos($signature, 'base64,') !== false) {

        $signature = explode(
            'base64,',
            $signature
        )[1];
    }

    $data = base64_decode(
        $signature
    );

    if ($data !== false) {

        $file = sys_get_temp_dir()
              . '/client_signature_' . $id . '.png';

        file_put_contents(
            $file,
            $data
        );

        if (file_exists($file)) {

            $pdf->Image(
                $file,
                117,
                $signatureY + 1,
                65,
                12
            );
        }
    }
}


/* =========================================================
   NETTOYAGE
========================================================= */

ob_end_clean();


/* =========================================================
   AFFICHER PDF
========================================================= */

$pdf->Output(
    'I',
    'fiche_intervention_' . $id . '.pdf'
);

exit;

?>