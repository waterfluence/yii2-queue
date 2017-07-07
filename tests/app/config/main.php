<?php
$config = [
    'id' => 'yii2-queue-app',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'bootstrap' => [
        'fileQueue',
        'mysqlQueue',
        'sqliteQueue',
        'pgsqlQueue',
        'redisQueue',
        'amqpQueue',
        'beanstalkQueue',
    ],
    'components' => [
        'syncQueue' => [
            'class' => __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\sync\Queue()),
        ],
        'fileQueue' => [
            'class' => __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\file\Queue()),
        ],
        'mysql' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \yii\db\Connection()),
            'dsn' => 'mysql:host=localhost;dbname=yii2_queue_test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'attributes' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode = "STRICT_ALL_TABLES"',
            ],
        ],
        'mysqlQueue' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\db\Queue()),
            'db' => 'mysql',
            'mutex' => [
                'class' =>  __NAMESPACE__ . "\\" . get_class(new \yii\mutex\MysqlMutex()),
                'db' => 'mysql',
            ],
        ],
        'sqlite' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \yii\db\Connection()),
            'dsn' => 'sqlite:@runtime/yii2_queue_test.db',
        ],
        'sqliteQueue' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\db\Queue()),
            'db' => 'sqlite',
            'mutex' =>  __NAMESPACE__ . "\\" . get_class(new \yii\mutex\FileMutex()),
        ],
        'pgsql' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \yii\db\Connection()),
            'dsn' => 'pgsql:host=localhost;dbname=yii2_queue_test',
            'username' => 'postgres',
            'password' => '',
            'charset' => 'utf8',
        ],
        'pgsqlQueue' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\db\Queue()),
            'db' => 'pgsql',
            'mutex' => [
                'class' =>  __NAMESPACE__ . "\\" . get_class(new \yii\mutex\PgsqlMutex()),
                'db' => 'pgsql',
            ],
            'mutexTimeout' => 0,
        ],
        'redis' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \yii\redis\Connection()),
            'database' => 2,
        ],
        'redisQueue' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\redis\Queue()),
        ],
        'amqpQueue' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\amqp\Queue()),
        ],
        'beanstalkQueue' => [
            'class' =>  __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\beanstalk\Queue()),
        ],
    ],
];

if (defined('GEARMAN_SUCCESS')) {
    $config['bootstrap'][] = 'gearmanQueue';
    $config['components']['gearmanQueue'] = [
        'class' =>  __NAMESPACE__ . "\\" . get_class(new \zhuravljov\yii\queue\gearman\Queue()),
    ];
}

return $config;