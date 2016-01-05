<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Hangman;

class HangmanController extends Controller
{
    
    /**
     * @Route("/games")
     */
    public function gamesAction() {
        $hangmen = $this->getDoctrine()->getRepository('AppBundle:Hangman')->findAll();
        $data = array();
        foreach($hangmen as $hangman) {
            $data[] = array('id' => $hangman->getId(), 'word' => $hangman->getWord(), 'tries_left' => $hangman->getTriesLeft(), 'status' => $hangman->getStatus(), 'guessed_letters' => $hangman->getGuessed());
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
        $data = array('id' => $hangman->getId(), 'word' => $hangman->getWord(), 'tries_left' => $hangman->getTriesLeft(), 'status' => $hangman->getStatus(), 'guessed_letters' => $hangman->getGuessed());
        return new JsonResponse($data);
    }
    
    /**
     * @Route("/game/{id}/guess/{letter}", requirements={
     *     "letter": "[a-z]{1}"
     *     })
     */
    public function guessAction($id, $letter) {
        
        $data = array('word' => 'aw.so..', 'tries_left' => 11, 'status' => 'busy', 'guessed_letters' => array('a', 'w', 's', 'o',),);
        
        return new JsonResponse($data);
    }
}
