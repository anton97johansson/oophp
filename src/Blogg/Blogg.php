<?php
namespace Anjj16\Blogg;

class Blogg {
    public function getPages($app)
    {
        $sql = <<<EOD
SELECT
*,
CASE
    WHEN (deleted <= NOW()) THEN "isDeleted"
    WHEN (published <= NOW()) THEN "isPublished"
    ELSE "notPublished"
END AS status
FROM content
WHERE type=?
;
EOD;
        $res = $app->db->executeFetchAll($sql, ["page"]);
        return $res;
    }

    public function getAll($app, $table)
    {
        $sql = "SELECT * FROM $table;";
        $res = $app->db->executeFetchAll($sql);
        return $res;
    }

    public function saveContent($app, $params) {
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $app->db->execute($sql, $params);
    }

    public function getContent($app, $params) {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $res = $app->db->executeFetch($sql, $params);
        return $res;
    }

    public function getBlogs($app, $params)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
EOD;

    $res = $app->db->executeFetchAll($sql, $params);
    return $res;
    }

    public function getPost($app, $params) {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        $res = $app->db->executeFetch($sql, $params);
        return $res;
    }

    public function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    public  function getContentByID($app, $id)
    {
        $sql = "SELECT * FROM content WHERE id = ?;";
        $res = $app->db->executeFetchAll($sql, $id);
        return $res[0];
    }

    public function addTitle($app, $title)
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $app->db->execute($sql, [$title]);
        $id = $app->db->lastInsertId();
        return $id;
    }

    public function edit($app, $params)
    {
        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $app->db->execute($sql, $params);
    }

    public function controlSlug($app, $slug, $id)
    {
        $sql = "SELECT slug, id FROM content;";
        $res = $app->db->executeFetchAll($sql);
        foreach ($res as $row) {
            if ($row->slug == $slug && $id != $row->id) {
                return true;
            }
        }
        return false;
    }

    public function deleteContent($app, $id)
    {
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $app->db->execute($sql, [$id]);
    }
}
