<?php

//INCLUDES
include './env.php';
include './utils/functions.php';
include './model/modelJoke.php';

class JokeController
{
    private $modelJoke;

    public function __construct($bdd)
    {
        $this->modelJoke = new ModelJoke($bdd);
    }

    // Récupérer toutes les jokes
    public function getAllJokes($bdd)
    {
        $jokes = $this->modelJoke->getAllJokes($bdd);
        echo json_encode($jokes);
    }

    // Récupérer une blague spécifique par ID
    public function getOneJoke($bdd, $id)
    {
        $joke = $this->modelJoke->getOneJoke($bdd, $id);
        if ($joke) {
            echo json_encode($joke);
        } else {
            echo json_encode(["message" => "Blague non trouvée"]);
        }
    }

    // Récupérer une blague aléatoire
    public function getRandomJoke($bdd)
    {
        $joke = $this->modelJoke->getRandomJoke($bdd);
        echo json_encode($joke);
    }

    // Ajouter une nouvelle blague
    public function addJoke($bdd, $textJoke)
    {
        $result = $this->modelJoke->addJoke($bdd, $textJoke);
        if ($result) {
            http_response_code(200);
            echo json_encode(["message" => "Blague ajoutée avec succès !"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Échec de l'ajout de la blague !"]);
        }
    }
}