<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/gallery.css',
    ];
    public $js = [
        'js/gallery.js',
        'js/gallery-modal.js',
        'js/gallery-scroll-to-top.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
//        'yii\gii\GiiAsset'
    ];
}
