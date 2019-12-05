<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css?family=Calistoga|Roboto+Slab&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="cards.css" media="screen" />
    <title>Blackjack</title>
</head>

<body>
    <div class="rules flag">
        You are playing against the computer.<br>
        Closest to 21 wins.<br>
        The dealer draws from deck until it's cards are more than 17.<br>
        A is worth 11 or 1.<br>
        J, Q and K are worth 10.<br>
        the rest are worth its value.<br>
        Good luck!
    </div>
    <div id="canvas">
    </div>
    <div class="control">
        <div class="button" id="button1">Play</div>
        <div class="button" id="button2">Hit</div>
        <div class="button" id="button3">Stand</div>
    </div>
    <script src="main.js">
    </script>
</body>

</html>