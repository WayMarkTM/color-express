<?php

namespace app\assets;

use yii\web\AssetBundle;

class ExternalAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'styles/external.css',
    ];
    public $js = [
    ];
    public $depends = [
        'app\assets\ThirdPartyAsset',
        'yii\web\YiiAsset',
    ];
}
