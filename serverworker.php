<?php

$server = new Swoole\HTTP\Server("127.0.0.1",  9501);

$server->on("start", function (Swoole\Http\Server $server) {
    echo "Swoole http server is startted at http://127.0.0.1:9501\n";
});

$server->on('workerStart', function ($server, $worker_id) {
    global $argv;

    if ($worker_id >= $server->setting['worker_num'])  {
        swoole_set_process_name("php {$argv[0]} task worker");
    } else {
        swoole_set_process_name("php {$argv[0]} worker");
    }
});

$server->on("request", function (Swoole\Http\Request $request,  Swoole\Http\Response $response) {
    $response->header("Content-Type", "text/plain");
    $response->end("Hello World2\n");
});

$server->start();