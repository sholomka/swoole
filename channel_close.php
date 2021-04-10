<?php

$channel = new Swoole\Coroutine\Channel();
$buffer = [];

go(function() use ($channel, $buffer) {
    while(true) {
        $channel->pop(30);
        sendBatch($buffer);

        if ($channel->errCode === SWOOLE_CHANNEL_CLOSED) {
            break;
        }
    }
});

$server->on('workerExit', function() use ($channel) {
    go(function() use ($channel) {
        $channel->close();
    });
});