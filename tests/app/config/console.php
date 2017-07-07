<?php
return [
    'controllerMap' => [
        'mysql-migrate' => [
            'class' => \yii\console\controllers\MigrateController::className(),
            'db' => 'mysql',
            'migrationPath' => null,
            'migrationNamespaces' => [
                'zhuravljov\yii\queue\db\migrations',
            ],
        ],
        'sqlite-migrate' => [
            'class' => \yii\console\controllers\MigrateController::className(),
            'db' => 'sqlite',
            'migrationPath' => null,
            'migrationNamespaces' => [
                'zhuravljov\yii\queue\db\migrations',
            ],
        ],
        'pgsql-migrate' => [
            'class' => \yii\console\controllers\MigrateController::className(),
            'db' => 'pgsql',
            'migrationPath' => null,
            'migrationNamespaces' => [
                'zhuravljov\yii\queue\db\migrations',
            ],
        ],
    ],
];