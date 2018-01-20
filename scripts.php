<?php

return [
    'install' => function ($app) {

        $util = $app['db']->getUtility();

        if ($util->tableExists('@languagemanager_translation') === false) {
            $util->createTable('@languagemanager_translation', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('type', 'string', ['length' => 128]);
                $table->addColumn('model_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('model', 'string', ['length' => 128]);
                $table->addColumn('language', 'string', ['length' => 8]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('content', 'text', ['notnull' => false]);
                $table->addColumn('data', 'json_array');
                $table->setPrimaryKey(['id']);
            });
        }
    },

    'uninstall' => function ($app) {

        $util = $app['db']->getUtility();

        if ($util->tableExists('@languagemanager_translation') === false) {
            $util->dropTable('@languagemanager_translation');
        }
        // remove the config
        $app['config']->remove('bixie/languagemanager');
    },

    'updates' => [
    ],
];