<?php

try {
    $rcf = new RdKafka\Conf();
    $rcf->set('group.id', 'test1');
    $cf = new RdKafka\TopicConf();
    $cf->set('offset.store.method', 'broker');
    $cf->set('auto.offset.reset', 'smallest');

    $rk = new RdKafka\Producer($rcf);
    $rk->setLogLevel(LOG_DEBUG);
    $rk->addBrokers("121.196.200.73:9092");
    $topic = $rk->newTopic("test1", $cf);
    for($i = 0; $i < 1000; $i++) {
        $topic->produce(0,0,'test1' . $i);//没有setMessge接口了,使用produce  参考：https://libraries.io/github/mentionapp/php-rdkafka
    }
} catch (Exception $e) {
    echo $e->getMessage();
}


try {
    $rcf = new RdKafka\Conf();
    $rcf->set('group.id', 'test1');
    $cf = new RdKafka\TopicConf();
    /*
        $cf->set('offset.store.method', 'file');
    */
    $cf->set('auto.offset.reset', 'smallest');
    $cf->set('auto.commit.enable', true);

    $rk = new RdKafka\Consumer($rcf);
    $rk->setLogLevel(LOG_DEBUG);
    $rk->addBrokers("121.196.200.73:9092");
    $topic = $rk->newTopic("test1", $cf);
    //$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);
    while (true) {
        $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
        $msg = $topic->consume(0, 1000);
        var_dump($msg);
        if ($msg->err) {
            echo $msg->errstr(), "\n";
            break;
        } else {
            echo $msg->payload, "\n";
        }
        $topic->consumeStop(0);
        sleep(1);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

