<?php
include("../config/db.php");

if (isset($_POST['date'])) {

    $date = $_POST['date'];
    $heure_arrivee = $_POST['heure_arrivee'];
    $heure_depart = $_POST['heure_depart'];
    $responsable_intervention = $_POST['responsable_intervention'];
    $ticket_id = $_POST['ticket_id'];
    $client_id = $_POST['client_id'];
    $localisation = $_POST['localisation'];
    $telephone = $_POST['telephone'];
    $sous_contrat_maintenance = $_POST['sous_contrat_maintenance'] ?? '';
    $equipement_proteges = $_POST['equipement_proteges'];
    $classe_service = $_POST['classe_service'] ?? '';
    $debit_souscrit = $_POST['debit_souscrit'] ?? '';
    $panne_signalee = $_POST['panne_signalee'];
    $autres = $_POST['autres'];

    if (isset($_POST['nature_panne'])) {
        $nature_panne = implode(", ", $_POST['nature_panne']);
    } else {
        $nature_panne = "";
    }

    $details_prestations = $_POST['details_prestations'];
    $performance_bst = $_POST['performance_bst'];
    $performance_passerelle = $_POST['performance_passerelle'];
    $performance_8888 = $_POST['performance_8888'];
    $performance_interco = $_POST['performance_interco'];
    $qualite_service = $_POST['qualite_service'] ?? '';
    $note_sur_10 = $_POST['note_sur_10'];
    $commentaire = $_POST['commentaire'];
    $etat = $_POST['etat'] ?? '';

    /* NOMS ET FONCTIONS */
    $nom_fonction_matrix_telecoms = $_POST['nom_fonction_matrix_telecoms'];
    $nom_fonction_client = $_POST['nom_fonction_client'];

    /* SIGNATURES */
    $signature_matrix_telecoms = $_POST['signature_matrix_telecoms'] ?? '';
    $signature_client = $_POST['signature_client'] ?? '';

    /* INSERTION */
    $sql = "INSERT INTO intervention (
        date,
        heure_arrivee,
        heure_depart,
        responsable_intervention,
        ticket_id,
        client_id,
        localisation,
        telephone,
        sous_contrat_maintenance,
        equipement_proteges,
        classe_service,
        debit_souscrit,
        panne_signalee,
        autres,
        nature_panne,
        details_prestations,
        performance_bst,
        performance_passerelle,
        performance_8888,
        performance_interco,
        qualite_service,
        note_sur_10,
        commentaire,
        etat,
        signature_matrix_telecoms,
        signature_client,
        nom_fonction_matrix_telecoms,
        nom_fonction_client
    ) VALUES (
        '$date',
        '$heure_arrivee',
        '$heure_depart',
        '$responsable_intervention',
        '$ticket_id',
        '$client_id',
        '$localisation',
        '$telephone',
        '$sous_contrat_maintenance',
        '$equipement_proteges',
        '$classe_service',
        '$debit_souscrit',
        '$panne_signalee',
        '$autres',
        '$nature_panne',
        '$details_prestations',
        '$performance_bst',
        '$performance_passerelle',
        '$performance_8888',
        '$performance_interco',
        '$qualite_service',
        '$note_sur_10',
        '$commentaire',
        '$etat',
        '$signature_matrix_telecoms',
        '$signature_client',
        '$nom_fonction_matrix_telecoms',
        '$nom_fonction_client'
    )";

    if (mysqli_query($conn, $sql)) {

        header("Location: index.php");
        exit();

    } else {

        die(mysqli_error($conn));
    }
}

include("../includes/header.php");
include("../includes/sidebar.php");
?>

<div class="content">

<h1>NOUVELLE INTERVENTION</h1>

<form action="" method="POST">

<!-- INFORMATIONS SUR L'INTERVENTION -->

<h2>Informations sur l'intervention</h2>

<div class="form-row">

    <div>
        <label>Date</label>
        <input type="date" name="date" required>
    </div>

    <div>
        <label>Heure d'arrivée</label>
        <input type="time" name="heure_arrivee" required>
    </div>

    <div>
        <label>Heure de départ</label>
        <input type="time" name="heure_depart" required>
    </div>

</div>

<label>Responsable de l'intervention</label>
<input type="text" name="responsable_intervention" required>


<!-- INFORMATIONS GÉNÉRALES -->

<h2>Informations générales</h2>

<div class="form-row">

    <div>
        <label>Ticket ID</label>
        <input type="text" name="ticket_id" required>
    </div>

    <div>
        <label>Client ID</label>
        <input type="text" name="client_id" required>
    </div>

