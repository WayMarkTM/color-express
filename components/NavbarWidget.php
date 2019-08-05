<?php

namespace app\components;

use Yii;
use yii\base\Widget;

class NavbarWidget extends Widget
{
    public function run() {
        $items = [
          [
              'label' => 'Купить Online',
              'url' => '/catalog',
              'active' => strpos(Yii::$app->request->url, 'catalog') !== false,
              'additionalClass' => 'special'
          ],
          [
              'label' => 'Exclusive Offer',
              'url' => '/offers',
              'active' => strpos(Yii::$app->request->url, 'offers') !== false
          ],
          [
              'label' => 'О Компании',
              'url' => '/about',
              'active' => strpos(Yii::$app->request->url, 'about') !== false
          ],
          [
              'label' => 'Портфолио',
              'url' => '/portfolio',
              'active' => strpos(Yii::$app->request->url, 'portfolio') !== false
          ],
          [
              'label' => 'Контакты',
              'url' => '/contacts',
              'active' => strpos(Yii::$app->request->url, 'contacts') !== false
          ],
      ];

        return $this->render('_navbar', [
            'items' => $items
        ]);
    }
}
?>