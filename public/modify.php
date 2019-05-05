<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header("Content-Type:text/html; charset=utf-8");
// echo  $_FILES['file']['name'];
$result['image_file'] = "http://localhost/AIDemo/public/0_result.jpg";

echo json_encode($result);