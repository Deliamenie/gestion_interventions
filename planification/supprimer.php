<?php

include("../config/db.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

$sql = "DELETE FROM planifications WHERE id = $id";

mysqli_query($conn, $sql);

header("Location: index.php");
exit;

?>