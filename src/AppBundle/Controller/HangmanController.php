<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class HangmanController
{

    /**
     * @Route("/games/{id}", defaults={"id" = "*"})
     */
    public function gamesAction($game_id) {

        $data = array('games' => $game_id, 'lucky_number' => rand(0, 100),);

        return new JsonResponse($data);
    }

    /**
     * @Route("/game/{id}", defaults={"id" = "new"})
     */
    public function showGameAction($id) {

        $data = array('lucky_number' => rand(0, 100),);

        return new JsonResponse($data);
    }

    /**
     * @Route("/game/{id}/guess/{letter}", requirements={
     *     "letter": "[a-z]{1}"
     *     })
     */
    public function guessAction($id, $letter) {

        $data = array('lucky_number' => rand(0, 100),);

        return new JsonResponse($data);
    }
}
