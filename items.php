<?php
$item = array(
    "id"=>1,
    "name"=>"Cafe sữa",
    "detail"=>"cafe sữa ngon",
    "price"=>1
);
$item2 = array(
    "id"=>2,
    "name"=>"Cafe đá",
    "detail"=>"cafe đá ngon",
    "price"=>1
);
$item3 = array(
    "id"=>3,
    "name"=>"Sinh tố",
    "detail"=>"sinh tố ngon",
    "price"=>1
);
$item4 = array(
    "id"=>4,
    "name"=>"Sinh tố bơ",
    "detail"=>"sinh tố ngon",
    "price"=>1
);
//add item to product
$product = array($item,$item2,$item3,$item4);
//get id product
$id = $_GET['id'];
$order = array();
foreach($product as $key=>$value){
    if($value["id"]==$id){
        array_push($order,$product[$key]);
    }
}
//print_r($order);
