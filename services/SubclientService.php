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

const DEАAULT_NAME = "По умолчанию";

class SubclientService
{

    /**
     * @param $viewModel AddSubclientForm
     * @param $userId integer
     * @return Subclient
     */
    public function createSubclient($viewModel, $userId, $termPayment = "") {
        $subclient = new Subclient();
        $subclient->name = !empty($viewModel) ? $viewModel->name : DEАAULT_NAME;
        $subclient->user_id = $userId;
        $subclient->term_payment = $termPayment;
        $subclient->save();

        return $subclient;
    }

    /**
     * @param $userId integer
     * @return Subclient[]
     */
    public function getSubclients($userId) {
        return Subclient::find()->where(['=', 'user_id', $userId])->all();
    }


    public function updateTermPayment($id, $termPayment) {
        $subclient = Subclient::findOne($id);

        $subclient->term_payment = $termPayment;
        $subclient->update();
    }
}