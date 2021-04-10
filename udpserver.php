<?php

$server = new Swoole\Server("127.0.0.1", 9503, SWOOLE_BASE, SWOOLE_SOCK_UDP);

$server->on('packet', function($server, $data, $clientInfo) {
    $server->sendTo($clientInfo['address'], $clientInfo['port'], "Swoole: {$data}");
});

$server->start();