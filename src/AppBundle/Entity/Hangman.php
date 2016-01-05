<?php
namespace AppBundle\Entity;

use Symfony\Component\Finder\Finder;

/**
 * Hangman
 */
class Hangman
{
    
    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var string
     */
    private $word;
    
    /**
     * @var integer
     */
    private $tries_left;
    
    /**
     * @var string
     */
    private $status;
    
    /**
     * @var array
     */
    private $guessed;
    
    public function __construct() {
        $finder = new Finder();
        $finder->in(__DIR__)->files()->name(chr(rand(65, 90)) . ' Words.txt');
        $finder = $finder->getIterator();
        $finder->rewind();
        $words = file(dirname(__FILE__).'/'.$finder->current()->GetRelativePathname()); 
        $this->word = str_replace(array("\r\n","\r","\n",), '', $words[array_rand($words)]);
        $this->tries_left = 11;
        $this->status = 'busy';
        $this->guessed = array();
    }
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Set word
     *
     * @param string $word
     *
     * @return Hangman
     */
    public function setWord($word) {
        $this->word = $word;
        
        return $this;
    }
    
    /**
     * Get word
     *
     * @return string
     */
    public function getWord() {
        if (count($this->guessed) > 0) return preg_replace('/[^' . implode('', $this->guessed) . ']+/', '', $this->word);
        else return $this->word;
    }
    
    /**
     * Set triesLeft
     *
     * @param integer $triesLeft
     *
     * @return Hangman
     */
    public function setTriesLeft($triesLeft) {
        $this->tries_left = $triesLeft;
        
        return $this;
    }
    
    /**
     * Get triesLeft
     *
     * @return integer
     */
    public function getTriesLeft() {
        return $this->tries_left;
    }
    
    /**
     * Set status
     *
     * @param string $status
     *
     * @return Hangman
     */
    public function setStatus($status) {
        $this->status = $status;
        
        return $this;
    }
    
    /**
     * Get status
     *
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }
    
    /**
     * Set guessed
     *
     * @param array $guessed
     *
     * @return Hangman
     */
    public function setGuessed($guessed) {
        $this->guessed = $guessed;
        
        return $this;
    }
    
    /**
     * Get guessed
     *
     * @return array
     */
    public function getGuessed() {
        return $this->guessed;
    }
}
