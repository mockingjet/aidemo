<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header("Content-Type:text/html; charset=utf-8");
// echo  $_FILES['file']['name'];

$result['data'] = array(
  'Total'=> 41,
  'Adenoma'=> "29|70",
  'Hyperplastic'=> "0|0",
  'Normal'=> "9|22",
  'Unknown'=> "3|7"
);
$result['image_file'] = "./0_result.jpg";
$result['predicts'] = array(
  0=> 70.7,
  1=> 5,
  2=> 17.3,
  3=> 7
);
$result['image_circles'] = array(
  0=> array('x'=>20,'y'=>45,'type'=>"Adenoma"),
  1=> array('x'=>45,'y'=>52,'type'=>"Adenoma"),
  2=> array('x'=>48,'y'=>5,'type'=>"Adenoma"),
  3=> array('x'=>50,'y'=>100,'type'=>"Adenoma"),
);
echo json_encode($result);