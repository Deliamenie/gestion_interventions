<?php

include("../../includes/auth.php");
include("../../admin/auth_admin.php");
include("../../config/db.php");
include("../../includes/header.php");
include("../../includes/sidebar.php");

$sql = "SELECT id, name, username, role, created_at FROM users ORDER BY id ASC";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

    <h1>Gestion des utilisateurs</h1>

    <a href="ajouter.php">
        ➕ Ajouter un utilisateur
    </a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">

        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Username</th>
            <th>Rôle</th>
            <th>Date de création</th>
            <th>Actions</th>
        </tr>

        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($user = mysqli_fetch_assoc($result)) {

        ?>

        <tr>

            <td>
                <?php echo $user['id']; ?>
            </td>

            <td>
                <?php echo $user['name']; ?>
            </td>

            <td>
                <?php echo $user['username']; ?>
            </td>

            <td>
                <?php echo $user['role']; ?>
            </td>

            <td>
                <?php echo $user['created_at']; ?>
            </td>
<td>
                            <a href="modifier.php?id=<?php echo $user['id']; ?>">

                            <button type="button">

                                ✏️ Modifier

                            </button>

                        </a>

                        <a

                            href="supprimer.php?id=<?php echo $user['id']; ?>"

                            onclick="return confirm('Voulez-vous vraiment supprimer ce client ?');"

                        >

                            <button type="button">

                                🗑️ Supprimer

                            </button>

                        </a>

                    </td>
                    
          

        </tr>

        <?php

            }

        } else {

        ?>

        <tr>

            <td colspan="6">
                Aucun utilisateur enregistré.
            </td>

        </tr>

        <?php

        }

        ?>

    </table>

    <br>

    <a href="../index.php">
        ⬅ Retour à Administration
    </a>

</div>

<?php

include("../../includes/footer.php");

?>