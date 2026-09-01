<?php

include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = $_POST['date_planification'];
    $heure = $_POST['heure_planification'];
    $client = $_POST['client'];
    $technicien = $_POST['technicien'];
    $description = $_POST['description'];

    $sql = "INSERT INTO planifications
            (
                date_planification,
                heure_planification,
                client,
                technicien,
                description,
                statut
            )
            VALUES
            (
                '$date',
                '$heure',
                '$client',
                '$technicien',
                '$description',
                'Planifiée'
            )";

    if (mysqli_query($conn, $sql)) {

        header("Location: index.php");
        exit;

    } else {

        $message = "Erreur : " . mysqli_error($conn);

    }
}

?>

<div class="content">

    <h1>📅 NOUVELLE PLANIFICATION</h1>

    <?php if ($message != "") { ?>

        <p style="color:red;">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>


    <form method="POST">

        <label>
            <strong>Date de l'intervention</strong>
        </label>

        <br>

        <input
            type="date"
            name="date_planification"
            required
        >

        <br><br>


        <label>
            <strong>Heure de l'intervention</strong>
        </label>

        <br>

        <input
            type="time"
            name="heure_planification"
            required
        >

        <br><br>


        <label>
            <strong>Client</strong>
        </label>

        <br>

        <input
            type="text"
            name="client"
            placeholder="Nom du client"
            required
        >

        <br><br>


        <label>
            <strong>Technicien</strong>
        </label>

        <br>

        <input
            type="text"
            name="technicien"
            placeholder="Nom du technicien"
            required
        >

        <br><br>


        <label>
            <strong>Description</strong>
        </label>

        <br>

        <textarea
            name="description"
            rows="5"
            placeholder="Description de l'intervention"
        ></textarea>

        <br><br>


        <button type="submit">
            📅 Planifier
        </button>


        <a href="index.php">

            <button type="button">
                ⬅️ Retour
            </button>

        </a>

    </form>

</div>

<?php

include("../includes/footer.php");

?>