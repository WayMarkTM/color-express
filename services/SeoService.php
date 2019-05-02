<?php
/**
 * Created by VSC.
 * User: e.chernyavsky
 * Date: 02.05.2019
 * Time: 11:23
 */

namespace app\services;

class SeoService
{
  public static function setMetaTags($description, $keywords) {
    \Yii::$app->view->registerMetaTag([
      'name' => 'description',
      'content' => $description,
    ]);
    \Yii::$app->view->registerMetaTag([
      'name' => 'keywords',
      'content' => $keywords,
    ]);
  }
}