</div>

<label>Localisation</label>
<input type="text" name="localisation">

<label>Téléphone</label>
<input type="text" name="telephone">


<!-- CONTRAT -->

<h2>Sous contrat de maintenance</h2>

<div class="checkbox-group">

    <label>
        <input type="radio"
               name="sous_contrat_maintenance"
               value="Oui">
        Oui
    </label>

    <label>
        <input type="radio"
               name="sous_contrat_maintenance"
               value="Non">
        Non
    </label>

</div>


<label>Équipements protégés</label>

<input type="text" name="equipement_proteges">


<!-- CLASSE DE SERVICE -->

<h2>Classe de service</h2>

<div class="checkbox-group">

    <label>
        <input type="radio"
               name="classe_service"
               value="Corporate">
        Corporate
    </label>

    <label>
        <input type="radio"
               name="classe_service"
               value="Matrix Pro">
        Matrix Pro
    </label>

    <label>
        <input type="radio"
               name="classe_service"
               value="Matrix Home">
        Matrix Home
    </label>

    <label>
        <input type="radio"
               name="classe_service"
               value="Matrix Flotte">
        Matrix Flotte
    </label>

</div>


<!-- DEBIT -->

<h2>Débit souscrit</h2>

<div class="checkbox-group">

    <label>
        <input type="radio"
               name="debit_souscrit"
               value="256 Kb">
        256 Kb
    </label>

    <label>
        <input type="radio"
               name="debit_souscrit"
               value="512 Kb">
        512 Kb
    </label>

    <label>
        <input type="radio"
               name="debit_souscrit"
               value="1024 Kb">
        1024 Kb
    </label>

    <label>
        <input type="radio"
               name="debit_souscrit"
               value="2048 Kb">
        2048 Kb
    </label>

</div>


<!-- PANNE -->

<h2>Panne signalée</h2>

<textarea name="panne_signalee" rows="5"></textarea>


<h2>Nature de la panne</h2>

<div class="checkbox-group">

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="Energie">
        Énergie
    </label>

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="RF">
        RF
    </label>

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="LAN">
        LAN
    </label>

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="Materiel">
        Matériel
    </label>

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="Routeur">
        Routeur
    </label>

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="PoE">
        PoE
    </label>

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="Alimentation">
        Alimentation
    </label>

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="Network">
        Network
    </label>

    <label>
        <input type="checkbox"
               name="nature_panne[]"
               value="POP">
        POP
    </label>

</div>


<label>Autres</label>

<input type="text" name="autres">


<!-- DETAILS -->

<h2>Détails des prestations</h2>

<textarea name="details_prestations"
          rows="8"></textarea>


<!-- PERFORMANCES -->

<h2>Performances obtenues</h2>

<table>

<tr>
    <th>Paramètre</th>
    <th>SLA normal</th>
    <th>Performance obtenue</th>
</tr>

<tr>
    <td>Latence Client → BST</td>
    <td>1-10 ms</td>
    <td>
        <input type="text"
               name="performance_bst">
    </td>
</tr>

<tr>
    <td>Latence Client → Passerelle</td>
    <td>1-10 ms</td>
    <td>
        <input type="text"
               name="performance_passerelle">
    </td>
</tr>

<tr>
    <td>Latence Client → 8.8.8.8</td>
    <td>90-150 ms</td>
    <td>
        <input type="text"
               name="performance_8888">
    </td>
</tr>

<tr>
    <td>Latence Interco</td>
    <td>20-150 ms</td>
    <td>
        <input type="text"
               name="performance_interco">
    </td>
</tr>

</table>


<!-- QUALITE -->

<h2>Appréciation de la qualité de service</h2>

<div class="checkbox-group">

    <label>
        <input type="radio"
               name="qualite_service"
               value="Excellente">
        Excellente
    </label>

    <label>
        <input type="radio"
               name="qualite_service"
               value="Bonne">
        Bonne
    </label>

    <label>
        <input type="radio"
               name="qualite_service"
               value="Assez bien">
        Assez bien
    </label>

    <label>
        <input type="radio"
               name="qualite_service"
               value="Mauvaise">
        Mauvaise
    </label>

</div>


<!-- EVALUATION -->

<h2>Évaluation de la prestation</h2>

<label>Note sur 10</label>

<input type="number"
       name="note_sur_10"
       min="1"
       max="10">


<label>Commentaire</label>

<textarea name="commentaire"
          rows="5"></textarea>


<!-- ETAT -->

<h2>État de l'intervention</h2>

