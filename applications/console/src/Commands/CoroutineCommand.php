<?php

namespace Console\Commands;

use Mix\Concurrent\Sync\WaitGroup;
use Mix\Core\Coroutine\Channel;

/**
 * Class CoroutineCommand
 * @package Console\Commands
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class CoroutineCommand
{

    /**
     * 主函数
     */
    public function main()
    {
        xgo(function () {
            $ws = WaitGroup::new();
            $ws->add();
            xgo(function () use ($ws) {
                $time = time();
                list($foo, $bar) = [$this->foo(), $this->bar()];
                list($fooResult, $barResult) = [$foo->pop(), $bar->pop()];
                println('Total time: ' . (time() - $time));
                var_dump($fooResult);
                var_dump($barResult);
                $ws->done();
            });
            $ws->wait();
            println('finish');
        });
    }

    /**
     * 查询数据
     * @return Channel
     */
    public function foo()
    {
        $chan = new Channel();
        xgo(function () use ($chan) {
            $pdo    = app()->pdoPool->getConnection();
            $result = $pdo->createCommand('select sleep(5)')->queryAll();
            $chan->push($result);
        });
        return $chan;
    }

    /**
     * 查询数据
     * @return Channel
     */
    public function bar()
    {
        $chan = new Channel();
        xgo(function () use ($chan) {
            $pdo    = app()->pdoPool->getConnection();
            $result = $pdo->createCommand('select sleep(2)')->queryAll();
            $chan->push($result);
        });
        return $chan;
    }

}
