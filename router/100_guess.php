<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for the game start
    $_SESSION["game"] = new Anjj16\Guess\Guess();
    $game = $_SESSION["game"];
    return $app->response->redirect("guess/play");
});



/**
 * show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Gibba";
    $res = $_SESSION["res"] ?? null;
    $tries = $game->tries ?? null;
    $_SESSION["res"] = null;
    $data = [
        "guess" => $guess ?? null,
        "doGuess" => $doGuess ?? null,
        "tries" => $_SESSION["game"]->{"tries"},
        "number" => $_SESSION["game"]->{"number"},
        "res" => $res

    ];

    $app->page->add("guess/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    // echo "Some debugging information";
    // $title = "Gibba";
    $game = $_SESSION["game"];
    $guess = $_POST["guess"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $res = "";
    $tries = $game->tries ?? null;
    $number = $game->number ?? null;

    if ($doGuess) {
        try {
            $res = $game->makeGuess((int)$guess);
            $_SESSION["game"]->{"tries"} = $game->tries;
            $_POST["doGuess"] = null;
        } catch (Anjj16\Guess\GuessException $e) {
            $res = "Nu gjorde du något fel :( Endast 1-100";
        }

        if ($res == "JARRÅÅÅ") {
            $_SESSION["game"]->{"tries"} = "vunnit, så inga mer";
        }
        $_SESSION["res"] = $res;
    }
    return $app->response->redirect("guess/play");
});

$app->router->get("guess/cheat", function () use ($app) {
    $title = "Fuska sida";
    $res = $_SESSION["game"]->{"number"};
    $data = [
        "res" => $res
    ];

    $app->page->add("guess/cheat", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
