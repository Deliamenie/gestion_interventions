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

?>

<div class="content">

    <h1>📋 DÉTAILS DE LA PLANIFICATION</h1>

    <br>

    <div style="
        max-width: 800px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fff;
    ">

        <p>
            <strong>📅 Date :</strong>
            <?php echo htmlspecialchars($planification['date_planification']); ?>
        </p>

        <p>
            <strong>⏰ Heure :</strong>
            <?php echo htmlspecialchars($planification['heure_planification']); ?>
        </p>

        <p>
            <strong>👤 Client :</strong>
            <?php echo htmlspecialchars($planification['client']); ?>
        </p>

        <p>
            <strong>👨‍🔧 Technicien :</strong>
            <?php echo htmlspecialchars($planification['technicien']); ?>
        </p>

        <hr>

        <h3>📝 Description</h3>

        <div style="
            padding: 15px;
            line-height: 1.6;
            overflow-wrap: break-word;
            word-wrap: break-word;
        ">

            <?php
            echo nl2br(
                htmlspecialchars(
                    $planification['description']
                )
            );
            ?>

        </div>

        <hr>

        <p>
            <strong>📌 Statut :</strong>
            <?php echo htmlspecialchars($planification['statut']); ?>
        </p>

    </div>

    <br>

    <a href="modifier.php?id=<?php echo $planification['id']; ?>">
        <button type="button">
            ✏️ Modifier
        </button>
    </a>

    <a href="index.php">
        <button type="button">
            ⬅️ Retour
        </button>
    </a>

</div>

<?php

include("../includes/footer.php");

?>