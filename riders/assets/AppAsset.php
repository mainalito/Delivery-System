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
        'css/site.css',
        'https://fonts.googleapis.com/css?family=Montserrat:400,800',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
    
    ];
    public $js = [
        
        'https://cdn.jsdelivr.net/npm/sweetalert2@11',
        'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie.min.js',
     
    ];
    public $depends = [
        JqueryAsset::class,
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
