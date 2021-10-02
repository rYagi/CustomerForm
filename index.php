<?php
session_start();

require_once 'Controller/Routing.php';

$routing = new \Routing();
$routing->respond($routing->getPathInfo(), array('Routing','onError'));



