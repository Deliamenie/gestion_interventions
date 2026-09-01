<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Chart.js</title>
</head>

<body>

<h2>Test du graphique</h2>

<div style="width: 700px; height: 400px;">
    <canvas id="monGraphique"></canvas>
</div>

<script src="/Swe1/fiche%20d'intervention/assets/js/chart.umd.min.js"></script>
<script>
    alert(typeof Chart);
    </script>
<script>

console.log(typeof Chart);

const graphique = document.getElementById("monGraphique");

new Chart(graphique, {
    type: "bar",

    data: {
        labels: ["Janvier", "Février", "Mars", "Avril"],

        datasets: [{
            label: "Interventions",
            data: [5, 8, 3, 7]
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

</script>

</body>
</html>