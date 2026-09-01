<?php

include("../config/db.php");
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/sidebar.php");


// =====================================================
// MOIS ET ANNÉE ACTUELS
// =====================================================

$mois_actuel = (int) date('m');
$annee_actuelle = (int) date('Y');

$mois_francais = [
    1 => 'Janvier',
    2 => 'Février',
    3 => 'Mars',
    4 => 'Avril',
    5 => 'Mai',
    6 => 'Juin',
    7 => 'Juillet',
    8 => 'Août',
    9 => 'Septembre',
    10 => 'Octobre',
    11 => 'Novembre',
    12 => 'Décembre'
];


// =====================================================
// STATISTIQUES DU MOIS ACTUEL
// =====================================================

// Total
$sql = "
    SELECT COUNT(*) AS total
    FROM intervention
    WHERE MONTH(date) = $mois_actuel
    AND YEAR(date) = $annee_actuelle
";

$result = mysqli_query($conn, $sql);
$total = (int) mysqli_fetch_assoc($result)['total'];


// Terminées
$sql = "
    SELECT COUNT(*) AS total
    FROM intervention
    WHERE MONTH(date) = $mois_actuel
    AND YEAR(date) = $annee_actuelle
    AND etat = 'Terminée'
";

$result = mysqli_query($conn, $sql);
$terminees = (int) mysqli_fetch_assoc($result)['total'];


// En cours
$sql = "
    SELECT COUNT(*) AS total
    FROM intervention
    WHERE MONTH(date) = $mois_actuel
    AND YEAR(date) = $annee_actuelle
    AND etat = 'En cours'
";

$result = mysqli_query($conn, $sql);
$encours = (int) mysqli_fetch_assoc($result)['total'];


// En attente
$sql = "
    SELECT COUNT(*) AS total
    FROM intervention
    WHERE MONTH(date) = $mois_actuel
    AND YEAR(date) = $annee_actuelle
    AND etat = 'En attente'
";

$result = mysqli_query($conn, $sql);
$attente = (int) mysqli_fetch_assoc($result)['total'];


// =====================================================
// GRAPHIQUE 1
// INTERVENTIONS PAR JOUR DU MOIS ACTUEL
// =====================================================

$jours = [];
$interventions_jour = [];

$nombre_jours = cal_days_in_month(
    CAL_GREGORIAN,
    $mois_actuel,
    $annee_actuelle
);

for ($jour = 1; $jour <= $nombre_jours; $jour++) {

    $jours[] = $jour;

    $sql = "
        SELECT COUNT(*) AS total
        FROM intervention
        WHERE DAY(date) = $jour
        AND MONTH(date) = $mois_actuel
        AND YEAR(date) = $annee_actuelle
    ";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);

    $interventions_jour[] = (int) $row['total'];
}


// =====================================================
// GRAPHIQUE 2
// JANVIER À DÉCEMBRE
// =====================================================

$labels_mois = [];
$interventions_mois = [];

for ($mois = 1; $mois <= 12; $mois++) {

    $labels_mois[] = $mois_francais[$mois];

    $sql = "
        SELECT COUNT(*) AS total
        FROM intervention
        WHERE MONTH(date) = $mois
        AND YEAR(date) = $annee_actuelle
    ";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);

    $interventions_mois[] = (int) $row['total'];
}

?>


<!-- =====================================================
     CONTENU DES STATISTIQUES
===================================================== -->

<div class="content statistiques-page">

    <!-- TITRE -->

    <div class="statistiques-header">

        <h1>
            📊 Statistiques générales
        </h1>

        <p>
            <?= $mois_francais[$mois_actuel] ?>
            <?= $annee_actuelle ?>
        </p>

    </div>


    <!-- =================================================
         CARTES DU MOIS
    ================================================= -->

    <div class="stat-cards">


        <!-- TOTAL -->

        <div class="stat-card">

            <div class="stat-icon">
                📊
            </div>

            <div class="stat-info">

                <h3>
                    Total interventions
                </h3>

                <div class="stat-number">
                    <?= $total ?>
                </div>

            </div>

        </div>


        <!-- TERMINÉES -->

        <div class="stat-card">

            <div class="stat-icon">
                🟢
            </div>

            <div class="stat-info">

                <h3>
                    Terminées
                </h3>

                <div class="stat-number">
                    <?= $terminees ?>
                </div>

            </div>

        </div>


        <!-- EN COURS -->

        <div class="stat-card">

            <div class="stat-icon">
                🔵
            </div>

            <div class="stat-info">

                <h3>
                    En cours
                </h3>

                <div class="stat-number">
                    <?= $encours ?>
                </div>

            </div>

        </div>


        <!-- EN ATTENTE -->

        <div class="stat-card">

            <div class="stat-icon">
                🟠
            </div>

            <div class="stat-info">

                <h3>
                    En attente
                </h3>

                <div class="stat-number">
                    <?= $attente ?>
                </div>

            </div>

        </div>


    </div>


    <!-- =================================================
         GRAPHIQUE DU MOIS
    ================================================= -->

    <div class="graphique-box">

        <div class="graphique-header">

            <div>

                <h2>
                    📅 Interventions du mois
                </h2>

                <p>
                    <?= $mois_francais[$mois_actuel] ?>
                    <?= $annee_actuelle ?>
                </p>

            </div>

        </div>


        <div class="bar-chart">

            <?php

            $maximum_jour = max($interventions_jour);

            if ($maximum_jour == 0) {
                $maximum_jour = 1;
            }

            foreach ($interventions_jour as $index => $nombre):

                $hauteur = ($nombre / $maximum_jour) * 300;

            ?>

                <div class="bar-column">

                    <div class="bar-value">
                        <?= $nombre ?>
                    </div>

                    <div
                        class="bar"
                        style="height: <?= $hauteur ?>px;"
                    >
                    </div>

                    <div class="bar-label">
                        <?= $jours[$index] ?>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>


    <!-- =================================================
         GRAPHIQUE ANNUEL
    ================================================= -->

    <div class="graphique-box">

        <div class="graphique-header">

            <div>

                <h2>
                    📈 Interventions de l'année
                </h2>

                <p>
                    <?= $annee_actuelle ?>
                </p>

            </div>

        </div>


        <div class="bar-chart">

            <?php

            $maximum_mois = max($interventions_mois);

            if ($maximum_mois == 0) {
                $maximum_mois = 1;
            }

            foreach ($interventions_mois as $index => $nombre):

                $hauteur = ($nombre / $maximum_mois) * 300;

            ?>

                <div class="bar-column">

                    <div class="bar-value">
                        <?= $nombre ?>
                    </div>

                    <div
                        class="bar"
                        style="height: <?= $hauteur ?>px;"
                    >
                    </div>

                    <div class="bar-label">
                        <?= $labels_mois[$index] ?>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>


<?php

include(__DIR__ . "/../includes/footer.php");

?>