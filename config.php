<?php
$entities = [
 'countries'=>['name'=>'text','description'=>'textarea','season'=>'text','currency'=>'text','attractions'=>'textarea','image'=>'image','active'=>'bool'],
 'destinations'=>['country_id'=>'countries','name'=>'text','description'=>'textarea','location'=>'text','activities'=>'textarea','image'=>'image','active'=>'bool'],
 'hotels'=>['destination_id'=>'destinations','name'=>'text','description'=>'textarea','address'=>'text','stars'=>'number','facilities'=>'textarea','image'=>'image','featured'=>'bool','active'=>'bool'],
 'rooms'=>['hotel_id'=>'hotels','name'=>'text','description'=>'textarea','price'=>'decimal','capacity'=>'number','inventory'=>'number','image'=>'image','active'=>'bool'],
 'promotions'=>['code'=>'text','title'=>'text','description'=>'textarea','percent_off'=>'decimal','usage_limit'=>'number','starts_on'=>'date','ends_on'=>'date','active'=>'bool']
];
