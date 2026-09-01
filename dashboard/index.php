<?php

include("../config/db.php");
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/sidebar.php");


// ========================================
// STATISTIQUES PRINCIPALES
// ========================================

// Nombre de clients
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM clients");
$clients = mysqli_fetch_assoc($result)['total'];


// Nombre de techniciens
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM techniciens");
$techniciens = mysqli_fetch_assoc($result)['total'];


// Nombre d'interventions
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM intervention");
$interventions = mysqli_fetch_assoc($result)['total'];


// Nombre de rapports
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rapports");
$rapports = mysqli_fetch_assoc($result)['total'];


// ========================================
// ÉTAT DES INTERVENTIONS
// ========================================

// En cours
$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM intervention
     WHERE etat = 'En cours'"
);

$en_cours = mysqli_fetch_assoc($result)['total'];


// En attente
$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM intervention
     WHERE etat = 'En attente'"
);

$en_attente = mysqli_fetch_assoc($result)['total'];


// Terminées
$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM intervention
     WHERE etat = 'Terminée'"
);

$terminees = mysqli_fetch_assoc($result)['total'];

?>

<div class="content">

    <h1>Tableau de bord</h1>

    <p>
        Bienvenue dans le système de gestion des fiches d'intervention.
    </p>


    <!-- ========================================
         CARTES PRINCIPALES
    ========================================= -->

    <div class="cards">

        <div class="card">

            <h2>👥 Clients</h2>

            <p>
                <?php echo $clients; ?>
            </p>

        </div>


        <div class="card">

            <h2>🔧 Interventions</h2>

            <p>
                <?php echo $interventions; ?>
            </p>

        </div>


        <div class="card">

            <h2>👷 Techniciens</h2>

            <p>
                <?php echo $techniciens; ?>
            </p>

        </div>


        <div class="card">

            <h2>📄 Rapports</h2>

            <p>
                <?php echo $rapports; ?>
            </p>

        </div>

    </div>


    <!-- ========================================
         ÉTAT DES INTERVENTIONS
    ========================================= -->

    <div class="etat-interventions">

        <h2>État des interventions</h2>


        <div class="etat-card">

            <h3>🔵 En cours</h3>

            <p>
                <?php echo $en_cours; ?>
            </p>

        </div>


        <div class="etat-card">

            <h3>🟠 En attente</h3>

            <p>
                <?php echo $en_attente; ?>
            </p>

        </div>


        <div class="etat-card">

            <h3>🟢 Terminées</h3>

            <p>
                <?php echo $terminees; ?>
            </p>

        </div>

    </div>

</div>


<?php

include(__DIR__ . "/../includes/footer.php");

?>