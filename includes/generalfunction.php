<?php 

function dateCheck($date){
    if(date('Y', strtotime($date)) < 2000){
        $result = "--";
    }else{
        $result = date('M d', strtotime($date));
    }
    return $result;
}