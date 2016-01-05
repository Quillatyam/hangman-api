<?php
namespace AppBundle\Entity;

use Symfony\Component\Finder\Finder;

/**
 * Hangman
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
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
        $words = file(dirname(__FILE__) . '/words/'. chr(rand(65, 90)) . ' Words.txt');
        $this->word = str_replace(array("\r\n", "\r", "\n",), '', $words[array_rand($words) ]);
        $this->tries_left = 11;
        $this->status = 'busy';
        $this->guessed = array();
    }

    /**
     * Get Hangman as array
     *
     * @return array
     */
    public function getArray($obfuscate = true) {
        $data = array();
        $data['id'] = $this->id;
        $data['tries_left'] = $this->tries_left;
        $data['status'] = $this->status;
        $data['guessed_letters'] = $this->guessed;
        $data['word'] = $this->getWord($obfuscate);
        return $data;
    }

    public function updateStatus() {
        if ($this->status == 'busy') {
            if ($this->tries_left === 0) {
                $this->status = 'fail';
            }
            elseif ($this->getWord() === $this->getWord(false)) {
                $this->status = 'success';
            }
        }
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
    public function getWord($obfuscate = true) {
        $word = $this->word;
        if ($obfuscate) {
            $word = str_split($word);
            $replace = array();
            foreach ($word as $letter) {
                if (!in_array($letter, $this->guessed)) {
                    $replace[] = $letter;
                }
            }
            $word = str_replace($replace, '.', $this->word);
        }
        return $word;
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
     * Set guessed
     *
     * @param string $letter
     *
     * @return Hangman
     */
    public function addGuessed($letter) {
        $this->guessed[] = $letter;

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
