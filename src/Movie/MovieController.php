<?php

namespace Anjj16\Movie;

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
class MovieController implements AppInjectableInterface
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
         $title = "Movies";
         $this->app->db->connect();
         $data = [
             "res" => getAll($this->app, "movie")
         ];

         $this->app->page->add("movie/index", $data);

         return $this->app->page->render([
             "title" => $title,
         ]);
         return $this->app->response->redirect("movie");
    }

    public function searchActionGet()
    {
         $title = "Movie search";
         $search = null;
         $this->app->db->connect();
         $search = $this->app->request->getGet("searchMovie");
         $res = null;
        if ($search) {
             $res = searchMovie($this->app, ["%".$search."%", "%".$search."%"]);
        }
         $data = [
             "res" => $res,
             "searchMovie" => $search
         ];
         $this->app->page->add("movie/search", $data);

         return $this->app->page->render([
             "title" => $title,
         ]);
         return $this->app->response->redirect("movie/search");
    }

    public function editAction()
    {
         $title = "Editing a movie";
         $this->app->db->connect();
         $movieId    = $this->app->request->getPost("movieId") ?: $this->app->request->getGet("movieId");
         $movieTitle = $this->app->request->getPost("movieTitle");
         $movieYear  = $this->app->request->getPost("movieYear");
         $movieImage = $this->app->request->getPost("movieImage");
         $movie = getMovieByID($this->app, [$movieId]);
        if ($this->app->request->getPost("doSave")) {
             editMovie($this->app, [$movieTitle, $movieYear, $movieImage, $movieId]);
             return $this->app->response->redirect("movie");
        }
        if ($this->app->request->getPost("doDelete")) {
             deleteMovie($this->app, [$movieId]);
             return $this->app->response->redirect("movie");
        }
        $data = [
             "movie" => $movie
        ];
        $this->app->page->add("movie/edit", $data);

        return $this->app->page->render([
             "title" => $title,
        ]);
        return $this->app->response->redirect("movie/edit?movieId=$movieId");
    }

    public function newAction()
    {
        $this->app->db->connect();
         $title = "New";
         $movieTitle = $this->app->request->getPost("movieTitle");
         $movieYear  = $this->app->request->getPost("movieYear");
         $movieImage = $this->app->request->getPost("movieImage");
        if ($this->app->request->getPost("doNew")) {
             newMovie($this->app, [$movieTitle, $movieYear, $movieImage]);
             return $this->app->response->redirect("movie");
        }
        $this->app->page->add("movie/new");

        return $this->app->page->render([
             "title" => $title,
        ]);
        return $this->app->response->redirect("movie/new");
    }
}
