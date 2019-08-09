<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header("Content-Type:text/html; charset=utf-8");
$result[0] = "param";
$result[1] = "param";
$result[2] = "param";
$result[3] = "param";
$result[4] = "param";
$result[5] = "param";

echo json_encode($result);
