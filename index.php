<?php
require_once 'vendor/autoload.php';  // Composer autoload

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->contentType('application/json');
$db = new PDO('sqlite:data/database.sqlite');

// Routes
$resource = 'electricity_meter_reading';
$app->get("/$resource", function () use ($resource, $db, $app) {
  $results = getAll($resource, $db);
  echo json_encode($results);
});

$app->get("/$resource/:id", function ($id) use ($db, $app) {
  $results = getById($resource, $id, $db);
  echo json_encode($results);
});

$app->run();

function getAll($resource, $db) {
  $sth = $db->query("SELECT * FROM $resource;");
  return $sth->fetchAll(PDO::FETCH_CLASS);
}

function getById($resource, $id, $db) {
  $sth = $db->prepare("SELECT * FROM $resource WHERE id = ? LIMIT 1;");
  $sth->execute([intval($id)]);
  $sth->fetchAll(PDO::FETCH_CLASS)[0];
}
