<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Classes/DB.php";
/**
 * Commencez par importer le fichier sql live.sql via PHPMyAdmin.
 * 1. Sélectionnez tous les utilisateurs.
 * 2. Sélectionnez tous les articles.
 * 3. Sélectionnez tous les utilisateurs qui parlent de poterie dans un article.
 * 4. Sélectionnez tous les utilisateurs ayant au moins écrit deux articles.
 * 5. Sélectionnez l'utilisateur Jane uniquement s'il elle a écris un article ( le résultat devrait être vide ! ).
 *
 * ( PS: Sélectionnez, mais affichez le résultat à chaque fois ! ).
 */

pre("1");
$db = DB::getInstance();

$request1 = $db->prepare("
                SELECT * FROM user
");

$request1->execute();

pre($request1->fetchAll());


pre("2");
$request2 = $db->prepare("
                SELECT * FROM article 
");
$request2->execute();
pre($request2->fetchAll());


pre("3");
$request3 = $db->prepare("
                SELECT * FROM user
                    WHERE id = ANY (SELECT user_fk FROM article WHERE contenu LIKE '%poterie%')
");
$request3->execute();
pre($request3->fetchAll());
pre("4");
$request4 = $db->prepare("
                SELECT * FROM user
                    WHERE username = 'jane Doe'
                    AND EXISTS(SELECT * FROM article WHERE user_fk = user.id)
                
");
$request4->execute();
pre($request4->fetchAll());

function pre($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}