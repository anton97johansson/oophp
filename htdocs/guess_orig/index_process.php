<?php
include(__DIR__. "/autoload.php");
include(__DIR__. "/config.php");
//
// session_name("anjj16");
// session_start();
// if (!isset($_SESSION["game"])) {
//     $_SESSION["game"] = new Guess();
// }
// echo "<pre>";
// var_dump($_SESSION);
// // var_dump($_SESSION["game"]->{"number"});
//
// $game = $_SESSION["game"];
// $guess = $_POST["guess"] ?? null;
// $number = $game->number();
// $tries = $game->tries();
// $doInit = $_POST["doInit"] ?? null;
// $doGuess = $_POST["doGuess"] ?? null;
// $doCheat = $_POST["doCheat"] ?? null;


// // var_dump($_POST);
// var_dump($_POST);



$_SESSION["guess"] = $_POST["guess"] ?? null;
$_SESSION["doInit"] = $_POST["doInit"] ?? null;
$_SESSION["doGuess"] = $_POST["doGuess"] ?? null;
$_SESSION["doCheat"] = $_POST["doCheat"] ?? null;

header("Location: index.php");
