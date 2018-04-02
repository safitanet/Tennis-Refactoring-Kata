<?php

class TennisGame1 implements TennisGame
{
    private $m_score1 = 0;
    private $m_score2 = 0;
    private $player1;
    private $player2;

    public function __construct($player1Name, $player2Name)
    {
        $this->player1 = new Player($player1Name);
        $this->player2 = new Player($player2Name);
    }

    public function wonPoint($playerName)
    {
        if ($this->player1->getName() == $playerName) {
            $this->m_score1++;
        } else {
            $this->m_score2++;
        }
    }

    public function getScore()
    {
        $score = "";
        if ($this->isTie()) {
            $score = Score::getDescriptionScoreTie($this->m_score1);
        } elseif ($this->theyAreOverThree()) {
            $score = $this->getDescriptionForAdvantageOrEndedGame($this->getDiffScores());
        } else {
            $score = Score::getDescriptionScore($this->m_score1);
            $score .= "-";
            $score .= Score::getDescriptionScore($this->m_score2);
        }
        return $score;
    }

    /**
     * @return bool
     */
    private function isTie(): bool
    {
        return $this->m_score1 == $this->m_score2;
    }

    /**
     * @return bool
     */
    private function theyAreOverThree(): bool
    {
        return $this->m_score1 >= 4 || $this->m_score2 >= 4;
    }

    /**
     * @return int
     */
    private function getDiffScores(): int
    {
        return $this->m_score1 - $this->m_score2;
    }

    /**
     * @param $minusResult
     *
     * @return string
     */
    private function getDescriptionForAdvantageOrEndedGame($minusResult): string
    {
        if ($minusResult == 1) {
            $score = "Advantage " . $this->player1->getName();
        } elseif ($minusResult == -1) {
            $score = "Advantage " . $this->player2->getName();
        } elseif ($minusResult >= 2) {
            $score = "Win for " . $this->player1->getName();
        } else {
            $score = "Win for " . $this->player2->getName();
        }
        return $score;
    }
}

class Score {
    const BASIC_SCORE = [0 => "Love", 1 => "Fifteen", 2 => "Thirty", 3 => "Forty"];
    const TIE_SCORE = [0 => "Love-All", 1 => "Fifteen-All", 2 => "Thirty-All", 3 => "Deuce"];

    /**
     * @param $score
     *
     * @return string
     */
    public static function getDescriptionScore($score): string
    {
        return self::BASIC_SCORE[$score];
    }

    /**
     * @param $score
     *
     * @return string
     */
    public static function getDescriptionScoreTie($score): string
    {
        $score = $score > 2 ? 3 : $score;
        return Score::TIE_SCORE[$score];
    }
}

class Player {
    private $name;
    private $score;

    public function __construct($name)
    {
        $this->name = $name;
        $this->score = 0;
    }

    public function getName()
    {
       return $this->name;
    }

}

