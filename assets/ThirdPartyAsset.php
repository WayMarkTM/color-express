<?php

namespace app\assets;

use yii\web\AssetBundle;

class ThirdPartyAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'styles/bootstrap.min.css',
    ];
    public $js = [
        'js/jquery-3.2.0.min.js',
        'js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
