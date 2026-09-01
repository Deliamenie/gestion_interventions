<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Telecom</title>
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
                    circle at top left,
                    #20c997,
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    #0b7285,
                    transparent 35%
                ),
                linear-gradient(
                    135deg,
                    #0b2e23,
                    #123b5d
                );
            position: relative;
            overflow: hidden;
        }
        /* Cercles décoratifs */
        body::before,
        body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        body::before {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -80px;
        }
        body::after {
            width: 400px;
            height: 400px;
            bottom: -180px;
            right: -120px;
        }
        /* Carte principale */
        .welcome-box {
            position: relative;
            z-index: 2;
            width: 430px;
            max-width: 90%;
            padding: 50px 40px;
            background: rgba(255, 255, 255, 0.97);
            border-radius: 24px;
            text-align: center;
            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(10px);
            animation: apparition 0.8s ease;
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
        /* MATRIX TELECOM */
        .company {
            font-size: 30px;
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
            margin-bottom: 12px;
        }
        /* MOTTO */
        .motto {
            color: #123b5d;
            font-size: 16px;
            font-weight: 600;
            font-style: italic;
            margin-bottom: 30px;
            letter-spacing: 0.5px;
        }
        /* BIENVENUE */
        .welcome-box h2 {
            color: #222;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .description {
            color: #666;
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        /* BOUTONS */
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 13px 0;
            text-decoration: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
        /* CONNEXION */
        .login {
            color: white;
            background:
                linear-gradient(
                    90deg,
                    #087f5b,
                    #12b886,
                    #0b7285
                );
            box-shadow:
                0 8px 20px rgba(18, 184, 134, 0.25);
        }
        .login:hover {
            transform: translateY(-3px);
            box-shadow:
                0 12px 25px rgba(18, 184, 134, 0.4);
        }
        /* INSCRIPTION */
        .signup {
            background: white;
            color: #087f5b;
            border: 2px solid #12b886;
        }
        .signup:hover {
            background: #12b886;
            color: white;
            transform: translateY(-3px);
        }
        /* FOOTER */
        .footer-text {
            margin-top: 25px;
            font-size: 12px;
            color: #999;
            letter-spacing: 0.5px;
        }
        /* RESPONSIVE */
        @media (max-width: 500px) {
            .welcome-box {
                padding: 40px 25px;
            }
            .company {
                font-size: 25px;
            }
            .welcome-box h2 {
                font-size: 23px;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-box">
        <div class="company">
            MATRIX TELECOM
        </div>
        <div class="motto">
            Connecting people. Inspiring solutions.
        </div>
        <h2>
            Bienvenue
        </h2>
        <p class="description">
            Système intelligent de gestion
            des interventions
        </p>
        <a href="login.php" class="btn login">
            🔐 Se connecter
        </a>
        <a href="signup.php" class="btn signup">
            📝 Créer un compte
        </a>
        <div class="footer-text">
            © 2026 Matrix Telecom
        </div>
    </div>
</body>
</html>