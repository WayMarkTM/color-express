<?php

namespace app\commands;

/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 02.05.2017
 * Time: 23:15
 */

use yii\console\Controller;
use Yii;

class RoleController extends Controller
{

    public function actionCreateRoles()
    {
        /*$role = Yii::$app->authManager->createRole('admin');
        $role->description = 'Админ';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole('employee');
        $role->description = 'Сотрудник';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole('client');
        $role->description = 'Клиент';
        Yii::$app->authManager->add($role);*/

        $role_guest = Yii::$app->authManager->createRole('guest');// не авторизирован
        $role_guest->description='Не авторизированный пользователь';
       // $role_guest->ruleName=$RuleForGuest->name;
        Yii::$app->authManager->add($role_guest);

        $admin_role = Yii::$app->authManager->getRole('admin');
        $emp_role = Yii::$app->authManager->getRole('employee');
        $client_role = Yii::$app->authManager->getRole('client');
        Yii::$app->authManager->addChild($admin_role, $role_guest);
        Yii::$app->authManager->addChild($admin_role, $emp_role);
        Yii::$app->authManager->addChild($admin_role, $client_role);
    }

    public function actionCreatePermissions()
    {
        $permit = Yii::$app->authManager->createPermission('deleteClient');
        $permit->description = 'Право удалять клиента';
        Yii::$app->authManager->add($permit);

        $role = Yii::$app->authManager->getRole('employee');
        Yii::$app->authManager->addChild($role, $permit);

        //
        $permit = Yii::$app->authManager->createPermission('deleteUser');
        $permit->description = 'Право удалять пользователя';
        Yii::$app->authManager->add($permit);

        $role = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->addChild($role, $permit);
    }

}