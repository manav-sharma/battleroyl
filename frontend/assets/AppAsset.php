<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'frontend/web/themes/battleroyale/css/bootstrap.css',
        'frontend/web/themes/battleroyale/css/core.css',
        'frontend/web/themes/battleroyale/css/responsive.css',
        'frontend/web/themes/battleroyale/css/font-awesome.css',
    ];

    public $js = [
        'frontend/web/themes/battleroyale/js/jquery.min.js',
        'frontend/web/themes/battleroyale/js/bootstrap.js',
        'frontend/web/themes/battleroyale/js/core.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
}
