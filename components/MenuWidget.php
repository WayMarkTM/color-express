<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 10.04.2017
 * Time: 18:05
 */

namespace app\components;


use app\models\constants\SiteSettingKey;
use app\models\entities\SiteSettings;
use app\models\User;
use Yii;
use yii\base\Widget;

class MenuWidget extends Widget
{
    public function run() {
        $items = array();

        if (Yii::$app->user->isGuest) {
            $items = $this->getGuestMenu();
        } else {
            $user_id = Yii::$app->user->getId();
            $user = User::findIdentity($user_id);
            switch ($user->getRole()) {
                case 'admin':
                    $items = $this->getAdminMenu();
                    break;
                case 'client':
                    $items = $this->getClientMenu();
                    break;
                case 'employee':
                    $items = $this->getEmployeeMenu();
                    break;
            }
        }


        return $this->render('_menu', [
            'items' => $items
        ]);
    }

    private function getEmployeeMenu() {
        return [
            [
                'label' => 'Управление клиентами',
                'url' => ['/clients/index'],
                'active' => strpos(Yii::$app->request->url, 'clients/') !== false,
                'template' => '<a href="{url}">{label}</a>'.BadgeWidget::widget(['param' => BadgeWidget::$CLIENTS_WITH_UNPROCESSED_ORDERS_COUNT]),
            ],
            [
                'label' => 'Управление конструкциями',
                'url' => ['/construction/index'],
                'active' => strpos(Yii::$app->request->url, 'construction/') !== false
            ],
            [
                'label' => 'Новые заявки на регистрацию',
                'url' => ['/registration-requests/index'],
                'template' => '<a href="{url}">{label}</a>'.BadgeWidget::widget(['param' => BadgeWidget::$NEW_USER_COUNT]),
            ],
            [
                'label' => 'Корзина',
                'url' => ['/shopping-cart/index'],
                'template' => '<a href="{url}">{label}</a>'.BadgeWidget::widget(['param' => BadgeWidget::$SHOPPING_CART_ITEMS_COUNT]),
            ],
        ];
    }

    private function getClientMenu() {
        return [
            [
                'label' => 'Оформить заказ',
                'url' => ['/construction/index']
            ],
            [
                'label' => 'Корзина',
                'url' => ['/shopping-cart/index'],
                'template' => '<a href="{url}">{label}</a>'.BadgeWidget::widget(['param' => BadgeWidget::$SHOPPING_CART_ITEMS_COUNT]),
            ],
            [
                'label' => 'Мои заказы',
                'url' => ['/orders/index']
            ],
            [
                'label' => 'Документы',
                'url' => ['/clients/documents']
            ]
        ];
    }

    private function getAdminMenu() {
        return [
            [
                'label' => 'Управление конструкциями',
                'url' => ['/admin/construction/index']
            ],
            [
                'label' => 'Управление размерами конструкций',
                'url' => ['/admin/advertising-construction-size/index']
            ],
            [
                'label' => 'Управление типами конструкций',
                'url' => ['/admin/advertising-construction-type/index']
            ],
            [
                'label' => 'Управление нашими клиентами',
                'url' => ['/admin/our-client/index']
            ],
            [
                'label' => 'Управление сотрудниками',
                'url' => ['/admin/user/index']
            ],
            [
                'label' => 'Управление вакансиями',
                'url' => ['/admin/vacancy/index']
            ],
            [
                'label' => 'Мета-данные о страницах',
                'url' => ['/admin/page-metadata/index']
            ],
            [
                'label' => 'Управление портфолио',
                'url' => ['/admin/portfolio/index']
            ],
            [
                'label' => 'Настройки сайта',
                'url' => ['/admin/site-settings/index']
            ]
        ];
    }

    private function getGuestMenu() {
        return [
            [
                'label' => 'Каталог рекламных конструкций',
                'url' => ['/construction/index'],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label' => 'Преимущества',
                'url' => ['/site/advantages'],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label' => 'О компании',
                'url' => ['/site/about'],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label' => 'Наши клиенты',
                'url' => ['/site/clients'],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label' => 'Вакансии',
                'url' => ['/site/vacancies'],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label' => 'Контакты',
                'url' => ['/site/contact'],
                'visible' => Yii::$app->user->isGuest,
            ],
            [
                'label' => 'Инструкция к сайту',
                'url' => SiteSettings::findOne(SiteSettingKey::PRESENTATION_LINK)->value,
                'visible' => Yii::$app->user->isGuest
            ]
        ];
    }
}