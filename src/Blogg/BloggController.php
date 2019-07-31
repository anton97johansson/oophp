<?php

namespace Anjj16\Blogg;

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
class BloggController implements AppInjectableInterface
{
    use AppInjectableTrait;



    public function initAction ()
    {
        $this->app->db->connect();
        $this->app->session->set("blogg", new Blogg());
        $this->app->session->set("filter", new MyTextFilter());
        return $this->app->response->redirect("blogg");
    }
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
         $title = "blogg and posts";
         $this->app->db->connect();
         $this->app->session->set("blogg", new Blogg());
         $this->app->session->set("filter", new MyTextFilter());
         $blogg = $this->app->session->get("blogg");
         $data = [
             "res" => $blogg->getAll($this->app, "content"),
             // "app" => $this->app
         ];
         // $this->app->page->add("blogg/navbar");
         $this->app->page->add("blogg/navbar");
         $this->app->page->add("blogg/show-all", $data);

         return $this->app->page->render([
             "title" => $title,
         ]);
         return $this->app->response->redirect("blogg");
    }

    public function pageAction()
    {
        $this->app->db->connect();
        $pagePath = $this->app->request->getGet("page");
        $blogg = $this->app->session->get("blogg");
        $filter = $this->app->session->get("filter");
        $content = $blogg->getContent($this->app, [$pagePath, "page"]);
        if (!$content) {
            $this->app->page->add("blogg/404");
            $title = "404";
            return $this->app->page->render([
                "title" => $title,
            ]);
            return $this->app->response->redirect("blogg/page");
        }

        $title = $content->title;
        $data = [
            "content" => $content,
            "filter" => $filter
        ];
        // $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/page", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("blogg/page");
    }

    public function pagesAction()
    {
        $title = "Pages";
        $this->app->db->connect();
        $blogg = $this->app->session->get("blogg");
        $data = [
            "res" => $blogg->getPages($this->app)
        ];
        // $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/pages", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("blogg/pages");
    }

    public function postsAction()
    {
        $title = "Blogs";
        $this->app->db->connect();
        $filter = $this->app->session->get("filter");
        $blogg = $this->app->session->get("blogg");
        $data = [
            "res" => $blogg->getBlogs($this->app, ["post"]),
            "filter" => $filter
        ];
        $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/blog", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("blogg/blog");
    }

    public function blogpostAction()
    {
        $this->app->db->connect();
        $slug = $this->app->request->getGet("post");
        $blogg = $this->app->session->get("blogg");
        $filter = $this->app->session->get("filter");
        $slug = $blogg->slugify($slug);
        $content = $blogg->getPost($this->app, [$slug, "post"]);
        if (!$content) {
            $this->app->page->add("blogg/404");
            $title = "404";
            return $this->app->page->render([
                "title" => $title,
            ]);
            return $this->app->response->redirect("blogg/blogpost");
        }

        $title = $content->title;
        $data = [
            "content" => $content,
            "filter" => $filter
        ];
        // $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/blogpost", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("blogg/blogpost");
    }

    public function editAction()
    {
         $title = "Editing content";
         $this->app->db->connect();
         $contentId    = $this->app->request->getPost("contentId") ?: $this->app->request->getGet("contentId");
         $blogg = $this->app->session->get("blogg");
         $content = $blogg->getContentByID($this->app, [$contentId]);
         $contentTitle = $this->app->request->getPost("contentTitle");
         $contentPath  = $this->app->request->getPost("contentPath") ?: null;
         $contentSlug = $this->app->request->getPost("contentSlug");
         $contentData = $this->app->request->getPost("contentData");
         $contentType = $this->app->request->getPost("contentType");
         $contentFilter = $this->app->request->getPost("contentFilter") ?: null;
         $contentPublish = $this->app->request->getPost("contentPublish");
         if (!$contentSlug && $contentType == "post") {
             $contentSlug = $blogg->slugify($contentTitle);
         }
         if (!$contentPath) {
             if ($contentType == "post") {
                 $contentPath = "blogpost-".$contentId;
             }
             elseif ($contentType == "page") {
                 $contentPath = "page-".$contentId;
             }
         }
         $warning = "";

        if ((null !== $this->app->request->getPost("doSave"))) {
            $warning = "";
            if ($contentType == "post") {
                if ($blogg->controlSlug($this->app, $contentSlug,  $contentId)) {
                    $warning = "Change slug, two cant have same name";
                    // return $this->app->response->redirect("blogg/edit?contentId=".$contentId);
                }
                elseif (!$blogg->controlSlug($this->app, $contentSlug, $contentId) && $warning == "")
                {
                    $blogg->edit($this->app, [
                        $contentTitle,
                        $contentPath,
                        $contentSlug,
                        $contentData,
                        $contentType,
                        $contentFilter,
                        $contentPublish,
                        $contentId
                    ]);
                    return $this->app->response->redirect("blogg");
                }
            }
            elseif ($contentType == "page" && $warning == "") {
                $blogg->edit($this->app, [
                    $contentTitle,
                    $contentPath,
                    $contentSlug,
                    $contentData,
                    $contentType,
                    $contentFilter,
                    $contentPublish,
                    $contentId
                ]);
                return $this->app->response->redirect("blogg");
            }
            // "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        }
         $title = $content->title;
         $data = [
             "content" => $content,
             "warning" => $warning
         ];
         $this->app->page->add("blogg/navbar");
         $this->app->page->add("blogg/edit", $data);

         return $this->app->page->render([
             "title" => $title,
         ]);
         return $this->app->response->redirect("blogg/edit");
    }

    public function createAction()
    {
        $title = "Creating";
        $this->app->db->connect();
        $blogg = $this->app->session->get("blogg");
        if ((null !== $this->app->request->getPost("doCreate"))) {
            $id = $blogg->addTitle($this->app, $this->app->request->getPost("contentTitle"));
            return $this->app->response->redirect("blogg/edit?contentId=".$id);
        }
        $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/create");

        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("blogg/create");
    }

    public function deleteAction()
    {
        $title = "Deleting an entry";
        $this->app->db->connect();
        $contentId = $this->app->request->getGet("contentId");
        $blogg = $this->app->session->get("blogg");
        $content = $blogg->getContentByID($this->app, [$contentId]);
        if ((null !== $this->app->request->getPost("doDelete"))) {
            $blogg->deleteContent($this->app, $contentId);
            return $this->app->response->redirect("blogg/admin");
        }
        $data = [
            "content" => $content
        ];
        $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/delete", $data);
        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("blogg/delete");
    }

    public function adminAction()
    {
        $title = "Admin";
        $this->app->db->connect();
        $blogg = $this->app->session->get("blogg");
        $data = [
            "res" => $blogg->getAll($this->app, "content")
        ];
        $this->app->page->add("blogg/navbar");
        $this->app->page->add("blogg/admin", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("blogg/admin");
    }
}
