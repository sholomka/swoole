<?php

use Swoole\Process;

//$process = new Process(function($process) {
//    $process->write("hello");
//});
//
//$process->start();
//echo $process->read();


$process = new Process(function(Process $worker) {
    $worker->exec('/bin/ls', []);
}, true);

$process->start();
echo $process->read();