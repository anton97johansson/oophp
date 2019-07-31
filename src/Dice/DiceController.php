<?php

namespace Anjj16\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $this->app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */



    public function indexAction()
    {
        // Deal with the action and return a response.
        return $this->app->response->redirect("diceGame/init");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */


    public function initAction() : object
    {
        // init the session for the game start
        // $_SESSION["game"] = new DiceHandler();
        // $_SESSION["p1"] = new DiceHand();
        // $_SESSION["sum"] = null;
        // $_SESSION["latest"] = null;
        // init the session for the game start
        $this->app->session->set("game", new DiceHandler());
        $this->app->session->set("p1", new DiceHand());
        $this->app->session->set("hist", new Histogram());
        $this->app->session->set("sum", "empty");
        $this->app->session->set("latest", null);
        return $this->app->response->redirect("diceGame/play");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playAction() : object
    {
        $title = "Playing Dice 100";
        // $player = $_SESSION["p1"];
        // $game = $_SESSION["game"];
        // $latest = $_SESSION["latest"] ?? ["Nothing"];
        // $hand = $_SESSION["sum"] ?? "empty";
        // if (!$this->app->session->get("game")->isOver()) {
        //     return $this->app->response->redirect("diceGame/over");
        // }
        // $player = $this->app->session->get("p1");
        $game = $this->app->session->get("game");
        $latest = $this->app->session->get("latest", ["Nothing"]);
        $hand = $this->app->session->get("sum", "empty");
        // $v = implode(",", $game->getHistogramSerie());
        // echo "<script>console.log(".$v.");</script>";
        // var_dump($game->getHistogramSerie());
        // var_dump($player->allValues());
        $hist = $this->app->session->get("hist");
        // if ($hand == 0 || $hand != "empty") {
        //     $hand = " You got a 1, so computer drew cards";
        // }
        $data = [
            "throw" => $latest,
            "p1Score" => $game->getP1(),
            "p2Score" => $game->getP2(),
            "hand" => $hand,
            "histS" => implode(", ", $hist->getSerie()),
            "histT" => $hist->getAsText()
        ];

        $this->app->page->add("dice2/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("diceGame/play");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function againAction() : object
    {
        if (!$this->app->session->get("game")->isOver()) {
            $player = $this->app->session->get("p1");
            $game = $this->app->session->get("game");
            $player->roll();
            // $v = implode(",", $player->allValues());
            // var_dump($player->allValues());
            // echo "<script>console.log(".$v.");</script>";
            $this->app->session->set("latest", $player->values());
            $game->setSerie($player->allValues());
            $hist = $this->app->session->get("hist");
            $hist->injectData($game);
            if (in_array(1, $this->app->session->get("latest"))) {
                $player->resetValues();
                $game->resetSerie();
                $thr = $game->computerThrow();
                $hist->injectData($game);
                $game->resetSerie();
                $this->app->session->set("latest", $thr);
                $game->resetValues();
                //echo $game->computerThrow();
                $this->app->session->set("sum", 0);
                return $this->app->response->redirect("diceGame/play");
            }
            $sum = $this->app->session->get("sum");
            $sum += $player->sum();
            $this->app->session->set("sum", $sum);
            return $this->app->response->redirect("diceGame/play");
        }
        return $this->app->response->redirect("diceGame/over");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function saveAction() : object
    {

        if ($this->app->session->get("sum") != 0) {
            $hist = $this->app->session->get("hist");
            $game = $this->app->session->get("game");
            $player = $this->app->session->get("p1");
            $game->resetSerie();
            $this->app->session->get("game")->p1save($this->app->session->get("sum"));
            $this->app->session->set("sum", 0);
            $this->app->session->set("latest", $this->app->session->get("game")->computerThrow());
            $hist->injectData($game);
            $game->resetSerie();
            $game->resetValues();
            $player->resetValues();
        }
        return $this->app->response->redirect("diceGame/play");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     * @return string
     */
    public function overAction() : object
    {
        $title = "Done Dice 100";
        $this->app->page->add("Dice2/gameOver");
        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("diceGame/gameOver");
    }
}
