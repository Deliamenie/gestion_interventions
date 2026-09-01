<?php

include("../config/db.php");

$message = "";

if (isset($_POST['creer'])) {

    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifier que les champs sont remplis
    if ($name === '' || $username === '' || $password === '') {

        $message = "❌ Veuillez remplir tous les champs.";

    } else {

        // Vérifier si le nom d'utilisateur existe déjà
        $verifier = "SELECT id FROM users WHERE username='$username'";
        $resultat = mysqli_query($conn, $verifier);

        if (mysqli_num_rows($resultat) > 0) {

            $message = "❌ Ce nom d'utilisateur existe déjà.";

        } else {

            // Sécuriser le mot de passe
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Créer le compte administrateur
            $sql = "INSERT INTO users (name, username, password, role)
                    VALUES ('$name', '$username', '$password_hash', 'admin')";

            if (mysqli_query($conn, $sql)) {

                $message = "✅ Compte administrateur créé avec succès !";

            } else {

                $message = "❌ Erreur : " . mysqli_error($conn);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>Créer administrateur</title>

</head>

<body>

<h1>Créer le compte administrateur</h1>

<?php if ($message != ""): ?>

    <p>
        <?php echo htmlspecialchars($message); ?>
    </p>

<?php endif; ?>


<form method="POST">

    <label>Nom</label>
    <br>

    <input type="text" name="name" required>

    <br><br>


    <label>Nom d'utilisateur</label>
    <br>

    <input type="text" name="username" required>

    <br><br>


    <label>Mot de passe</label>
    <br>

    <input type="password" name="password" required>

    <br><br>


    <button type="submit" name="creer">
        Créer le compte
    </button>

</form>

</body>

</html>