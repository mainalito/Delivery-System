<?php

namespace riders\assets;

use yii\web\AssetBundle;

/**
 * Main riders application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/riders.css',
        'https://fonts.googleapis.com/css?family=Montserrat:400,800'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
