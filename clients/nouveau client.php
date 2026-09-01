<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");


if (isset($_POST['nom_client'])) {

    $nom_client = $_POST['nom_client'];
    $localisation = $_POST['localisation'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];

    $sql = "INSERT INTO clients (nom_client, localisation, telephone, email)
            VALUES ('$nom_client', '$localisation', '$telephone', '$email')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Client enregistré avec succès');</script>";
    } else {
        echo "<script>alert('Erreur : " . mysqli_error($conn) . "');</script>";
    }
}
?>
<div class="content"> 

    <h1>NOUVEAU CLIENT</h1>

    <form action="" method="POST">

        <table class="form-table">

            <tr>
                <td><label>Nom du client</label></td>
                <td>
                    <input type="text" name="nom_client" required>
                </td>
            </tr>

            <tr>
                <td><label>Localisation</label></td>
                <td>
                    <input type="text" name="localisation" required>
                </td>
            </tr>

            <tr>
                <td><label>Téléphone</label></td>
                <td>
                    <input type="text" name="telephone" required>
                </td>
            </tr>

            <tr>
                <td><label>Email</label></td>
                <td>
                    <input type="email" name="email">
                </td>
            </tr>

        </table>

        <br>

        <button type="submit">💾 Enregistrer</button>
        <button type="reset">❌ Annuler</button>

    </form>

</div>

<?php
include("../includes/footer.php");
?>