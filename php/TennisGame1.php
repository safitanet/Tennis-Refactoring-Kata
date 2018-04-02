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
            $score = $this->getDescriptionScoreTie();
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
            $score = $this->getDescriptionScore($this->m_score1);
            $score .= "-";
            $score .= $this->getDescriptionScore($this->m_score2);
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
     * @param $tempScore
     * @return string
     */
    private function getDescriptionScore($tempScore): string
    {
        return Score::BASIC_SCORE[$tempScore];
    }

    /**
     * @return string
     */
    private function getDescriptionScoreTie(): string
    {
        switch ($this->m_score1) {
            case 0:
                $score = "Love-All";
                break;
            case 1:
                $score = "Fifteen-All";
                break;
            case 2:
                $score = "Thirty-All";
                break;
            default:
                $score = "Deuce";
                break;
        }
        return $score;
    }
}

class Score {
    const BASIC_SCORE = [0 => "Love", 1 => "Fifteen", 2 => "Thirty", 3 => "Forty"];
}

