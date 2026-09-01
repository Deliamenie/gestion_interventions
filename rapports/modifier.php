<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM rapports WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    $rapport = mysqli_fetch_assoc($result);
}

if (isset($_POST['modifier'])) {

    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $date_rapport = $_POST['date_rapport'];
    $auteur = $_POST['auteur'];
    $contenu = $_POST['contenu'];

    $sql = "UPDATE rapports SET
            titre = '$titre',
            date_rapport = '$date_rapport',
            auteur = '$auteur',
            contenu = '$contenu'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Rapport modifié avec succès');
                window.location='index.php';
              </script>";

    } else {

        echo "Erreur : " . mysqli_error($conn);
    }
}
?>

<div class="content">

    <h1>MODIFIER LE RAPPORT</h1>

    <form method="POST">

        <input type="hidden"
               name="id"
               value="<?php echo $rapport['id']; ?>">

        <label>Titre du rapport</label><br>

        <input type="text"
               name="titre"
               value="<?php echo $rapport['titre']; ?>"
               required>

        <br><br>

        <label>Date</label><br>

        <input type="date"
               name="date_rapport"
               value="<?php echo $rapport['date_rapport']; ?>"
               required>

        <br><br>

        <label>Auteur</label><br>

        <input type="text"
               name="auteur"
               value="<?php echo $rapport['auteur']; ?>"
               required>

        <br><br>

        <label>Contenu du rapport</label><br>

        <textarea name="contenu"
                  rows="10"
                  cols="60"
                  required><?php echo $rapport['contenu']; ?></textarea>

        <br><br>

        <button type="submit" name="modifier">
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