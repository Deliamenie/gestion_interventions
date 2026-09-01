<?php
include("../config/db.php");

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM clients WHERE client_id='$id'";

    if (mysqli_query($conn, $sql)) {

        header("Location: index.php");
        exit();

    } else {

        echo "Erreur : " . mysqli_error($conn);

    }

} else {

    echo "ID introuvable.";

}
?>