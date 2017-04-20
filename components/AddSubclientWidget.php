<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 8:18 PM
 */

namespace app\components;


use app\models\AddSubclientForm;
use app\services\SubclientService;
use Yii;
use yii\base\Widget;
use yii\web\UnauthorizedHttpException;

class AddSubclientWidget extends Widget
{
    /* @var AddSubclientForm*/
    public $subclientForm;

    public function init()
    {
        parent::init();
        $this->subclientForm = new AddSubclientForm();
    }

    public function run()
    {
        $userId = Yii::$app->user->getId();
        if ($userId == null) {
            throw new UnauthorizedHttpException();
        }

        if($this->subclientForm->load(Yii::$app->request->post())) {
            $service = new SubclientService();
            $service->createSubclient($this->subclientForm, $userId);
            Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
        }

        return $this->render('_addSubclient', [
            'subclientForm' => $this->subclientForm
        ]);
    }

}