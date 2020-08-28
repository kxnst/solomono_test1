<?php
//Скрипт створений Костянтином Стадником
//https://github.com/kxnst/
$start = microtime(true);

$connection = new mysqli("localhost","root","","solomono");

$query = $connection->query("SELECT * FROM `categories`");

$tree = [];
while ($tmp = ($query->fetch_assoc())){
        if($tmp['parent_id']==0){
            $tree[$tmp['categories_id']] = array();
        }
        else{
            pushToId($tmp['parent_id'],$tree,$tmp['categories_id']);
        }
}
echo 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';

function pushToId($parentId,&$array,$val){
    foreach ($array as $key=>&$value){
        if($key==$parentId) {
            if(!is_array($value))
                $value = array($val=>$val);
            else{
                $value[$val] = $val;
            }
            return;
        }
        else if (is_array($value)){
            pushToId($parentId,$value,$val);
        }

    }
}
