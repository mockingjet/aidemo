<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header("Content-Type:text/html; charset=utf-8");
// echo  $_FILES['file']['name'];

$result = array(
  array (
    'typename' =>'Adenoma',
    'dirpath' => './',
    'files' => array(
      "0" => "0_result.jpg",
      "1" => "1_Adenoma.jpg",
      "2" => "2_Adenoma.jpg",
      "3" => "2_Adenoma.jpg",
      "4" => "2_Adenoma.jpg",
      "5" => "2_Adenoma.jpg",
      "6" => "2_Adenoma.jpg",
      "7" => "2_Adenoma.jpg",
      "8" => "2_Adenoma.jpg",
      "9" => "2_Adenoma.jpg",
      "10" => "2_Adenoma.jpg",      
      "11" => "2_Adenoma.jpg",
      "12" => "2_Adenoma.jpg",
      "13" => "2_Adenoma.jpg",
      "14" => "2_Adenoma.jpg",
      "15" => "2_Adenoma.jpg",
      "16" => "2_Adenoma.jpg",
      "17" => "2_Adenoma.jpg",
    )
  ),
  array (
    'typename' =>'Hyperplastic',
    'dirpath' => './qwe/wqe/asd',
    'files' => array(
      "0" => "0_Hyperplastic.jpg",
      "1" => "1_Hyperplastic.jpg",
      "2" => "2_Hyperplastic.jpg",    
      "3" => "2_Hyperplastic.jpg",    
      "4" => "2_Hyperplastic.jpg",    
      "5" => "2_Hyperplastic.jpg",   
      "7" => "2_Adenoma.jpg",
      "8" => "2_Adenoma.jpg",
      "9" => "2_Adenoma.jpg",
      "10" => "2_Adenoma.jpg",      
      "11" => "2_Adenoma.jpg",
      "12" => "2_Adenoma.jpg",
      "13" => "2_Adenoma.jpg",
      "14" => "2_Adenoma.jpg",
      "15" => "2_Adenoma.jpg",
      "16" => "2_Adenoma.jpg",
      "17" => "2_Adenoma.jpg", 
    )
  ),
  array (
    'typename' => 'Normal',
    'dirpath' => './qwe/wqe/asd',
    'files' => array(
      "0" => "0_Normal",
      "1" => "1_Normal",
      "2" => "2_Normal"   
    ) 
  ),
  array (
    'typename' => 'Unknown',
    'dirpath' => './qwe/wqe/asd',
    'files' => array(
      "0" => "0_Unknown",
      "1" => "1_Unknown",
      "2" => "2_Unknown"    
    )
  )
);

echo json_encode($result);