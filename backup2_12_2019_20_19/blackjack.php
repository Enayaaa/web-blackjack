<?php
//requirements etc
session_start();
require_once "json.php";

// Definitions
$suits = array("c", "h", "d", "s");
$values = array(
  "A",
  "2",
  "3",
  "4",
  "5",
  "6",
  "7",
  "8",
  "9",
  "10",
  "J",
  "Q",
  "K"
);

// ___________________________________________________________________________________________________

// print_r($_POST);
// On new game start
if ($_POST['action'] == "newgame" && isset($_POST['player'])) {
  $_SESSION['game'] = $_POST['game'];
  $_SESSION['running'] = true;
  $_SESSION['won'] = false;
  $json[$_SESSION['game']]['message'] = "";
  $json[$_SESSION['game']]['action'] = "";
  $json[$_SESSION['game']]['streak'] = 0;
  $_SESSION['deck'] = newdeck($suits, $values);
  $json[$_SESSION['game']]['player_cards'] = array(get_ran_card(), get_ran_card());
  $json[$_SESSION['game']]['computer_cards'] = array(get_ran_card(), get_ran_card());
  $json[$_SESSION['game']]['computer_points'] = count_points($json[$_SESSION['game']]['computer_cards']);
  $json[$_SESSION['game']]['player_points'] = count_points($json[$_SESSION['game']]['player_cards']);
  $json[$_SESSION['game']]['username'] = $_POST['player'];
  echo $json[$_SESSION['game']]['username'];
  save_json($json);
  // print_r($_SESSION);
}
if ($_POST['action'] == "restart" && $_SESSION['running'] == false) {
  $_SESSION['running'] = true;
  $_SESSION['won'] = false;
  $a = sizeof($json[$_SESSION['game']]['player_cards']);
  $b = sizeof($json[$_SESSION['game']]['computer_cards']);
  $json[$_SESSION['game']]['message'] = "";
  $json[$_SESSION['game']]['action'] = "";
  $_SESSION['deck'] = newdeck($suits, $values);
  $json[$_SESSION['game']]['player_cards'] = array(get_ran_card(), get_ran_card());
  $json[$_SESSION['game']]['computer_cards'] = array(get_ran_card(), get_ran_card());
  $json[$_SESSION['game']]['computer_points'] = count_points($json[$_SESSION['game']]['computer_cards']);
  $json[$_SESSION['game']]['player_points'] = count_points($json[$_SESSION['game']]['player_cards']);
  save_json($json);
}


// On Actions

if ($_POST['action'] == "hit") {

  if ($json[$_SESSION['game']]['player_points'] <= 21) {
    array_push($json[$_SESSION['game']]['player_cards'], get_ran_card());
    $json[$_SESSION['game']]['player_points'] = count_points($json[$_SESSION['game']]['player_cards']);
    echo $json[$_SESSION['game']]['player_points'];
    save_json($json);
    if ($json[$_SESSION['game']]['player_points'] > 21) {
      computer_turn($json);
      echo get_results($json);
    }
  } else {
    computer_turn($json);
    echo get_results($json);
  }
} else if ($_POST['action'] == "stand") {
  // computer draws card
  computer_turn($json);
}


if ($_POST['action'] == "terminate") {
  unset($json[$_POST['game']]);
  save_json($json);
}

// ___________________________________________________________________________________________________


// Initial and required functions

function newdeck($suits, $values)
{
  $new = array();
  foreach ($suits as $suit) {
    foreach ($values as $value) {
      array_push($new, $suit . $value);
    }
  }
  shuffle($new);
  return $new;
}

// _______________________________

function get_ran_card()
{
  // require('json.php');
  $card = array_shift($_SESSION['deck']);
  shuffle($_SESSION['deck']);
  return $card;
}


// ___________________________________________________________________________________________________


// Main game functions

function computer_turn($json)
{
  $json[$_SESSION['game']]['computer_points'] = count_points($json[$_SESSION['game']]['computer_cards']);
  while ($json[$_SESSION['game']]['computer_points'] < 17) {
    array_push($json[$_SESSION['game']]['computer_cards'], get_ran_card());
    $json[$_SESSION['game']]['computer_points'] = count_points($json[$_SESSION['game']]['computer_cards']);
  }

  $json[$_SESSION['game']]['action'] = "restart";
  save_json($json);
  echo get_results($json);
}




function count_points($cards)
{
  $asses = [];
  $value = 0;
  foreach ($cards as $card) {
    $value_str = substr($card, 1);
    if ($value_str == "J" || $value_str == "Q" || $value_str == "K") {
      $value += 10;
    } elseif ($value_str == "A") {
      array_push($asses, $card);
      $index = array_search($card, $cards);
      if (isset($index)) {
        unset($cards[$index]);
      }
    } else {
      $value += intval($value_str);
    }
  }
  if ($asses != []) {
    if ($value + 11 > 21) {
      $value += 1;
    } else {
      $value += 11;
    }
  }
  return $value;
}




function get_results($json)
{
  $json[$_SESSION['game']]['computer_points'] = count_points($json[$_SESSION['game']]['computer_cards']);
  $json[$_SESSION['game']]['player_points'] = count_points($json[$_SESSION['game']]['player_cards']);

  if ($json[$_SESSION['game']]['player_points'] > 21) {
    $m = "You busted!";
    $win = 0;
  } elseif ($json[$_SESSION['game']]['computer_points'] > 21) {
    $m = "Computer busted";
    $win = 1;
  } elseif ($json[$_SESSION['game']]['computer_points'] == $json[$_SESSION['game']]['player_points']) {
    $m = "It's a draw!";
    $win = 2;
  } elseif ($json[$_SESSION['game']]['player_points'] == 21) {
    $m = "You got blackjack!";
    $win = 1;
  } elseif ($json[$_SESSION['game']]['computer_points'] == 21) {
    $m = "Computer got blackjack";
    $win = 0;
  } elseif ($json[$_SESSION['game']]['player_points'] > $json[$_SESSION['game']]['computer_points']) {
    $m = "You are closer to 21, you win!";
    $win = 1;
  } elseif ($json[$_SESSION['game']]['computer_points'] > $json[$_SESSION['game']]['player_points']) {
    $m = "Computer is closer to 21, computer wins";
    $win = 0;
  } else {
    $m = "Exeption occured!";
  }

  if ($win == 1) {
    if ($_SESSION['won'] != true) {
      $json[$_SESSION['game']]['streak']++;
    }
    $_SESSION['won'] = true;
  } elseif ($win == 0) {
    $json[$_SESSION['game']]['streak'] = 0;
  }

  $_SESSION['running'] = false;
  $json[$_SESSION['game']]['message'] = $m;
  $json[$_SESSION['game']]['action'] = "restart";
  save_json($json);
  update_leaderboard($json);
  unset($_SESSION[$_SESSION['game']]);
  return $m;
}


function update_leaderboard($json)
{
  $streak = $json[$_SESSION['game']]['streak'];
  $record = $json['highscores'][$json[$_SESSION['game']]['username']];
  if ($streak > $record) {
    $json['highscores'][$json[$_SESSION['game']]['username']] = $json[$_SESSION['game']]['streak'];
  }
  save_json($json);
}
