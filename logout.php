<?php
require_once "./inclu/pdo.php";
session_destroy();

header("location: index.php");
