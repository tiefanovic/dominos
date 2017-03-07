<?php

session_start();
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
use Domino\Card;
use Domino\Player;
use Domino\Game;
//Generating All Cards
$cards = [];
for($i=0; $i<= 6; $i++){
    for($j=0; $j <=6; $j++ ){
        if(isset($cards[$j."/".$i])) continue;
        $cards[$i."/".$j ] = (new Card($i, $j))->getImage() ;
    }
}
if(!isset($_SESSION['game']))
$game = new Game($cards);

$_SESSION['card1'] = isset($_SESSION['card1']) ? $_SESSION['card1'] : $game->getPole();
$_SESSION['card2'] = isset($_SESSION['card2']) ? $_SESSION['card2'] : $game->getPole();
$_SESSION['card3'] = isset($_SESSION['card3']) ? $_SESSION['card3'] : $game->getPole();
$_SESSION['card4'] = isset($_SESSION['card4']) ? $_SESSION['card4'] :$game->getPole();
$_SESSION['ground'] = isset($_SESSION['ground']) ? $_SESSION['ground'] : null ;


/*
 * Creating players
 */
$player1 = new Player('Ahmed', 0);
$player2 = new Player('PC1', 0);
$player3 = new Player('PC2', 0);
$player4 = new Player('PC3', 0);


// Post Form
function match($card)
{
    if( isset($_SESSION['ground'])){
        end($_SESSION['ground']);
        $last = key($_SESSION['ground']);
        $data = explode('/', $last);
        $data2 = explode('/', $card);
        if( $data2[1] == $data[1] || $data2[0] == $data[1] )
            return true;
        return false;
    }
    return true;
}
if(isset($_POST['play']))
{

$role = $_SESSION['role'];
    switch ($role)
    {
        case 'human':

            $nums = explode('/', $_POST['card']);
            if(match($_POST['card']) ){
                $_SESSION['ground'][$_POST['card']] = (new Card($nums[0], $nums[1]))->getImage();
                unset($_SESSION['card1'][$_POST['card']]);
            }
            $_SESSION['role'] = 'card2';
            break;
        case 'card2':

            $matched = [];
            foreach($_SESSION['card2'] as $card => $val){
              if(match($card)) $matched[] = $card;
            }
            if( count($matched) > 0 )
                $played = array_rand($matched);
            $nums = explode('/', $played);
            if(match($_POST['card']) ){
                $_SESSION['ground'][$played] = (new Card($nums[0], $nums[1]))->getImage();
                unset($_SESSION['card1'][$played]);
            }
            $_SESSION['role'] = 'card3';
            break;
        case 'card3':
            $nums = explode('/', $_POST['card']);
            if(match($_POST['card']) ) {
                $_SESSION[ 'ground' ][ $_POST[ 'card' ] ] = (new Card($nums[0], $nums[1]))->getImage();
                unset( $_SESSION[ 'card1' ][ $_POST[ 'card' ] ] );
            }
            $_SESSION['role'] = 'card4';
            break;
        case 'card4':
            $nums = explode('/', $_POST['card']);
            if(match($_POST['card']) ) {
                $_SESSION[ 'ground' ][ $_POST[ 'card' ] ] = (new Card($nums[0], $nums[1]))->getImage();
                unset( $_SESSION[ 'card1' ][ $_POST[ 'card' ] ] );
            }
            $_SESSION['role'] = 'human';
            break;
    }

}
if(isset($_POST['nGame'])){
    unset($_SESSION['game'] );
    unset($_SESSION['card1'] );
    unset($_SESSION['card2'] );
    unset($_SESSION['card3'] );
    unset($_SESSION['card4'] );
    unset($_SESSION['ground'] );
    unset($_SESSION['role'] );

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dominos</title>
    <style>
        .playground{
            min-height: 600px;
            width: auto;
            background-color: cadetblue;
            display: block;
            color: magenta;

        }
        .players span{
            color: chocolate;
        }
        .card{
            border: 1px solid #0f0f0f;
            margin: 2px;
        }
    </style>
</head>
<body>
<div class=playground">

    <?php

    if( isset($_SESSION['ground'])) {
        foreach ( $_SESSION[ 'ground' ] as $card => $image ) {
            echo "<img class='card' src='data:image/jpeg;base64," . base64_encode( $image ) . "'>";
        }
    }
    echo $_SESSION['role'];?>
</div>
<div class="players">
<form method="post" action=""">
<div id="player1">
    <span><?= $player1->getName(); ?> : <?= $player1->getScore(); ?></span><br />
<div id="cards">
    <?php
    foreach($_SESSION['card1'] as $card => $image){

        echo "<img id='card' class='card' src='data:image/jpeg;base64," . base64_encode( $image )."'>";
        echo '<input type="radio" class="radio_item" value = "'.$card.'" name="card" id="radio1">';
    } ?></div>
</div>
<div id="player2">
    <span>Player2 Name : </span><?= $player2->getName(); ?><br />
    <span id="score1">Score : </span><?= $player1->getScore(); ?><br />
    <div id="cards">
        <?php
        foreach($_SESSION['card2'] as $card => $image){
            echo "<img id='card' value = '".$card."'class='card' src='data:image/jpeg;base64," . base64_encode( $image )."'>";
        } ?>

    </div>
</div>
<div id="player3">
    <span>Player3 Name : </span><?= $player3->getName(); ?><br />
    <span id="score1">Score : </span><?= $player1->getScore(); ?><br />
    <div id="cards">
        <?php
        foreach($_SESSION['card3'] as $card => $image){
            echo "<img id='card' value = '".$card."' class='card' src='data:image/jpeg;base64," . base64_encode( $image )."'>";
        } ?>
    </div>
</div>
<div id="player4">
    <span>Player4 Name : </span><?= $player4->getName(); ?><br />
    <span id="score1">Score : </span><?= $player1->getScore(); ?><br />
    <div id="cards">
        <?php
        foreach($_SESSION['card4'] as $card => $image){
            echo "<img id='card' value = '".$card."' class='card' src='data:image/jpeg;base64," . base64_encode( $image )."'>";
        } ?>
    </div>
</div>
    <button type="submit" name="play"><?= $_SESSION['role'];?> </button>
    <button type="submit" name="nGame">New Game</button>
</form>
</div>
</body>
</html>
