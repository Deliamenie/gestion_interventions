<?php

include("../../includes/auth.php");
include("../../admin/auth_admin.php");
include("../../config/db.php");
include("../../includes/header.php");
include("../../includes/sidebar.php");


/* =====================================================
   VÉRIFIER L'ID
===================================================== */

if (!isset($_GET['id']) || empty($_GET['id'])) {

    header("Location: index.php");
    exit();

}

$id = intval($_GET['id']);


/* =====================================================
   RÉCUPÉRER L'UTILISATEUR
===================================================== */

$sql = "SELECT * FROM users WHERE id = $id";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {

    echo "Utilisateur introuvable.";
    exit();

}

$user = mysqli_fetch_assoc($result);


/* =====================================================
   MODIFICATION
===================================================== */

if (isset($_POST['modifier'])) {

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['name']
    );

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $role = mysqli_real_escape_string(
        $conn,
        $_POST['role']
    );


    $sql_update = "UPDATE users

                   SET name = '$name',
                       username = '$username',
                       role = '$role'

                   WHERE id = $id";


    if (mysqli_query($conn, $sql_update)) {

        header("Location: index.php");
        exit();

    } else {

        echo "Erreur : " . mysqli_error($conn);

    }

}

?>

<div class="content">

    <h1>Modifier un utilisateur</h1>


    <form method="POST">


        <!-- NOM -->

        <label>Nom</label><br>

        <input
            type="text"
            name="name"
            value="<?php echo htmlspecialchars($user['name']); ?>"
            required
        >


        <br><br>


        <!-- USERNAME -->

        <label>Username</label><br>

        <input
            type="text"
            name="username"
            value="<?php echo htmlspecialchars($user['username']); ?>"
            required
        >


        <br><br>


        <!-- RÔLE -->

        <label>Rôle</label><br>

        <select name="role" required>


            <option
                value="admin"
                <?php
                if ($user['role'] == 'admin') {
                    echo 'selected';
                }
                ?>
            >
                Administrateur
            </option>


            <option
                value="responsable"
                <?php
                if ($user['role'] == 'responsable') {
                    echo 'selected';
                }
                ?>
            >
                Responsable
            </option>


            <option
                value="technicien"
                <?php
                if ($user['role'] == 'technicien') {
                    echo 'selected';
                }
                ?>
            >
                Technicien
            </option>


        </select>


        <br><br>


        <!-- BOUTON -->

        <button
            type="submit"
            name="modifier"
        >
            Enregistrer les modifications
        </button>


        <a href="index.php">
            Annuler
        </a>


    </form>

</div>


<?php

include("../../includes/footer.php");

?>