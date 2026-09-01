<?php
   if (session_status() === PHP_SESSION_NONE)
 {
       session_start();
    }
?>
<div class="sidebar">

    <h2>MENU</h2>

    <ul>
        <li><a href="../dashboard/index.php">🏠 Tableau de bord</a></li>
       <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'responsable'): ?>
        <li><a href="../statistiques/index.php">📊 Statistiques</a></li>
        <?php endif; ?>
        <li><a href="../planification/index.php">📆Planifications</a></li>
        <?php if ($_SESSION['role'] == 'admin' 
        || $_SESSION['role'] == 'responsable' || $_SESSION['role'] == 'technicien'): ?>

<li><a href="../clients/index.php">👥 Clients</a></li>
      <?php endif;?>
       
        <li><a href="../interventions/ajouter.php">🔧 Nouvelle Intervention</a></li>
        <li><a href="../interventions/index.php">📄 Liste d'intervention</a></li>
        <li><a href="../techniciens/index.php">👨‍🔧 Techniciens</a></li>
        <li><a href="../rapports/index.php">📊 Rapports</a></li>
      <?php 
      if (isset($_SESSION['role'])&& $_SESSION['role'] ==='admin'):
      ?>
        <li><a href="../admin/index.php">⚙️Administration</a></li>
        <?php endif;?>
        <li><a href="../auth/logout.php">🚪 Déconnexion</a></li>
    </ul>

</div>