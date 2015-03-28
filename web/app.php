<?php

# Loader
require_once __DIR__ . '/../app/autoload.php';

# Application
$app = new App(array(
    'upload_dir'  => __DIR__ . '/uploads/',
    'asset_path'  => 'http://horizonte.net.ve/web/assets',
    'upload_path' => 'http://horizonte.net.ve/web/uploads'
));

# Application Run
$app->run();