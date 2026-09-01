<?php
include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/auth.php");

$recherche = "";

if (isset($_GET['recherche'])) {
    $recherche = mysqli_real_escape_string($conn, $_GET['recherche']);
}

$sql = "SELECT intervention.*, clients.nom_client
        FROM intervention
        LEFT JOIN clients
        ON intervention.client_id = clients.client_id
        WHERE  intervention.client_id LIKE '%$recherche%'
        OR intervention.localisation LIKE '%$recherche%'
        OR intervention.telephone LIKE '%$recherche%'
        OR intervention.nature_panne LIKE '%$recherche%'
        OR intervention.etat LIKE '%$recherche%'
        OR intervention.date LIKE '%$recherche%'
        OR intervention.ticket_id LIKE '%$recherche%'
        OR intervention.responsable_intervention LIKE '%$recherche%'
        ORDER BY intervention.id ASC";

$result = mysqli_query($conn, $sql);
?>

<div class="content">

    <h1>Liste des interventions</h1>

    <!-- RECHERCHE -->
    <form method="GET">

        <input type="text"
               name="recherche"
               placeholder="🔍 Rechercher une intervention..."
               value="<?php echo htmlspecialchars($recherche); ?>">

        <button type="submit">
            Rechercher
        </button>

    </form>

    <br>

    <table border="1" cellpadding="10" cellspacing="0">

        <thead>
            <tr>
                <th>ID</th>
                <th>Client ID</th>
                <th>Localisation</th>
                <th>Téléphone</th>
                <th>Nature de la panne</th>
                <th>État</th>
                <th>Date</th>
                
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

        ?>

            <tr>

                <td>
                    <?php echo $row['id']; ?>
                </td>

                <td>
                    <?php echo $row['client_id']; ?>
                </td>

                <td>
                    <?php echo $row['localisation']; ?>
                </td>

                <td>
                    <?php echo $row['telephone']; ?>
                </td>

                <td>
                    <?php echo $row['nature_panne']; ?>
                </td>

                <td>
                    <?php echo $row['etat']; ?>
                </td>

                <td>
                    <?php echo $row['date']; ?>
                </td>

                

                    <td> 
            
                       <a  href="details.php?id=<?php echo $row['id']; ?>">
                        
                            <button type="button">

                                👁️ Détails

                            </button>

                     </a>
                    

                        <a href="modifier.php?id=<?php echo $row['id']; ?>">

                            <button type="button">

                                ✏️ Modifier

                            </button>

                        </a>

                        <a

                            href="supprimer.php?id=<?php echo $row['id']; ?>"

                            onclick="return confirm('Voulez-vous vraiment supprimer cette intervention ?');"

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

            echo "<tr>
                    <td colspan='9'>
                        Aucune intervention trouvée.
                    </td>
                  </tr>";

        }

        ?>

        </tbody>

    </table>

</div>

<?php
include("../includes/footer.php");
?>