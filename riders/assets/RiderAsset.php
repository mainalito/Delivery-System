<?php

namespace riders\assets;

use yii\web\AssetBundle;

/**
 * Main riders application asset bundle.
 */
class RiderAsset extends AssetBundle
{
    public $basePath = '@webroot/riders/';
    public $baseUrl = '@web/riders';
    public $css = [
        'riders.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/sweetalert2@11',
        'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}

