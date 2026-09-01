self.addEventListener("install", function(event) {
    self.skipWaiting();
});

self.addEventListener("activate", function(event) {
    event.waitUntil(self.clients.claim());
});

self.addEventListener("push", function(event) {

    let data = {
        title: "🔔 Intervention",
        body: "Une intervention est prévue."
    };

    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data.body = event.data.text();
        }
    }

    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: "/SWE1/fiche%20d'Intervention/images/logo.png",
            badge: "/SWE1/fiche%20d'Intervention/images/logo.png",
            requireInteraction: true
        })
    );
});