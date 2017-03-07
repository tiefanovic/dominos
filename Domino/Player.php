<?php
/**
 * Project    : dominos
 * Created by : Tiefa - 2017
 * Date       : 3/7/2017 - 1:07 PM
 * File       : player.php
 */

namespace Domino;


class Player
{
    private $name;
    private $score;

    function __construct($name = 'PC', $score = 0)
    {
        $this->name = $name;
        $this->score = $score;

    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function addScore($score)
    {
        $this->score += $score;
    }
    public function getScore()
    {
        return $this->score;
    }



}