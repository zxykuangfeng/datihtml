<?php
require_once dirname(__DIR__).'/vendor/autoload.php';
use Workerman\Worker;

$clientNum=0;

$worker=new Worker("websocket://0.0.0.0:2345");

$worker->onMessage = function($connection, $data)use($worker)
{
    if($data=='heartbeat'){
        $connection->send("ok");
        return;
    }

    if(isset($worker->browser)){
        $worker->browser->send($data);
    }

    if($data=='browser'){
        echo "browser into \n";
        $worker->browser=$connection;
    }

};

$worker->onConnect = function($connection)use(&$clientNum,$worker)
{
    $clientNum++;
    echo "connect [total:$clientNum] ".date('Y-m-d H:i:s')." \n";

    $connection->onWebSocketConnect = function($connection)
    {
        // 当websocket连接建立起来后，向客户端发送数据
        $connection->send('connect success');
    };


};

$worker->onClose = function($connection)use(&$clientNum,$worker)
{
    $clientNum--;
    echo "close  [total:$clientNum] ".date('Y-m-d H:i:s')."\n";

    // var_dump(count($worker->connections));

};


Worker::runAll();
