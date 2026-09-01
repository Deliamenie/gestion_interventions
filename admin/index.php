<?php

include("../includes/auth.php");
include("../admin/auth_admin.php");
include("../config/db.php");
include("../includes/header.php");
include("../includes/sidebar.php");

?>

<div class="content">

    <h1>Administration</h1>

    <p>Bienvenue dans l'espace d'administration.</p>

    <div>

        <a href="utilisateur/index.php">
            👥 Gestion des utilisateurs
        </a>

    </div>

</div>

<?php

include("../includes/footer.php");

?>