<?php


namespace app\Models;


class Activity
{

    function writeActivity($activity){
        $file = fopen("app/data/activity-log.txt", "a");

        $string = basename($_SERVER['REQUEST_URI']) . "\t" . date("d.m.Y H:i:s") . "\t" . $_SERVER['REMOTE_ADDR']  . "\t" . $activity . "\n";

        fwrite($file, $string);
        fclose($file);

    }
    public function loggedUser(){
        $file=fopen("app/data/logged-users.txt","r");
        $data=file("app/logged-users.txt");
        @$number=intval(trim($data[0]));
        if($number=='undefined'){
            $number=0;
        }
        fclose($file);
        $file=fopen("app/data/logged-users.txt","w");
        $number++;
        fwrite($file,$number);
        fclose($file);
    }
    function loggedOutUser(){
        $file = fopen("app/data/logged-users.txt","r");
        $data=file("app/data/logged-users.txt");
        @$number=intval(trim($data[0]));

        fclose($file);
        $file=fopen("app/data/logged-users.txt","w");
        $number--;
        fwrite($file,$number);
        fclose($file);
    }
    function loggedUsersNum(){
        $file=fopen("app/data/logged-users.txt","r");
        $data=file("app/data/logged-users.txt");
        @$number=trim($data[0]);
        if($number=='undefined'){
            $number=0;
        }
        fclose($file);
        return $number;
    }
}