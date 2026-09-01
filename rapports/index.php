<?php
include("../includes/header.php");
include("../includes/sidebar.php");
include("../config/db.php");
include("../includes/auth.php");

?>

<div class="content">

    <h1>LISTE DES RAPPORTS</h1>

    <a href="nouveau rapport.php">
        <button>➕ Nouveau rapport</button>
    </a>

    <br><br>

    <!-- Recherche -->
    <form method="GET">
        <input type="text" name="recherche"
               placeholder="🔍 Rechercher un rapport..."
               value="<?php echo isset($_GET['recherche']) ? $_GET['recherche'] : ''; ?>">

        <button type="submit">Rechercher</button>
    </form>

    <br>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
                
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php

        if (isset($_GET['recherche']) && $_GET['recherche'] != '') {

            $recherche = $_GET['recherche'];

            $sql = "SELECT * FROM rapports
                    WHERE titre LIKE '%$recherche%'
                    OR contenu LIKE '%$recherche%'
                    OR auteur LIKE '%$recherche%'
                    OR date_rapport LIKE '%$recherche%'
                    ORDER BY id DESC";

        } else {

            $sql = "SELECT * FROM rapports
                    ORDER BY id ASC";
        }

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            while ($rapport = mysqli_fetch_assoc($result)) {
        ?>

            <tr>

                <td><?php echo $rapport['id']; ?></td>

                <td><?php echo $rapport['titre']; ?></td>

                <td><?php echo $rapport['auteur']; ?></td>

                <td><?php echo $rapport['date_rapport']; ?></td>

               
                
                    
<!-- ACTIONS -->

                    <td> 
            
                       <a  href="details.php?id=<?php echo $rapport['id']; ?>">
                        
                            <button type="button">

                                👁️ Détails

                            </button>

                     </a>
                    

                        <a href="modifier.php?id=<?php echo $rapport['id']; ?>">

                            <button type="button">

                                ✏️ Modifier

                            </button>

                        </a>

                        <a

                            href="supprimer.php?id=<?php echo $rapport['id']; ?>"

                            onclick="return confirm('Voulez-vous vraiment supprimer ce rapport ?');"

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
                    <td colspan='5'>Aucun rapport enregistré.</td>
                  </tr>";
        }
        ?>

        </tbody>

    </table>

</div>

<?php
include("../includes/footer.php");
?>
