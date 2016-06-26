<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ob_start();
session_start();

define('PROJECT_NAME', 'Login System with facebook using PHP and MySQL - www.thesoftwareguy.in');

define('DB_DRIVER', 'mysql');
define('DB_SERVER', 'mysql.hostinger.in');
define('DB_SERVER_USERNAME', 'u695643516_slamy');
define('DB_SERVER_PASSWORD', 'root123');
define('DB_DATABASE', 'u695643516_slamy');

$dboptions = array(
    PDO::ATTR_PERSISTENT => FALSE,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try {
  //$DB = new PDO(DB_DRIVER . ':host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, $dboptions);
  $DB = mysqli_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD,DB_DATABASE) or die('Unable to Connect');
} catch (Exception $ex) {
  echo $ex->getMessage();
  die;
}

/* * ***** facebook related activities start ** */
require 'facebook_library/facebook.php';

define("APP_ID", "1630950993891462");
define("APP_SECRET", "98bd3d82a1908a44a230801add91e4de");
/* make sure the url end with a trailing slash */
define("SITE_URL", "http://greencube.16mb.com/fb_log/");
/* the page where you will be redirected after login */
define("REDIRECT_URL", SITE_URL."facebook_login.php");
/* Email permission for fetching emails. */
define("PERMISSIONS", "email");


/*  If database connection is OK, then proceed with facebook * */
// create a facebook object
$facebook = new Facebook(array('appId' => APP_ID, 'secret' => APP_SECRET));
$userID = $facebook->getUser();

// Login or logout url will be needed depending on current user login state.
if ($userID) {
  $logoutURL = $facebook->getLogoutUrl(array('next' => SITE_URL . 'logout.php'));
} else {
  $loginURL = $facebook->getLoginUrl(array('scope' => PERMISSIONS, 'redirect_uri' => REDIRECT_URL));
}
?>