<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/auth.php");

$id = $_GET['id'];

$sql = "SELECT * FROM intervention WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['modifier'])) {

    $localisation = $_POST['localisation'];
    $telephone = $_POST['telephone'];
    $etat = $_POST['etat'];

    $sql = "UPDATE intervention
            SET
            localisation='$localisation',
            telephone='$telephone',
            etat='$etat'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}
?>

<div class="content">

<h1>Modifier une intervention</h1>

<form method="POST">

    <label>Localisation</label><br>
    <input type="text" name="localisation"
           value="<?php echo $row['localisation']; ?>"><br><br>

    <label>Téléphone</label><br>
    <input type="text" name="telephone"
           value="<?php echo $row['telephone']; ?>"><br><br>

    <label>État</label><br>

    <select name="etat">
        <option value="En attente" <?php if($row['etat']=="En attente") echo "selected"; ?>>En attente</option>
        <option value="En cours" <?php if($row['etat']=="En cours") echo "selected"; ?>>En cours</option>
        <option value="Terminée" <?php if($row['etat']=="Terminée") echo "selected"; ?>>Terminée</option>
    </select>

    <br><br>

    <button type="submit" name="modifier">
        💾 Enregistrer les modifications
    </button>

</form>

</div>

<?php include("../includes/footer.php"); ?>