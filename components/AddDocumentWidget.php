<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 6:33 PM
 */

namespace app\components;

use app\models\AddDocumentForm;
use app\services\DateService;
use app\services\DocumentService;
use Yii;
use yii\base\Widget;
use yii\web\UnauthorizedHttpException;
use yii\web\UploadedFile;

class AddDocumentWidget extends Widget
{
    /* @var AddDocumentForm*/
    public $documentForm;

    public function init()
    {
        parent::init();
        $this->documentForm = new AddDocumentForm();
    }

    public function run()
    {
        $userId = Yii::$app->user->getId();
        if ($userId == null) {
            throw new UnauthorizedHttpException();
        }

        $post = Yii::$app->request->post();
        if($this->documentForm->load($post)) {
            $this->documentForm->documentFile = UploadedFile::getInstance($this->documentForm, 'documentFile');
            if ($this->documentForm->upload($userId)) {
                $service = new DocumentService();
                $service->createDocument($this->documentForm, $userId, $post['AddDocumentForm']['subclientId']);
                Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
            }
        }

        $months = DateService::getMonthsNames();

        return $this->render('_addDocument', [
            'documentForm' => $this->documentForm,
            'months' => $months
        ]);
    }

}