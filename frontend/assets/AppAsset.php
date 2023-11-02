<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css'
    ];
    public $js = [
    ];
    public $depends = [
        JqueryAsset::class,
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
