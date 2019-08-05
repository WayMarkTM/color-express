<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'styles/toastr.min.css',
        'styles/common.css',
        'styles/external.css',
        'styles/controls.css',
        'styles/info-block.css',
        'styles/advantages.css',
        'styles/clients.css',
        'styles/icons.css',
        'styles/construction.css',
        'styles/documents.css',
    ];
    public $js = [
        'js/lodash.min.js',
        'js/toastr.min.js',
        'js/moment.with.locales.min.js',
        'js/app/helpers.js',
        'js/app/urls.js',
        'js/angular.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
