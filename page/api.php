<?php

// Fonction pour gérer les requêtes POST
function handlePostRequest() {
    // Connexion à la base de données
    $dburl = "localhost";
    $dblogin = "root";
    $dbpass = "12102001";
    $dbtable = "spa_sdp";

    try {
        $db = new PDO("mysql:host=$dburl;dbname=$dbtable;charset=utf8", $dblogin, $dbpass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "La plateforme enregistre trop de connexions actuellement. Merci de revenir d'ici quelques heures.";
        exit();
    }

    // Enregistrer l'heure de création du PDF dans la base de données
    $heureCreation = date('Y-m-d H:i:s');
    $sql = "INSERT INTO pdfs (heure_creation) VALUES (?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$heureCreation]);

    // Répondre avec l'heure de création au format JSON
    $response = ['heure_creation' => $heureCreation];
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Vérifier la méthode de la requête
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest();
}
