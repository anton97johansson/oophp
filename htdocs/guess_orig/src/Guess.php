<?php
/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */



    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->number = $number;
        if ($this->number == -1) {
            $this->random();
        }
        $this->tries = $tries;
    }




    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */

    public function random()
    {
        $this->number = rand(1, 100);
    }




    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */

    public function tries() : int
    {
        return $this->tries;
    }




    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */

    public function number() : int
    {
        return $this->number;
    }




    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess(int $number) : string
    {
        $res = "";

        if ($number > 100 | $number < 1) {
            throw new GuessException("DIN GISSNING VAR UTANFÖR UNIVERSIUM.");
        }
        if ($this->tries == 0) {
            $res = "INGA MER GISSNINGAR, KOMPIS";
        } elseif ($number <= 100 | $number >= 1) {
            if ($number == $this->number) {
                $res = "JARRÅÅÅ";
                $this->tries -= 1;
            } elseif ($number < $this->number) {
                $res = "GISSA HÖGRE, KOMPIS";
                $this->tries -= 1;
            } elseif ($number > $this->number) {
                $res = "TAGGA NER LITE, GISSA LÄGRE";
                $this->tries -= 1;
            }
        }
        return $res;
    }
}

// $game = new Guess();
//
// echo $game->number();
// echo $game->makeGuess($game->number());
