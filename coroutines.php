<?php

Co\run(function() {
    $col = go(function() {
        echo "1\n";
        Co::yield();
        echo "2\n";
    });

    $col2 = go(function() {
        echo "3\n";
        Co::yield();
        echo "4\n";
    });

    echo "start\n";
    Co::resume($col);
    Co::resume($col2);


    echo "-------------------------------------\n";

    $col = go(function() {
        echo Co::getCid() . "\n";
        echo Co::getPcid() . "\n";


        go(function() {
            echo Co::getCid() . "\n";
            echo Co::getPcid() . "\n";
        });
    });

});
