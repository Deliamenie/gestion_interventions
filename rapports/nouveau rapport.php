<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");

if (isset($_POST['enregistrer'])) {

    $titre = $_POST['titre'];
    $date_rapport = $_POST['date_rapport'];
    $auteur = $_POST['auteur'];
    $contenu = $_POST['contenu'];

    // Gestion de la photo
    $photo = "";

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

        $nom_photo = $_FILES['photo']['name'];
        $tmp_photo = $_FILES['photo']['tmp_name'];

        $extension = pathinfo($nom_photo, PATHINFO_EXTENSION);

        $nouveau_nom = time() . "_" . uniqid() . "." . $extension;

        $dossier = "../uploads/";

        if (!is_dir($dossier)) {
            mkdir($dossier, 0777, true);
        }

        move_uploaded_file($tmp_photo, $dossier . $nouveau_nom);

        $photo = $nouveau_nom;
    }

    $sql = "INSERT INTO rapports (titre, date_rapport, auteur, contenu, photo)
            VALUES ('$titre', '$date_rapport', '$auteur', '$contenu', '$photo')";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Rapport enregistré avec succès');
                window.location='index.php';
              </script>";

    } else {

        echo "Erreur : " . mysqli_error($conn);
    }
}
?>

<div class="content">

    <h1>NOUVEAU RAPPORT</h1>

    <form method="POST" enctype="multipart/form-data">

        <label>Titre du rapport</label><br>

        <input type="text"
               name="titre"
               required>

        <br><br>

        <label>Date</label><br>

        <input type="date"
               name="date_rapport"
               required>

        <br><br>

        <label>Auteur</label><br>

        <input type="text"
               name="auteur"
               required>

        <br><br>

        <label>Contenu du rapport</label><br>

        <textarea name="contenu"
                  rows="10"
                  cols="60"
                  required></textarea>

        <br><br>

        <label>Photo du rapport</label><br>

        <input type="file"
               name="photo"
               accept="image/*">

        <br><br>

        <button type="submit" name="enregistrer">
            💾 Enregistrer
        </button>

        <a href="index.php">
            <button type="button">❌ Annuler</button>
        </a>

    </form>

</div>

<?php
include("../includes/footer.php");
?>