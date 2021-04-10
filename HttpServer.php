<?php

require 'vendor/autoload.php';

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;



class HttpServer
{
    protected $server = null;

    /**
     * HttpServer constructor.
     */
    public function __construct()
    {
        $this->server = new Swoole\Http\Server('127.0.0.1', 9510, SWOOLE_BASE);

        $this->server->set([
            'worker_num' => 10,
            'task_worker_num' => 10,
        ]);

        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('start', [$this, 'onStart']);
        $this->server->on('task', [$this, 'onTask']);

        return $this;
    }

    public function start()
    {
        $this->server->start();
    }

    public function onStart(Swoole\Http\Server $server)
    {
        echo "Swoole http server is startted at http://127.0.0.1:9503\n";
    }


    public function onTask(Swoole\Server $server, $task_Id, $worker_id, $data)
    {
        echo "task";
    }

    public function onRequest(swoole_http_request $request, swoole_http_response $response)
    {
        if ($request->server['request_method'] === 'GET') {
            $body = $this->curl();
            var_dump($body);
            $response->end();
        } else {
            $response->status(405);
            $response->end("");
        }
    }

    public function asynchttp()
    {
        $client = new Swoole\Coroutine\Http\Client('cashberry_front.local');
        $client->post('/api/test', []);
        $body = $client->body;
        $client->close();
        return $body;
    }


    public function guzzle()
    {
        $client = new GuzzleHttp\Client();

        $request = new Request('POST', 'http://cashberry_front.local/api/test');
        $promise = $client->sendAsync($request);




        $promise->then(
            function (ResponseInterface $res) {


                echo $res->getStatusCode() . "\n";
            },
            function (RequestException $e) {
                echo $e->getMessage() . "\n";
                echo $e->getRequest()->getMethod();
            }
        );

        return $promise->wait();
    }

    public function curl()
    {
//        Co::set(['hook_flags' => SWOOLE_HOOK_ALL]);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://cashberry_front.local/api/test");
        curl_setopt($ch, CURLOPT_POST, 1);


// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS,
//          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);


        return $server_output;
    }

}

(new HttpServer())->start();