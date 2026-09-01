<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM techniciens WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $technicien = mysqli_fetch_assoc($result);
}

if (isset($_POST['modifier'])) {

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $telephone = $_POST['telephone'];
    $specialisation = $_POST['specialisation'];

    $sql = "UPDATE techniciens SET 
            nom = '$nom',
            telephone = '$telephone',
            specialisation = '$specialisation'
            WHERE id = $id";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit();
}
?>

<div class="content">

    <h2>Modifier le technicien</h2>

   
<!DOCTYPE html>
<html>
<head>
    <title>Modifier un technicien</title>
</head>

<body>



<form method="POST">

    <input type="hidden" name="id" value="<?php echo $technicien['id']; ?>">

    <label>Nom :</label>
    <input type="text" name="nom" value="<?php echo $technicien['nom']; ?>">
    <br><br>

    <label>Téléphone :</label>
    <input type="text" name="telephone" value="<?php echo $technicien['telephone']; ?>">
    <br><br>

    <label>Spécialisation :</label>
    <input type="text" name="specialisation" value="<?php echo $technicien['specialisation']; ?>">
    <br><br>
 <button type="submit" name="modifier">
        💾 Enregistrer les modifications
    </button>
</form>

</body>
</html>

</div>
<?php
include("../includes/footer.php");
?>
