<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");

$rapport = null;

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    $sql = "SELECT * FROM rapports WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $rapport = mysqli_fetch_assoc($result);
    }
}

?>

<div class="content">

    <h1>DÉTAILS DU RAPPORT</h1>

    <?php if ($rapport) { ?>

        <p>
            <strong>Titre :</strong>
            <?php echo htmlspecialchars($rapport['titre']); ?>
        </p>

        <p>
            <strong>Date :</strong>
            <?php echo htmlspecialchars($rapport['date_rapport']); ?>
        </p>

        <p>
            <strong>Auteur :</strong>
            <?php echo htmlspecialchars($rapport['auteur']); ?>
        </p>

        <hr>

        <h3>Contenu du rapport</h3>

        <div style="
            display: block;
            width: 100%;
            max-width: 900px;
            box-sizing: border-box;
            white-space: normal !important;
            overflow-wrap: break-word !important;
            word-break: break-all !important;
            font-size: 16px;
            line-height: 1.7;
        ">

            <?php echo nl2br(htmlspecialchars($rapport['contenu'])); ?>

        </div>


        <?php if (!empty($rapport['photo'])) { ?>

            <hr>

            <h3>Photo</h3>

            <img
                src="../uploads/<?php echo htmlspecialchars($rapport['photo']); ?>"
                alt="Photo du rapport"
                width="400"
            >

        <?php } ?>


        <br><br>


        <!-- =========================
             BOUTON PDF
        ========================= -->

        <a
            href="pdf.php?id=<?php echo $rapport['id']; ?>"
            target="_blank"
        >

            <button type="button">
                📄 Télécharger en PDF
            </button>

        </a>


        


        <!-- =========================
             RETOUR
        ========================= -->

        <a href="index.php">

            <button type="button">
                ⬅️ Retour
            </button>

        </a>



    <?php } else { ?>


        <p>
            Rapport introuvable.
        </p>


        <a href="index.php">

            <button type="button">
                ⬅️ Retour
            </button>

        </a>


    <?php } ?>

</div>


<?php

include("../includes/footer.php");

?>