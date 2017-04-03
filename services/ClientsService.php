<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:56 PM
 */

namespace app\services;

use app\models\ClientModel;
use app\models\entities\User;

class ClientsService
{
    public function getClients() {
        return array(
            new ClientModel(100, 'ООО "Колорэкспресс"', 'Иван Иванович', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Заказчик', 'Александра'),
            new ClientModel(2, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(3, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(4, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(5, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(6, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(7, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(8, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(9, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(10, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(11, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(12, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(13, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(14, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(15, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
            new ClientModel(16, 'ООО "Колор экспо Минск"', 'Дмитрий Дмитриевич', '+375 (29) 222 22 22', 'mailmail@mail.ru', 'Агенство', 'Ирина'),
        );
    }

    public function getClientDetails($id) {
        $client = User::findOne($id);
        return $client;
    }
}