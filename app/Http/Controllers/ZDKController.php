<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;

class ZDKController extends Controller
{

    public function index()
    {
        //  1 s't parameter is string $ip Device IP Address
        //  2 nd  parameter is integer $port Default: 4370

        // $zk = new ZKTeco('172.16.16.230');
        // $zk->connect();

        // $data = $zk->getAttendance();
        // $zk->disconnect();

        // return $data;

        // $zk->setUser(50, "157" , "mod", 14, "159753");
        // return   $zk->getUser();
        // return $zk->setUser();
        // return $zk->getAttendance();
        // return $zk->pinWidth();
        // return $zk->ssr();
        // return $zk->fmVersion();
        // return $zk->workCode();
        // $zk->serialNumber();
        // $zk->deviceName();
        // return $zk->getTime();
        // return  $zk->setTime("2022-02-09 15:10:24");
        // return $zk->testVoice();
        // return$zk->getUser();
        // return $zk->enableDevice();
        // return  $zk->platform();
        // return $zk->shutdown();
        // return $zk->removeUser(9);
        // return "DOne";
        // return$zk->getUser();

        // return  $zk->getAttendance();
        //  or you can use with port
        //    $zk = new ZKTeco('192.168.1.201', 8080);
        return "ارجع تاني";
    }
}