<div class="checkbox-group">

    <label>
        <input type="radio"
               name="etat"
               value="En attente">
        🔴 En attente
    </label>

    <label>
        <input type="radio"
               name="etat"
               value="En cours">
        🟠 En cours
    </label>

    <label>
        <input type="radio"
               name="etat"
               value="Terminée">
        🟢 Terminée
    </label>

</div>


<!-- SIGNATURES -->

<h2>Signatures</h2>

<div class="signature-section">


<!-- MATRIX TELECOMS -->

<div class="signature-box">

    <label>
        Nom et fonction - Matrix Telecoms
    </label>

    <input type="text"
           name="nom_fonction_matrix_telecoms">

    <br><br>

    <label>
        Signature - Matrix Telecoms
    </label>

    <br>

    <canvas id="canvas_matrix_telecoms"
            width="300"
            height="100"
            style="border:1px solid #000; touch-action:none;">
    </canvas>

    <br>

    <button type="button"
            onclick="effacerSignature('canvas_matrix_telecoms')">

        Effacer

    </button>

    <input type="hidden"
           name="signature_matrix_telecoms"
           id="signature_matrix_telecoms">

</div>


<!-- CLIENT -->

<div class="signature-box">

    <label>
        Nom et fonction - Client
    </label>

    <input type="text"
           name="nom_fonction_client">

    <br><br>

    <label>
        Signature - Client
    </label>

    <br>

    <canvas id="canvas_client"
            width="300"
            height="100"
            style="border:1px solid #000; touch-action:none;">
    </canvas>

    <br>

    <button type="button"
            onclick="effacerSignature('canvas_client')">

        Effacer

    </button>

    <input type="hidden"
           name="signature_client"
           id="signature_client">

</div>

</div>


<!-- JAVASCRIPT SIGNATURE -->

<script>

function activerSignature(canvasId, inputId) {

    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");

    let dessin = false;

    ctx.lineWidth = 2;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";


    function positionSouris(e) {

        const rect = canvas.getBoundingClientRect();

        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };

    }


    /* SOURIS */

    canvas.addEventListener("mousedown", function(e) {

        dessin = true;

        const pos = positionSouris(e);

        ctx.beginPath();

        ctx.moveTo(pos.x, pos.y);

    });


    canvas.addEventListener("mousemove", function(e) {

        if (!dessin) return;

        const pos = positionSouris(e);

        ctx.lineTo(pos.x, pos.y);

        ctx.stroke();

    });


    canvas.addEventListener("mouseup", function() {

        dessin = false;

        sauvegarderSignature(canvasId, inputId);

    });


    canvas.addEventListener("mouseleave", function() {

        dessin = false;

    });


    /* TELEPHONE */

    canvas.addEventListener("touchstart", function(e) {

        e.preventDefault();

        dessin = true;

        const rect = canvas.getBoundingClientRect();

        const touch = e.touches[0];

        ctx.beginPath();

        ctx.moveTo(
            touch.clientX - rect.left,
            touch.clientY - rect.top
        );

    });


    canvas.addEventListener("touchmove", function(e) {

        e.preventDefault();

        if (!dessin) return;

        const rect = canvas.getBoundingClientRect();

        const touch = e.touches[0];

        ctx.lineTo(
            touch.clientX - rect.left,
            touch.clientY - rect.top
        );

        ctx.stroke();

    });


    canvas.addEventListener("touchend", function(e) {

        e.preventDefault();

        dessin = false;

        sauvegarderSignature(canvasId, inputId);

    });

}


function sauvegarderSignature(canvasId, inputId) {

    const canvas = document.getElementById(canvasId);

    const input = document.getElementById(inputId);

    input.value = canvas.toDataURL("image/png");

}


function effacerSignature(canvasId) {

    const canvas = document.getElementById(canvasId);

    const ctx = canvas.getContext("2d");

    ctx.clearRect(
        0,
        0,
        canvas.width,
        canvas.height
    );


    if (canvasId === "canvas_matrix_telecoms") {

        document.getElementById(
            "signature_matrix_telecoms"
        ).value = "";

    }


    if (canvasId === "canvas_client") {

        document.getElementById(
            "signature_client"
        ).value = "";

    }

}


/* ACTIVATION */

activerSignature(
    "canvas_matrix_telecoms",
    "signature_matrix_telecoms"
);

activerSignature(
    "canvas_client",
    "signature_client"
);

</script>


<!-- BOUTONS -->

<div class="buttons">

    <button type="submit">
        💾 Enregistrer
    </button>

    <button type="reset">
        ❌ Annuler
    </button>

</div>

</form>

</div>


<?php
include("../includes/footer.php");
?>