<?php
require_once __DIR__ . '/router.php';

require 'api/activities/randomActivities.php';
require 'api/activities/getAllActivities.php';
require 'api/activities/activity.php';
require 'api/activities/filterActivities.php';
require 'api/activities/addActivity.php';
require 'api/activities/updateActivity.php';

// Routes en GET
get('/api/activities/random', function () {
  getRandomActivities();
});

get('/api/activities/filter', function () {
  filterActivities();
});

get('/api/activities/all', function () {
  getAllActivities();
});

get('/api/activities/$id)', function () {
  activity();
}); 


get('/404', '/404.php');

// Routes en POST
post('/api/activities', function () {
  addActivity();
});

post('/404', '/404.php');

// Routes en PUT
put('/api/activities/$id', function () {
  updateActivity();
});

put('/404', '/404.php');
?>
