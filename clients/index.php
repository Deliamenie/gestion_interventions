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
$sql = "SELECT * FROM clients";

// Si une recherche est effectuée
if ($recherche != "") {

    $sql .= " WHERE 
              nom_client LIKE '%$recherche%'
              OR localisation LIKE '%$recherche%'
              OR telephone LIKE '%$recherche%'
              OR email LIKE '%$recherche%'";
}

// Trier du plus récent au plus ancien
$sql .= " ORDER BY client_id ASC";

$result = mysqli_query($conn, $sql);

?>

<div class="content">

    <h1>LISTE DES CLIENTS</h1>

    <?php if ($_SESSION['role'] == 'admin'
        || $_SESSION['role'] == 'responsable'): ?>

        <a href="nouveau client.php">
            <button>➕ Nouveau client</button>
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
            placeholder="🔎 Rechercher un client..."
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
         TABLEAU DES CLIENTS
    ================================ -->

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <thead>

            <tr>

                <th>ID</th>
                <th>Nom du client</th>
                <th>Localisation</th>
                <th>Téléphone</th>
                <th>Email</th>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'responsable'): ?>
                <th>Actions</th>
<?php endif;?>
            </tr>

        </thead>


        <tbody>

        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($client = mysqli_fetch_assoc($result)) {

        ?>

            <tr>

                <td>
                    <?php echo $client['client_id']; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($client['nom_client']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($client['localisation']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($client['telephone']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($client['email']); ?>
                </td>

               
  |

                         <?php if ($_SESSION['role'] == 'admin'
                        || $_SESSION['role'] == 'responsable'): ?>
                 <td>
                            <a href="modifier.php?id=<?php echo $client['client_id']; ?>">

                            <button type="button">

                                ✏️ Modifier

                            </button>

                        </a>

                        <a

                            href="supprimer.php?id=<?php echo $client['client_id']; ?>"

                            onclick="return confirm('Voulez-vous vraiment supprimer ce client ?');"

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

                <td colspan="6" style="text-align:center;">

                    <?php if ($recherche != ""): ?>

                        Aucun client trouvé pour :
                        <strong>
                            <?php echo htmlspecialchars($recherche); ?>
                        </strong>

                    <?php else: ?>

                        Aucun client enregistré.

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