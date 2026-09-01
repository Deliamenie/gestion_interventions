<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");

if (isset($_POST['enregistrer'])) {

    $nom = $_POST['nom'];
    $telephone = $_POST['telephone'];
    $specialisation = $_POST['specialisation'];

    $sql = "INSERT INTO techniciens (nom, telephone, specialisation)
            VALUES ('$nom', '$telephone', '$specialisation')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>
                alert('Technicien enregistré avec succès');
                window.location='index.php';
              </script>";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}
?>

<div class="content">

    <h1>NOUVEAU TECHNICIEN</h1>

    <form action="" method="POST">

        <table class="form-table">

            <tr>
                <td>Nom du technicien</td>
                <td>
                    <input type="text" name="nom" required>
                </td>
            </tr>

            <tr>
                <td>Téléphone</td>
                <td>
                    <input type="text" name="telephone" required>
                </td>
            </tr>

            <tr>
                <td>Spécialisation</td>
                <td>
                    <input type="text" name="specialisation" required>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <button type="submit" name="enregistrer">💾 Enregistrer</button>
                    <button type="reset">❌ Annuler</button>
                </td>
            </tr>

        </table>

    </form>

</div>

<?php
include("../includes/footer.php");
?>