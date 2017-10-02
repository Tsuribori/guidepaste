<?php
require "config.php";

$account = $_GET["id"];

if (($account_cookie = $_COOKIE["Login"]) && ($password_cookie = $_COOKIE["Password"])) {
   
   
