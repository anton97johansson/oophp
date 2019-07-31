<?php

// namespace Anjj16\Movie;

function getAll($app, $table)
{
    $sql = "SELECT * FROM $table;";
    $res = $app->db->executeFetchAll($sql);
    return $res;
}

function searchMovie($app, $params)
{
    $sql = "SELECT * FROM movie WHERE year LIKE ? OR title LIKE ?";
    $res = $app->db->executeFetchAll($sql, $params);
    return $res;
}

// function getGet($key, $default = null)
// {
//     return isset($_GET[$key])
//         ? $_GET[$key]
//         : $default;
// }
//
// function getPost($key, $default = null)
// {
//     return isset($_POST[$key])
//         ? $_POST[$key]
//         : $default;
// }

function esc($value)
{
    return htmlentities($value);
}

function editMovie($app, $params)
{
    $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
    $app->db->execute($sql, $params);
}

function getMovieByID($app, $id)
{
    $sql = "SELECT * FROM movie WHERE id = ?;";
    $res = $app->db->executeFetchAll($sql, $id);
    return $res[0];
}

function deleteMovie($app, $id)
{
    $sql = "DELETE FROM movie WHERE id = ?;";
    $app->db->execute($sql, $id);
}

function newMovie($app, $params)
{
    $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
    $app->db->execute($sql, $params);
}

function getPages($app)
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
