<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");


if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM clients WHERE client_id = $id";
    $result = mysqli_query($conn, $sql);

    $client = mysqli_fetch_assoc($result);
}

if (isset($_POST['modifier'])) {

    $id = $_POST['client_id'];
    $nom = $_POST['nom_client'];
    $localisation = $_POST['localisation'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];

    $sql = "UPDATE clients SET
            nom_client = '$nom',
            localisation = '$localisation',
            telephone = '$telephone',
            email = '$email'
            WHERE client_id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}
?>

<div class="content">

    <h1>MODIFIER LE CLIENT</h1>

    <form method="POST">

        <input type="hidden" name="client_id"
               value="<?php echo $client['client_id']; ?>">

        <label>Nom du client</label>
        <input type="text" name="nom_client"
               value="<?php echo $client['nom_client']; ?>" required>

        <br><br>

        <label>Localisation</label>
        <input type="text" name="localisation"
               value="<?php echo $client['localisation']; ?>" required>

        <br><br>

        <label>Téléphone</label>
        <input type="text" name="telephone"
               value="<?php echo $client['telephone']; ?>" required>

        <br><br>

        <label>Email</label>
        <input type="email" name="email"
               value="<?php echo $client['email']; ?>" required>

        <br><br>

        <button type="submit" name="modifier">💾 Enregistrer</button>

        <a href="index.php">
            <button type="button">❌ Annuler</button>
        </a>

    </form>

</div>

<?php
include("../includes/footer.php");
?>