<?php

namespace riders\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main riders application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/fontawesome-free/css/all.min.css',
        'css/site.css',
        'https://fonts.googleapis.com/css?family=Montserrat:400,800',
        
        'css/sb-admin-2.min.css',

    ];
    
    public $js = [
        'https://cdn.jsdelivr.net/npm/sweetalert2@11',
        'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie.min.js',
        "vendor/jquery-easing/jquery.easing.min.js",
        "vendor/chart.js/Chart.min.js",
        "js/sb-admin-2.min.js",
        "js/mapbox.js",

    ];
    public $depends = [
        JqueryAsset::class,
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        // 'yidas\yii\fontawesome\FontawesomeAsset',

    ];
}
