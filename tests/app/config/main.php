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
            'class' => \zhuravljov\yii\queue\sync\Queue::className(),
        ],
        'fileQueue' => [
            'class' => \zhuravljov\yii\queue\file\Queue::className(),
        ],
        'mysql' => [
            'class' => \yii\db\Connection::className(),
            'dsn' => 'mysql:host=localhost;dbname=yii2_queue_test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'attributes' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode = "STRICT_ALL_TABLES"',
            ],
        ],
        'mysqlQueue' => [
            'class' => \zhuravljov\yii\queue\db\Queue::className(),
            'db' => 'mysql',
            'mutex' => [
                'class' => \yii\mutex\MysqlMutex::className(),
                'db' => 'mysql',
            ],
        ],
        'sqlite' => [
            'class' => \yii\db\Connection::className(),
            'dsn' => 'sqlite:@runtime/yii2_queue_test.db',
        ],
        'sqliteQueue' => [
            'class' => \zhuravljov\yii\queue\db\Queue::className(),
            'db' => 'sqlite',
            'mutex' => \yii\mutex\FileMutex::className(),
        ],
        'pgsql' => [
            'class' => \yii\db\Connection::className(),
            'dsn' => 'pgsql:host=localhost;dbname=yii2_queue_test',
            'username' => 'postgres',
            'password' => '',
            'charset' => 'utf8',
        ],
        'pgsqlQueue' => [
            'class' => \zhuravljov\yii\queue\db\Queue::className(),
            'db' => 'pgsql',
            'mutex' => [
                'class' => \yii\mutex\PgsqlMutex::className(),
                'db' => 'pgsql',
            ],
            'mutexTimeout' => 0,
        ],
        'redis' => [
            'class' => \yii\redis\Connection::className(),
            'database' => 2,
        ],
        'redisQueue' => [
            'class' => \zhuravljov\yii\queue\redis\Queue::className(),
        ],
        'amqpQueue' => [
            'class' => \zhuravljov\yii\queue\amqp\Queue::className(),
        ],
        'beanstalkQueue' => [
            'class' => \zhuravljov\yii\queue\beanstalk\Queue::className(),
        ],
    ],
];

if (defined('GEARMAN_SUCCESS')) {
    $config['bootstrap'][] = 'gearmanQueue';
    $config['components']['gearmanQueue'] = [
        'class' => \zhuravljov\yii\queue\gearman\Queue::className(),
    ];
}

return $config;