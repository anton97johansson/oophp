<?php
include(__DIR__. "/autoload.php");
include(__DIR__. "/config.php");


//game"]->{"number"});
//
if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
}
$game = $_SESSION["game"] ?? null;
$guess = $_SESSION["guess"] ?? null;
$doInit = $_SESSION["doInit"] ?? null;
$doGuess = $_SESSION["doGuess"] ?? null;
$doCheat = $_SESSION["doCheat"] ?? null;
$res = "";
$tries = $game->tries ?? null;
$number = $game->number ?? null;


if ($doGuess) {
    try {
        $res = $game->makeGuess((int)$guess);
        $tries = $game->tries;
        $_SESSION["doGuess"] = null;
    } catch (GuessException $e) {
        $res = "Nu gjorde du något fel :( Endast 1-100";
    }

    if ($res == "JARRÅÅÅ") {
        $tries = "vunnit, så inga mer";
    }
}
if ($doCheat) {
    $res = $number;
    $_SESSION["doCheat"] = null;
}
if ($doInit) {
    $_SESSION["game"] = new Guess();
    $tries = $_SESSION["game"]->{"tries"};
    // if (ini_get("session.use_cookies")) {
    //     $params = session_get_cookie_params();
    //     setcookie(session_name(), '', time() - 42000,
    //         $params["path"], $params["domain"],
    //         $params["secure"], $params["httponly"]
    //     );
    // }
    // session_destroy();
    $res = "spelet har startats om";
    $_SESSION["doInit"] = null;
}
require __DIR__ . "/view/guess_my_number.php";
