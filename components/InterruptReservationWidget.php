<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/31/2017
 * Time: 1:51 AM
 */

namespace app\components;


use app\models\InterruptionForm;
use app\services\AdvertisingConstructionReservationService;
use Yii;
use yii\base\Widget;

class InterruptReservationWidget extends Widget
{
    public function run()
    {
        $interruptionForm = new InterruptionForm();

        $post = Yii::$app->request->post();
        if($interruptionForm->load($post)) {
            $service = new AdvertisingConstructionReservationService();
            if ($service->interruptReservation($interruptionForm)) {
                Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
            }
        }

        return $this->render('_interruptReservation', [
            'interruptionForm' => $interruptionForm
        ]);
    }
}