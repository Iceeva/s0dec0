<?php
// Configuration de la connexion à la base de données
$servername = "localhost";
$username = "root"; // Remplacez par votre nom d'utilisateur MySQL
$password = "";     // Remplacez par votre mot de passe MySQL
$dbname = "s0dec0"; // Le nom de votre base de données

try {
    // Création de la connexion
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération de la référence depuis la requête GET
    $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
    
    // Nettoyage et préparation de la référence
    $cleanReference = str_replace('---', '/', $reference);
    $cleanReference = trim($cleanReference);

    // Requête SQL avec préparation pour éviter les injections
    $stmt = $conn->prepare("SELECT * FROM balles WHERE reference = :reference OR REPLACE(reference, '/', '---') = :reference");
    $stmt->bindParam(':reference', $cleanReference);
    $stmt->execute();

    // Récupération des résultats
    $balle = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($balle) {
        // Formatage de la réponse en JSON
        header('Content-Type: application/json');
        echo json_encode([
            'id' => $balle['id'],
            'reference' => $balle['reference'],
            'date_sortie' => $balle['date_sortie'],
            'poids_brut' => $balle['poids_brut'],
            'poids_net' => $balle['poids_net'],
            'variete' => $balle['variete'],
            'usine' => $balle['usine'],
            'marquage' => $balle['marquage'],
            'longueur_soie' => $balle['longueur_soie'],
            'type_vente' => $balle['type_vente'],
            'est_classe' => (bool)$balle['est_classe'],
            'date_classement' => $balle['date_classement']
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Référence non trouvée']);
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données: ' . $e->getMessage()]);
}
?>