<?php
/**
 * Project    : dominos
 * Created by : Tiefa - 2017
 * Date       : 3/7/2017 - 2:15 PM
 * File       : Game.php
 */

namespace Domino;


class Game
{
    private $cards;

    function __construct($cards)
    {
        $this->cards = $cards;
        $_SESSION['role'] = 'human';
    }
    public function getPole()
    {
        $arr = [];
        $keys = array_keys($this->cards);
        if(count($this->cards) > 0){
            for($i=0; $i < 7; $i++){
                $card = array_rand($this->cards);
                $arr[$card] = $this->cards[$card];
                unset($this->cards[$card]);
            }
        }
        return $arr;
    }



}