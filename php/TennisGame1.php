<?php

class TennisGame1 implements TennisGame
{
    private $m_score1 = 0;
    private $m_score2 = 0;
    private $player1Name = '';
    private $player2Name = '';

    public function __construct($player1Name, $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
    }

    public function wonPoint($playerName)
    {
        if ('player1' == $playerName) {
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
            $minusResult = $this->m_score1 - $this->m_score2;
            if ($minusResult == 1) {
                $score = "Advantage player1";
            } elseif ($minusResult == -1) {
                $score = "Advantage player2";
            } elseif ($minusResult >= 2) {
                $score = "Win for player1";
            } else {
                $score = "Win for player2";
            }
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

