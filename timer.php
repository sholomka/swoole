<?php

$server = new Swoole\Server('127.0.0.1', 9090, SWOOLE_BASE);

$server->set(['worker_num' => 1]);

$server->on('start', function (Swoole\Server $server) {
    echo "start\n";

    Swoole\Timer::tick(100, function () {
        echo "timer tick\n";
    });
});


$server->on('receive', function () {


});

$server->start();