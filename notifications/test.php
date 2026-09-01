<?php

include("../includes/auth.php");
include("../includes/header.php");
include("../includes/sidebar.php");

?>

<div class="content">

    <h1>🔔 Test des notifications</h1>

    <p>
        Active les notifications puis teste le Service Worker.
    </p>

    <button id="activer">
        🔔 Activer les notifications
    </button>

    <button id="tester">
        🧪 Tester la notification
    </button>

    <p id="message"></p>

</div>


<script>

let registration = null;


// Enregistrer le Service Worker

if ("serviceWorker" in navigator) {

    navigator.serviceWorker.register("service-worker.js")
        .then(function(reg) {

            registration = reg;

            console.log("✅ Service Worker enregistré.");

        })
        .catch(function(error) {

            console.log(
                "❌ Erreur Service Worker :",
                error
            );

        });

}


// Activer les notifications

document.getElementById("activer").addEventListener(
    "click",
    async function() {

        if (!("Notification" in window)) {

            document.getElementById("message").textContent =
                "❌ Les notifications ne sont pas disponibles.";

            return;
        }

        const permission =
            await Notification.requestPermission();

        if (permission === "granted") {

            document.getElementById("message").textContent =
                "✅ Notifications activées !";

        } else {

            document.getElementById("message").textContent =
                "❌ Notifications refusées.";

        }

    }
);


// Tester le Service Worker

document.getElementById("tester").addEventListener(
    "click",
    async function() {

        if (Notification.permission !== "granted") {

            alert("Active d'abord les notifications.");

            return;
        }

        if (!registration) {

            alert("Le Service Worker n'est pas encore prêt.");

            return;
        }

        registration.showNotification(
            "🔔 Test Service Worker",
            {
                body:
                    "Le Service Worker fonctionne correctement !",

                icon:
                    "../images/logo.png",

                badge:
                    "../images/logo.png",

                requireInteraction: true
            }
        );

    }
);

</script>


<?php

include("../includes/footer.php");

?>