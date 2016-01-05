<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Hangman;
use Symfony\Component\Debug\Debug;

class HangmanController extends Controller
{

    /**
     * @Route("/games")
     */
    public function gamesAction() {
        $hangmen = $this->getDoctrine()->getRepository('AppBundle:Hangman')->findAll();
        $data = array();
        foreach ($hangmen as $hangman) {
            $data[] = $hangman->getArray($hangman->getTriesLeft() > 0);
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/game/{id}", defaults={"id" = "new"})
     */
    public function showGameAction($id) {
        if ($id === 'new') {
            $hangman = new Hangman();
            $em = $this->getDoctrine()->getManager();

            $em->persist($hangman);
            $em->flush();
        }
        else {
            $hangman = $this->getDoctrine()->getRepository('AppBundle:Hangman')->find($id);
        }
        $data = $hangman->getArray($hangman->getTriesLeft() > 0);
        return new JsonResponse($data);
    }

    /**
     * @Route("/game/{id}/guess/{letter}", requirements={
     *     "letter": "[a-z]{1}"
     *     })
     */
    public function guessAction($id, $letter) {
        $hangman = $this->getDoctrine()->getRepository('AppBundle:Hangman')->find($id);
        if (!in_array($letter, $hangman->getGuessed())) {
            $hangman->addGuessed($letter);
            $word = str_split($hangman->getWord());
            if (!in_array($letter, $word)) {
                $hangman->setTriesLeft($hangman->getTriesLeft() - 1);
            }
        }
        $hangman->updateStatus();
        $em = $this->getDoctrine()->getManager();

        $em->persist($hangman);
        $em->flush();
        $data = $hangman->getArray($hangman->getTriesLeft() > 0);

        return new JsonResponse($data);
    }

    /**
     * @Route("/game/{id}/guess/word/{word}")
     */
    public function guessWordAction($id, $word) {
        $hangman = $this->getDoctrine()->getRepository('AppBundle:Hangman')->find($id);

        if ($word === $hangman->getWord(false)) {
            $hangman->setGuessed(str_split($word));
            $hangman->setStatus('success');
        }
        else {
            $hangman->setTriesLeft($hangman->getTriesLeft() - 1);
        }
        $hangman->updateStatus();

        $em = $this->getDoctrine()->getManager();

        $em->persist($hangman);
        $em->flush();
        $data = $hangman->getArray($hangman->getTriesLeft() > 0);

        return new JsonResponse($data);
    }
}
