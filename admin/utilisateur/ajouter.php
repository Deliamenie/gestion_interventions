<?php

include("../../includes/auth.php");
include("../../admin/auth_admin.php");
include("../../config/db.php");
include("../../includes/header.php");
include("../../includes/sidebar.php");

if (isset($_POST['enregistrer'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "INSERT INTO users (name, username, password, role)
            VALUES ('$name', '$username', '$password', '$role')";

    if (mysqli_query($conn, $sql)) {

        header("Location: index.php");
        exit();

    } else {

        echo "Erreur : " . mysqli_error($conn);
    }
}

?>

<div class="content">

    <h1>Ajouter un utilisateur</h1>

    <form method="POST">

        <label>Nom</label><br>

        <input
            type="text"
            name="name"
            required
        >

        <br><br>

        <label>Username</label><br>

        <input
            type="text"
            name="username"
            required
        >

        <br><br>

        <label>Mot de passe</label><br>

        <input
            type="password"
            name="password"
            required
        >

        <br><br>

        <label>Rôle</label><br>

        <select name="role" required>

            <option value="admin">
                Administrateur
            </option>

            <option value="responsable">
                Responsable
            </option>

            <option value="technicien">
                Technicien
            </option>

        </select>

        <br><br>

        <button type="submit" name="enregistrer">
            Enregistrer
        </button>

        <a href="index.php">
            Annuler
        </a>

    </form>

</div>

<?php

include("../../includes/footer.php");

?>