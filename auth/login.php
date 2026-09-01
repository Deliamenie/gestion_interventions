<?php

session_start();

include("../config/db.php");

$message = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../dashboard/index.php");
            exit();

        } else {

            $message = "❌ Mot de passe incorrect.";

        }

    } else {

        $message = "❌ Nom d'utilisateur incorrect.";

    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Connexion - Matrix Telecom</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            font-family: Arial, sans-serif;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background:
                radial-gradient(
                    circle at 10% 20%,
                    #20c997,
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 80%,
                    #0b7285,
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #062e23,
                    #0b314d
                );

            position: relative;

            overflow: hidden;
        }

        /* =========================
           ICONES BACKGROUND
        ========================= */

        .background-icons {

            position: absolute;

            inset: 0;

            overflow: hidden;

            pointer-events: none;

            z-index: 0;
        }

        .icon {

            position: absolute;

            font-size: 38px;

            opacity: 0.15;

            animation: float 10s ease-in-out infinite;
        }

        .icon:nth-child(1) {
            left: 8%;
            top: 15%;
        }

        .icon:nth-child(2) {
            left: 20%;
            top: 75%;
            animation-delay: 2s;
        }

        .icon:nth-child(3) {
            right: 10%;
            top: 18%;
            animation-delay: 4s;
        }

        .icon:nth-child(4) {
            right: 15%;
            bottom: 15%;
            animation-delay: 1s;
        }

        .icon:nth-child(5) {
            left: 12%;
            top: 50%;
            animation-delay: 3s;
        }

        .icon:nth-child(6) {
            right: 30%;
            bottom: 8%;
            animation-delay: 5s;
        }

        @keyframes float {

            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25px);
            }

        }

        /* =========================
           CARTE LOGIN
        ========================= */

        .login-box {

            position: relative;

            z-index: 5;

            width: 420px;

            max-width: 90%;

            padding: 45px 40px;

            background: rgba(255,255,255,0.97);

            border-radius: 24px;

            box-shadow:
                0 25px 60px rgba(0,0,0,0.4);

            animation: apparition 0.7s ease;
        }

        @keyframes apparition {

            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        /* =========================
           TITRE
        ========================= */

        .company {

            text-align: center;

            font-size: 27px;

            font-weight: bold;

            letter-spacing: 2px;

            background:
                linear-gradient(
                    90deg,
                    #087f5b,
                    #12b886,
                    #0b7285
                );

            -webkit-background-clip: text;

            -webkit-text-fill-color: transparent;

            margin-bottom: 8px;
        }

        .motto {

            text-align: center;

            color: #123b5d;

            font-size: 14px;

            font-style: italic;

            font-weight: 600;

            margin-bottom: 30px;
        }

        h1 {

            text-align: center;

            color: #222;

            font-size: 28px;

            margin-bottom: 28px;
        }

        /* =========================
           MESSAGE ERREUR
        ========================= */

        .message {

            background: #ffe8e8;

            color: #c92a2a;

            padding: 12px;

            border-radius: 8px;

            text-align: center;

            margin-bottom: 20px;

            font-size: 14px;
        }

        /* =========================
           LABELS
        ========================= */

        label {

            display: block;

            color: #333;

            font-weight: bold;

            margin-bottom: 8px;
        }

        /* =========================
           INPUTS
        ========================= */

        input {

            width: 100%;

            padding: 14px;

            border: 2px solid #ddd;

            border-radius: 10px;

            outline: none;

            font-size: 15px;

            transition: 0.3s;

            margin-bottom: 20px;
        }

        input:focus {

            border-color: #12b886;

            box-shadow:
                0 0 0 3px rgba(18,184,134,0.12);
        }

        /* =========================
           BOUTON
        ========================= */

        button {

            width: 100%;

            padding: 15px;

            border: none;

            border-radius: 10px;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            background:
                linear-gradient(
                    90deg,
                    #087f5b,
                    #12b886,
                    #0b7285
                );

            box-shadow:
                0 8px 20px rgba(18,184,134,0.3);

            transition: 0.3s;
        }

        button:hover {

            transform: translateY(-3px);

            box-shadow:
                0 12px 28px rgba(18,184,134,0.5);
        }

        /* =========================
           RETOUR
        ========================= */

        .back {

            display: block;

            text-align: center;

            margin-top: 22px;

            color: #087f5b;

            text-decoration: none;

            font-size: 14px;

            font-weight: bold;
        }

        .back:hover {

            color: #0b7285;

        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 500px) {

            .login-box {

                padding: 35px 25px;

            }

            .company {

                font-size: 23px;

            }

            h1 {

                font-size: 24px;

            }

            .icon {

                font-size: 28px;

            }

        }

    </style>

</head>

<body>

    <!-- BACKGROUND -->

    <div class="background-icons">

        <div class="icon">📡</div>

        <div class="icon">🔧</div>

        <div class="icon">🛠️</div>

        <div class="icon">📞</div>

        <div class="icon">💻</div>

        <div class="icon">⚡</div>

    </div>


    <!-- LOGIN -->

    <div class="login-box">

        <div class="company">
            MATRIX TELECOM
        </div>

        <div class="motto">
            Connecting people. Inspiring solutions.
        </div>

        <h1>
            🔐 Connexion
        </h1>


        <?php if ($message != "") { ?>

            <div class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>


        <form method="POST">

            <label>
                Nom d'utilisateur
            </label>

            <input
                type="text"
                name="username"
                placeholder="Entrez votre nom d'utilisateur"
                required
            >


            <label>
                Mot de passe
            </label>

            <input
                type="password"
                name="password"
                placeholder="Entrez votre mot de passe"
                required
            >


            <button
                type="submit"
                name="login"
            >
                Se connecter
            </button>

        </form>


        <a href="welcome.php" class="back">
            ← Retour à l'accueil
        </a>

    </div>

</body>

</html>