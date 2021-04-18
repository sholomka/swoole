<?php

use Swoole\Websocket\Server;

$server = new Server('0.0.0.0', 9501);

$server->on('start', function() {

});
$server->on('open', function() {

});
$server->on('message', function() {

});
$server->on('request', function() {

});
