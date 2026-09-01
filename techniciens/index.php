<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");

// ===============================
// RECHERCHE
// ===============================

$recherche = "";

if (isset($_GET['recherche'])) {
    $recherche = mysqli_real_escape_string($conn, $_GET['recherche']);
}

// Requête de base
$sql = "SELECT * FROM techniciens";

// Recherche dans plusieurs colonnes
if ($recherche != "") {

    $sql .= " WHERE
              nom LIKE '%$recherche%'
              OR telephone LIKE '%$recherche%'
              OR specialisation LIKE '%$recherche%'";
}

// Trier par ID
$sql .= " ORDER BY id ASC";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

    <h1>LISTE DES TECHNICIENS</h1>

    <?php if ($_SESSION['role'] == 'admin'
        || $_SESSION['role'] == 'responsable'): ?>

        <a href="nouveau technicien.php">
            <button>➕ Nouveau technicien</button>
        </a>

    <?php endif; ?>

    <br><br>


    <!-- ===============================
         BARRE DE RECHERCHE
    ================================ -->

    <form method="GET" style="margin-bottom: 20px;">

        <input
            type="text"
            name="recherche"
            placeholder="🔎 Rechercher un technicien..."
            value="<?php echo htmlspecialchars($recherche); ?>"
            style="
                padding: 10px;
                width: 300px;
                border: 1px solid #ccc;
                border-radius: 5px;
            "
        >

        <button
            type="submit"
            style="
                padding: 10px 15px;
                cursor: pointer;
            "
        >
            🔎 Rechercher
        </button>


        <?php if ($recherche != ""): ?>

            <a href="index.php">
                <button type="button">
                    ❌ Réinitialiser
                </button>
            </a>

        <?php endif; ?>

    </form>


    <!-- ===============================
         TABLEAU DES TECHNICIENS
    ================================ -->

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <thead>

            <tr>

                <th>ID</th>
                <th>Nom du technicien</th>
                <th>Téléphone</th>
                <th>Spécialisation</th>
               <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'responsable'): ?>
                <th>Actions</th>
<?php endif;?>

            </tr>

        </thead>


        <tbody>

        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($technicien = mysqli_fetch_assoc($result)) {

        ?>

            <tr>

                <td>
                    <?php echo $technicien['id']; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($technicien['nom']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($technicien['telephone']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($technicien['specialisation']); ?>
                </td>

               

                    <?php if ($_SESSION['role'] == 'admin'
                        || $_SESSION['role'] == 'responsable'): ?>
                 <td>
                            <a href="modifier.php?id=<?php echo $technicien['id']; ?>">

                            <button type="button">

                                ✏️ Modifier

                            </button>

                        </a>

                        <a

                            href="supprimer.php?id=<?php echo $technicien['id']; ?>"

                            onclick="return confirm('Voulez-vous vraiment supprimer ce technicien ?');"

                        >

                            <button type="button">

                                🗑️ Supprimer

                            </button>

                        </a>

                    </td>
                    
                    <?php endif; ?>

               

            </tr>

        <?php

            }

        } else {

        ?>

            <tr>

                <td colspan="5" style="text-align:center;">

                    <?php if ($recherche != ""): ?>

                        Aucun technicien trouvé pour :
                        <strong>
                            <?php echo htmlspecialchars($recherche); ?>
                        </strong>

                    <?php else: ?>

                        Aucun technicien enregistré.

                    <?php endif; ?>

                </td>

            </tr>

        <?php

        }

        ?>

        </tbody>

    </table>

</div>

<?php

include("../includes/footer.php");

?>