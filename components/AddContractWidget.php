<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 7/10/2017
 * Time: 11:59 PM
 */

namespace app\components;


use app\models\AddContractForm;
use app\services\DocumentService;
use kartik\base\Widget;
use Yii;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class AddContractWidget extends Widget
{
    /* @var AddContractForm*/
    public $contractForm;

    public function init()
    {
        parent::init();
        $this->contractForm = new AddContractForm();
    }

    public function run()
    {
        $currentUserId = Yii::$app->user->getId();
        if ($currentUserId == null) {
            throw new UnauthorizedHttpException();
        }

        $post = Yii::$app->request->post();
        if($this->contractForm->load($post)) {
            $userId = $post['AddContractForm']['userId'];
            $this->contractForm->documentFile = UploadedFile::getInstance($this->contractForm, 'documentFile');
            if ($this->contractForm->upload($userId)) {
                $service = new DocumentService();
                $service->createContract($this->contractForm, $userId, $post['AddContractForm']['subclientId']);
                Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
            }
        }

        return $this->render('_addContract', [
            'contractForm' => $this->contractForm,
        ]);
    }

}