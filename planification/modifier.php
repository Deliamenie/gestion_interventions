<?php

include("../includes/auth.php");
include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM planifications WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Planification introuvable.");
}

$planification = mysqli_fetch_assoc($result);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = mysqli_real_escape_string($conn, $_POST['date_planification']);
    $heure = mysqli_real_escape_string($conn, $_POST['heure_planification']);
    $client = mysqli_real_escape_string($conn, $_POST['client']);
    $technicien = mysqli_real_escape_string($conn, $_POST['technicien']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $statut = mysqli_real_escape_string($conn, $_POST['statut']);

    $sql = "UPDATE planifications SET
            date_planification = '$date',
            heure_planification = '$heure',
            client = '$client',
            technicien = '$technicien',
            description = '$description',
            statut = '$statut'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {

        header("Location: index.php");
        exit;

    } else {

        $erreur = "Erreur : " . mysqli_error($conn);
    }
}

?>

<div class="content">

    <h1>✏️ MODIFIER LA PLANIFICATION</h1>

    <?php if (isset($erreur)) { ?>

        <p style="color:red;">
            <?php echo htmlspecialchars($erreur); ?>
        </p>

    <?php } ?>

    <form method="POST">

        <label><strong>Date</strong></label><br>

        <input
            type="date"
            name="date_planification"
            value="<?php echo htmlspecialchars($planification['date_planification']); ?>"
            required
        >

        <br><br>


        <label><strong>Heure</strong></label><br>

        <input
            type="time"
            name="heure_planification"
            value="<?php echo htmlspecialchars($planification['heure_planification']); ?>"
            required
        >

        <br><br>


        <label><strong>Client</strong></label><br>

        <input
            type="text"
            name="client"
            value="<?php echo htmlspecialchars($planification['client']); ?>"
            required
        >

        <br><br>


        <label><strong>Technicien</strong></label><br>

        <input
            type="text"
            name="technicien"
            value="<?php echo htmlspecialchars($planification['technicien']); ?>"
            required
        >

        <br><br>


        <label><strong>Description</strong></label><br>

        <textarea
            name="description"
            rows="5"
        ><?php echo htmlspecialchars($planification['description']); ?></textarea>

        <br><br>


        <label><strong>Statut</strong></label><br>

        <select name="statut" required>

            <option value="Planifiée"
                <?php if ($planification['statut'] == 'Planifiée') echo 'selected'; ?>>
                Planifiée
            </option>

            <option value="En cours"
                <?php if ($planification['statut'] == 'En cours') echo 'selected'; ?>>
                En cours
            </option>

            <option value="Terminée"
                <?php if ($planification['statut'] == 'Terminée') echo 'selected'; ?>>
                Terminée
            </option>

            <option value="Annulée"
                <?php if ($planification['statut'] == 'Annulée') echo 'selected'; ?>>
                Annulée
            </option>

        </select>

        <br><br>

        <button type="submit">
            💾 Enregistrer les modifications
        </button>

        <a href="index.php">
            <button type="button">
                ⬅️ Retour
            </button>
        </a>

    </form>

</div>

<?php include("../includes/footer.php"); ?>