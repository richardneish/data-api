<?php
require_once 'vendor/autoload.php';  // Composer autoload

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->contentType('application/json');
$db = new PDO('sqlite:data/database.sqlite');

// Routes
$app->get('/electricity_meter_reading', function () use ($db, $app) {
  $sth = $db->query('SELECT * FROM electricity_meter_reading;');
  echo json_encode($sth->fetchAll(PDO::FETCH_CLASS));
});

$app->get('/electricity_meter_reading/:id', function ($id) use ($db, $app) {
  $sth = $db->prepare('SELECT * FROM electricity_meter_reading WHERE id = ? LIMIT 1;');
  $sth->execute([intval($id)]);
  echo json_encode($sth->fetchAll(PDO::FETCH_CLASS)[0]);
});


$app->run();
