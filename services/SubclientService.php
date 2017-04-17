<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 10:05 PM
 */

namespace app\services;

use app\models\AddSubclientForm;
use app\models\entities\Subclient;

class SubclientService
{

    /**
     * @param $viewModel AddSubclientForm
     * @param $userId integer
     */
    public function createSubclient($viewModel, $userId) {
        $subclient = new Subclient();
        $subclient->name = $viewModel->name;
        $subclient->user_id = $userId;
        $subclient->save();
    }

    /**
     * @param $userId integer
     * @return Subclient[]
     */
    public function getSubclients($userId) {
        return Subclient::find()->where(['=', 'user_id', $userId])->all();
    }
}