<?php
class ModelJoke
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    // Récupération de toutes les blagues de la BDD
    public function getAllJokes($bdd)
    {
        // Préparation de la requête
        $req = $bdd->prepare('SELECT text_joke FROM joke');
        // Exécution de la requête
        $req->execute();
        // Récupération des données de la BDD grâce à la requête
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        // Retour des données dans un tableau
        return $data;
    }

    // Récupération d'une seule blague de la BDD
    public function getOneJoke($bdd, $id)
    {
        // Préparation de la requête
        $req = $bdd->prepare('SELECT text_joke FROM joke WHERE id_joke = ?');
        // Binding des paramètres pour les remplacer les "?"
        $req->bindParam(1, $id, PDO::PARAM_INT);
        // Exécution de la requête
        $req->execute();
        // Récupération des données de la BDD grâce à la requête
        $data = $req->fetch(PDO::FETCH_ASSOC);
        // Retour des données dans un tableau
        return $data;
    }

    // Récupération aléatoire d'une seule blague de la BDD
    public function getRandomJoke($bdd)
    {
        // Préparation de la requête
        $req = $bdd->prepare('SELECT text_joke FROM joke ORDER BY RAND() LIMIT 1');
        // Exécution de la requête
        $req->execute();
        // Récupération des données de la BDD grâce à la requête
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        // Retour des données dans un tableau
        return $data;
    }

    // Ajout d'une blague dans la BDD
    public function addJoke($bdd, $textJoke)
    {
        // Préparation de la requête
        $req = $bdd->prepare('INSERT INTO joke (text_joke) VALUES (?)');
        // Binding des paramètres pour les remplacer les "?"
        $req->bindParam(1, $textJoke, PDO::PARAM_STR);
        //Execution de la requête
        if ($req->execute()) {
            //Cela fonctionne
            return true;
        }
        //Cela ne fonctionne pas
        return false;

    }
}