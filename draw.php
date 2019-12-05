<?php
require "json.php";
require "blackjack.php";

$streak = $json[$_SESSION['game']]['streak'];
arsort($json["highscores"]);
$player_points = $json[$_SESSION['game']]['player_points'];
$computer_points = $json[$_SESSION['game']]['computer_points'];
$action = $json[$_SESSION['game']]['action'];

if ($_POST['action'] == "draw") {

    echo $action . '&&&';

    echo '<div class="score">
        Streak:
        <span id="score">
        ' . $streak . '
        </span>
    </div>';



    echo '<div class="leaderboard flag">Antal spelare:   ' . sizeof($json['highscores']) . '
        <h2>Leaderboard</h2>
        <table>';
    if (count($json["highscores"]) > 9) {
        for ($i = 0; $i < 10; $i++) {
            echo "<tr><td>" . strval($i + 1) . ". " . array_keys($json["highscores"])[$i] . "</td><td>" . $json["highscores"][array_keys($json["highscores"])[$i]] . "</td></tr>";
        }
    } else {
        foreach ($json["highscores"] as $key => $value) {
            echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
        }
    }
    echo '</table>
</div>';




    echo '<main id="main">
    <div class="dealer">
        <h1>Dealer</h1>
        <div class="computerHand">
        <div class="playingCards">
            <ul class="hand">
                <li>
                    <a class="card rank-7 diams" href="#">
                        <span class="rank">7</span>
                        <span class="suit">&diams;</span>
                    </a>
                </li>
                <li>
                    <a class="card rank-8 hearts" href="#">
                        <span class="rank">8</span>
                        <span class="suit">&hearts;</span>
                    </a>
                </li>
                <li>
                    <a class="card rank-8 hearts" href="#">
                        <span class="rank">8</span>
                        <span class="suit">&hearts;</span>
                    </a>
                </li>
                <li>
                    <a class="card rank-j hearts" href="#">
                        <span class="rank">J</span>
                        <span class="suit">&hearts;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>';








    //     <div class="computer_hand">';
    // foreach ($json[$_SESSION['game']]['computer_cards'] as $card) {
    //     $value = substr($card, 1);
    //     $suit = substr($card, 0, 1);

    //     if ($suit == "c") {
    //         $suit_src = "utils/clubs.png";
    //     } else if ($suit == "h") {
    //         $suit_src = "utils/hearts.png";
    //     } else if ($suit == "d") {
    //         $suit_src = "utils/diamonds.png";
    //     } else {
    //         $suit_src = "utils/spades.png";
    //     }

    //     echo '<div class="card">
    //             <p>' . $value . '</p><img src="' . $suit_src . '">
    //         </div>';
    // }
    echo '
        </div>
    </div>
    <div class="player">
        <h1>Player</h1>
        <div class="playerHand">
        <div class="playingCards rotateHand">
            <ul class="hand">
                <li>
                    <a class="card rank-7 diams" href="#">
                        <span class="rank">7</span>
                        <span class="suit">&diams;</span>
                    </a>
                </li>
                <li>
                    <a class="card rank-8 hearts" href="#">
                        <span class="rank">8</span>
                        <span class="suit">&hearts;</span>
                    </a>
                </li>
                <li>
                    <a class="card rank-8 hearts" href="#">
                        <span class="rank">8</span>
                        <span class="suit">&hearts;</span>
                    </a>
                </li>
                <li>
                    <a class="card rank-j hearts" href="#">
                        <span class="rank">J</span>
                        <span class="suit">&hearts;</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>';

    //     <div class="player_hand">';
    // foreach ($json[$_SESSION['game']]['player_cards'] as $card) {
    //     $value = substr($card, 1);
    //     $suit = substr($card, 0, 1);

    //     if ($suit == "c") {
    //         $suit_src = "utils/clubs.png";
    //     } else if ($suit == "h") {
    //         $suit_src = "utils/hearts.png";
    //     } else if ($suit == "d") {
    //         $suit_src = "utils/diamonds.png";
    //     } else {
    //         $suit_src = "utils/spades.png";
    //     }

    //     echo '<div class="card">
    //             <p>' . $value . '</p><img src="' . $suit_src . '">
    //         </div>';
    // }
    echo '</div><div class="message">' . $json[$_SESSION['game']]['message'] . '</div>
</main>';
}
