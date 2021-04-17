<?php

$server = new Swoole\Server('127.0.0.1', 9090, SWOOLE_BASE);
$process = new \Swoole\Process(function($process) use ($server) {
    while(1) {

        echo "here";

        $msg = json_decode($process->read(), true);



        $server->send($msg['fd'], $msg['data']);
    }
});

$server->set([
    'worker_num' => 1
]);

$server->on('receive', function($server, $fd, $rid, $data) use ($process) {

    echo 'receive $data';
    echo $data;

    $process->write(json_encode(['fd' => $fd, 'data' => $data]));
});


$server->addProcess($process);
$server->start();
