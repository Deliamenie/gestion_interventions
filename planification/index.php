<?php

include("../includes/auth.php");

include("../config/db.php");

include("../includes/header.php");

include("../includes/sidebar.php");

?>

<div class="content">

    <h1>📅 PLANIFICATION DES INTERVENTIONS</h1>

    <br>

    <a href="ajouter.php">

        <button type="button">

            ➕ Nouvelle planification

        </button>

    </a>

    <br><br>

    <?php

    $sql = "SELECT * FROM planifications

            ORDER BY date_planification ASC,

                     heure_planification ASC";

    $result = mysqli_query($conn, $sql);

    ?>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <thead>

            <tr>

                <th>Date</th>

                <th>Heure</th>

                <th>Client</th>

                <th>Technicien</th>

               

                <th>Statut</th>

                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

        <?php if ($result && mysqli_num_rows($result) > 0) { ?>

            <?php while ($planification = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <!-- DATE -->

                    <td data-date="<?php echo htmlspecialchars($planification['date_planification']); ?>">

                        <?php

                        echo htmlspecialchars(

                            $planification['date_planification']

                        );

                        ?>

                    </td>

                    <!-- HEURE -->

                    <td data-heure="<?php echo htmlspecialchars($planification['heure_planification']); ?>">

                        <?php

                        echo htmlspecialchars(

                            $planification['heure_planification']

                        );

                        ?>

                    </td>

                    <!-- CLIENT -->

                    <td>

                        <?php

                        echo htmlspecialchars(

                            $planification['client']

                        );

                        ?>

                    </td>

                    <!-- TECHNICIEN -->

                    <td>

                        <?php

                        echo htmlspecialchars(

                            $planification['technicien']

                        );

                        ?>

                    </td>

                    

                    <!-- STATUT -->

                    <td>

                        <?php

                        echo htmlspecialchars(

                            $planification['statut']

                        );

                        ?>

                    </td>

                    <!-- ACTIONS -->

                    <td> 
            
                       <a  href="details.php?id=<?php echo $planification['id']; ?>">
                        
                            <button type="button">

                                👁️ Détails

                            </button>

                     </a>
                    

                        <a href="modifier.php?id=<?php echo $planification['id']; ?>">

                            <button type="button">

                                ✏️ Modifier

                            </button>

                        </a>

                        <a

                            href="supprimer.php?id=<?php echo $planification['id']; ?>"

                            onclick="return confirm('Voulez-vous vraiment supprimer cette planification ?');"

                        >

                            <button type="button">

                                🗑️ Supprimer

                            </button>

                        </a>

                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>

                <td

                    colspan="7"

                    style="text-align:center;"

                >

                    Aucune planification enregistrée.

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>
 
</script>
 <script src="../notifications/notifications.js"></script>
<?php

include("../includes/footer.php");

?>