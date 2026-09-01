console.log("🔔 Système de notification chargé");

window.addEventListener("load", function () {

    console.log("📌 Page chargée");

    if (!("Notification" in window)) {
        console.log("❌ Notifications non disponibles");
        return;
    }

    navigator.serviceWorker.register("../notifications/service-worker.js")
        .then(function (registration) {

            console.log("✅ Service Worker enregistré");

            if (Notification.permission === "default") {
                return Notification.requestPermission()
                    .then(function (permission) {

                        console.log("Permission :", permission);

                        if (permission === "granted") {
                            verifierPlanifications(registration);
                        }

                    });
            }

            if (Notification.permission === "granted") {
                verifierPlanifications(registration);
            }

        })
        .catch(function (error) {

            console.error("❌ Erreur Service Worker :", error);

        });

});


function verifierPlanifications(registration) {

    const lignes = document.querySelectorAll("tbody tr");

    console.log("📋 Nombre de lignes :", lignes.length);

    lignes.forEach(function (ligne) {

        const dateElement = ligne.querySelector("[data-date]");
        const heureElement = ligne.querySelector("[data-heure]");

        if (!dateElement || !heureElement) {
            return;
        }

        const date = dateElement.getAttribute("data-date");
        const heure = heureElement.getAttribute("data-heure");

        console.log("📅 Date :", date);
        console.log("⏰ Heure :", heure);

        const datePlanifiee = new Date(date + "T" + heure);
        const maintenant = new Date();

        const difference =
            datePlanifiee.getTime() - maintenant.getTime();

        console.log("⏳ Différence :", difference);

        /*
         * Si l'heure est encore dans le futur
         */
        if (difference > 0) {

            console.log("⏰ Notification programmée dans :", difference, "ms");

            setTimeout(function () {

                registration.showNotification(
                    "🔔 Intervention planifiée",
                    {
                        body:
                            "Une intervention est prévue maintenant.\n" +
                            "Date : " + date + "\n" +
                            "Heure : " + heure,
                        requireInteraction: true
                    }
                );

                console.log("🎉 Notification affichée !");

            }, difference);

        }

        /*
         * Si l'heure est déjà arrivée
         * mais depuis moins d'une minute
         */
        else if (difference <= 0 && difference > -60000) {

            registration.showNotification(
                "🔔 Intervention planifiée",
                {
                    body:
                        "Une intervention est prévue maintenant.\n" +
                        "Date : " + date + "\n" +
                        "Heure : " + heure,
                    requireInteraction: true
                }
            );

            console.log("🎉 Notification affichée immédiatement !");

        }

    });

}