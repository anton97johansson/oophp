<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * init the game and redirect to play the game
 */
$app->router->get("dice/init", function () use ($app) {
    // init the session for the game start
    $_SESSION["game"] = new Anjj16\Dice\DiceHandler();
    $_SESSION["p1"] = new Anjj16\Dice\DiceHand();
    $_SESSION["sum"] = null;
    $_SESSION["latest"] = null;
    return $app->response->redirect("dice/play");
});


$app->router->get("dice/play", function () use ($app) {
    $title = "Playing Dice 100";
    $p1 = $_SESSION["p1"];
    $game = $_SESSION["game"];
    $latest = $_SESSION["latest"] ?? ["Nothing"];
    $hand = $_SESSION["sum"] ?? "empty";
    $data = [
        "throw" => $latest,
        "p1Score" => $game->getP1(),
        "p2Score" => $game->getP2(),
        "hand" => $hand
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
    return $app->response->redirect("dice/play");
});

$app->router->get("dice/save", function () use ($app) {
    if ($_SESSION["sum"] != 0) {
        $_SESSION["game"]->p1save($_SESSION["sum"]);
        $_SESSION["sum"] = 0;
        $_SESSION["latest"] = $_SESSION["game"]->computerThrow();
    }
    return $app->response->redirect("dice/play");
});

$app->router->get("dice/again", function () use ($app) {
    if (!$_SESSION["game"]->isOver()) {
            $p1 = $_SESSION["p1"];
        $game = $_SESSION["game"];
        $p1->roll();
        $_SESSION["latest"] = $p1->values();
        if (in_array(1, $_SESSION["latest"])) {
            $_SESSION["latest"] = $game->computerThrow();
            //echo $game->computerThrow();
            $_SESSION["sum"] = 0;
            return $app->response->redirect("dice/play");
        }
        $_SESSION["sum"] += $p1->sum();
        return $app->response->redirect("dice/play");
    }
    return $app->response->redirect("dice/gameOver");
});

$app->router->get("dice/gameOver", function () use ($app) {
    $title = "Done Dice 100";
    $app->page->add("Dice/gameOver");
    return $app->page->render([
        "title" => $title,
    ]);
    return $app->response->redirect("dice/gameOver");
});
