<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/auth.php");

if (!isset($_GET['id'])) {
    die("ID de l'intervention manquant.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM intervention WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Intervention introuvable.");
}

$row = mysqli_fetch_assoc($result);
?>

<div class="content">

    <!-- LOGO + TITRE -->

    <div style="
        text-align:center;
        margin-bottom:25px;
    ">

        <img src="../assets/images/logo.png"
             alt="Logo Matrix Telecoms"
             style="
                width:150px;
                max-height:80px;
                object-fit:contain;
             ">

        <h1 style="margin-top:15px;">
            FICHE D'INTERVENTION
        </h1>

    </div>


    <!-- INFORMATIONS SUR L'INTERVENTION -->

    <h2>Informations sur l'intervention</h2>

    <table border="1"
           cellpadding="10"
           cellspacing="0"
           width="100%">

        <tr>

            <th>Date</th>

            <td>
                <?php echo htmlspecialchars($row['date']); ?>
            </td>

            <th>Heure d'arrivée</th>

            <td>
                <?php echo htmlspecialchars($row['heure_arrivee']); ?>
            </td>

            <th>Heure de départ</th>

            <td>
                <?php echo htmlspecialchars($row['heure_depart']); ?>
            </td>

        </tr>

        <tr>

            <th>Responsable de l'intervention</th>

            <td colspan="5">
                <?php
                echo htmlspecialchars(
                    $row['responsable_intervention']
                );
                ?>
            </td>

        </tr>

    </table>


    <!-- INFORMATIONS GÉNÉRALES -->

    <h2>Informations générales</h2>

    <table border="1"
           cellpadding="10"
           cellspacing="0"
           width="100%">

        <tr>

            <th>Ticket ID</th>

            <td>
                <?php echo htmlspecialchars($row['ticket_id']); ?>
            </td>

            <th>Client ID</th>

            <td>
                <?php echo htmlspecialchars($row['client_id']); ?>
            </td>

        </tr>

        <tr>

            <th>Localisation</th>

            <td>
                <?php echo htmlspecialchars($row['localisation']); ?>
            </td>

            <th>Téléphone</th>

            <td>
                <?php echo htmlspecialchars($row['telephone']); ?>
            </td>

        </tr>

    </table>


    <!-- CONTRAT -->

    <h2>Sous contrat de maintenance</h2>

    <div class="details-box">
        <?php
        echo htmlspecialchars(
            $row['sous_contrat_maintenance']
        );
        ?>
    </div>


    <!-- ÉQUIPEMENTS -->

    <h2>Équipements protégés</h2>

    <div class="details-box">
        <?php
        echo nl2br(
            htmlspecialchars(
                $row['equipement_proteges']
            )
        );
        ?>
    </div>


    <!-- CLASSE DE SERVICE -->

    <h2>Classe de service</h2>

    <div class="details-box">
        <?php
        echo htmlspecialchars(
            $row['classe_service']
        );
        ?>
    </div>


    <!-- DÉBIT -->

    <h2>Débit souscrit</h2>

    <div class="details-box">
        <?php
        echo htmlspecialchars(
            $row['debit_souscrit']
        );
        ?>
    </div>


    <!-- PANNE -->

    <h2>Panne signalée</h2>

    <div class="details-box">

        <?php
        echo nl2br(
            htmlspecialchars(
                $row['panne_signalee']
            )
        );
        ?>

    </div>


    <!-- NATURE DE LA PANNE -->

    <h2>Nature de la panne</h2>

    <div class="details-box">

        <?php
        echo htmlspecialchars(
            $row['nature_panne']
        );
        ?>

    </div>


    <!-- AUTRES -->

    <h2>Autres</h2>

    <div class="details-box">

        <?php
        echo nl2br(
            htmlspecialchars(
                $row['autres']
            )
        );
        ?>

    </div>


    <!-- DÉTAILS DES PRESTATIONS -->

    <h2>Détails des prestations</h2>

    <div class="details-box"
         style="
            min-height:100px;
            white-space:normal;
         ">

        <?php
        echo nl2br(
            htmlspecialchars(
                $row['details_prestations']
            )
        );
        ?>

    </div>


    <!-- PERFORMANCES -->

    <h2>PERFORMANCES OBTENUES</h2>

    <table border="1"
           cellpadding="10"
           cellspacing="0"
           width="100%">

        <tr>

            <th>Paramètre</th>

            <th>SLA normal</th>

            <th>Performance obtenue</th>

        </tr>

        <tr>

            <td>
                Latence Client → BST
            </td>

            <td>
                 1-10 ms
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $row['performance_bst']
                );
                ?>
            </td>

        </tr>

        <tr>

            <td>
                Latence Client → Passerelle
            </td>

            <td>
               1-10 ms
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $row['performance_passerelle']
                );
                ?>
            </td>

        </tr>

        <tr>

            <td>
                Latence Client → 8.8.8.8
            </td>

            <td>
                90-150ms
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $row['performance_8888']
                );
                ?>
            </td>

        </tr>

        <tr>

            <td>
                Latence Interco
            </td>

            <td>
               20-150 ms
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $row['performance_interco']
                );
                ?>
            </td>

        </tr>

    </table>


    <!-- QUALITÉ -->

    <h2>Appréciation de la qualité de service</h2>

    <div class="details-box">

        <?php
        echo htmlspecialchars(
            $row['qualite_service']
        );
        ?>

    </div>


    <!-- ÉVALUATION -->

    <h2>Évaluation de la prestation</h2>

    <table border="1"
           cellpadding="10"
           cellspacing="0"
           width="100%">

        <tr>

            <th>Note sur 10</th>

            <td>
                <?php
                echo htmlspecialchars(
                    $row['note_sur_10']
                );
                ?>
                /10
            </td>

        </tr>

        <tr>

            <th>Commentaire</th>

            <td>

                <?php
                echo nl2br(
                    htmlspecialchars(
                        $row['commentaire']
                    )
                );
                ?>

            </td>

        </tr>

    </table>


    <!-- ÉTAT -->

    <h2>État de l'intervention</h2>

    <div class="details-box">

        <?php

        if ($row['etat'] == "En attente") {

            echo "🔴 En attente";

        } elseif ($row['etat'] == "En cours") {

            echo "🟠 En cours";

        } elseif ($row['etat'] == "Terminée") {

            echo "🟢 Terminée";

        } else {

            echo htmlspecialchars($row['etat']);

        }

        ?>

    </div>


    <!-- SIGNATURES -->

    <h2>Signatures</h2>

    <div class="signature-section"
         style="
            display:flex;
            gap:30px;
            flex-wrap:wrap;
         ">


        <!-- MATRIX TELECOMS -->

        <div class="signature-box"
             style="flex:1; min-width:300px;">

            <h3>Matrix Telecoms</h3>

            <p>

                <strong>
                    Nom et fonction :
                </strong>

                <br>

                <?php
                echo htmlspecialchars(
                    $row['nom_fonction_matrix_telecoms']
                );
                ?>

            </p>

            <p>
                <strong>Signature :</strong>
            </p>

            <?php

            if (!empty($row['signature_matrix_telecoms'])) {

                echo '<img src="' .
                    htmlspecialchars(
                        $row['signature_matrix_telecoms']
                    ) .
                    '"
                    alt="Signature Matrix Telecoms"
                    style="
                        width:300px;
                        height:100px;
                        object-fit:contain;
                        border:1px solid #ccc;
                    ">';

            } else {

                echo "<p>Aucune signature enregistrée.</p>";

            }

            ?>

        </div>


        <!-- CLIENT -->

        <div class="signature-box"
             style="flex:1; min-width:300px;">

            <h3>Client</h3>

            <p>

                <strong>
                    Nom et fonction :
                </strong>

                <br>

                <?php
                echo htmlspecialchars(
                    $row['nom_fonction_client']
                );
                ?>

            </p>

            <p>
                <strong>Signature :</strong>
            </p>

            <?php

            if (!empty($row['signature_client'])) {

                echo '<img src="' .
                    htmlspecialchars(
                        $row['signature_client']
                    ) .
                    '"
                    alt="Signature Client"
                    style="
                        width:300px;
                        height:100px;
                        object-fit:contain;
                        border:1px solid #ccc;
                    ">';

            } else {

                echo "<p>Aucune signature enregistrée.</p>";

            }

            ?>

        </div>

    </div>


    <br><br>


    <!-- BOUTONS -->

    <div class="buttons">

        <a href="index.php">
            <button type="button">
                ⬅ Retour
            </button>
        </a>

        <a href="pdf.php?id=<?php echo $row['id']; ?>"
           target="_blank">

            <button type="button">
                📄 Enregistrer en PDF
            </button>

        </a>

    </div>

</div>


<?php
include("../includes/footer.php");
?>