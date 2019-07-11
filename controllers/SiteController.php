<?php

namespace app\controllers;

use app\models\entities\OurClient;
use app\models\entities\PortfolioItem;
use app\models\entities\Vacancy;
use app\models\FeedBackForm;
use app\models\constants\PageKey;
use app\services\MailService;
use app\services\SiteSettingsService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\LoginForm;
use app\models\ContactForm;
use app\services\ContactUsSubmissionService;
use app\services\SeoService;
use app\queries\OurClientQuery;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @var SeoService
     */
    private $seoService;

    public function init() {
        $this->seoService = new SeoService();
        parent::init();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionClients()
    {
        $this->view->title = $this->seoService->getTitleAndSetMetaData(PageKey::OUR_CLIENTS);

        $clients = OurClient::find()->all();

        return $this->render('clients', [
            'clients' => $clients
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $this->view->title = $this->seoService->getTitleAndSetMetaData(PageKey::CONTACTS);

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {

            $contactSubmissionService = new ContactUsSubmissionService();
            $contactSubmissionService->createContactSubmission($model);

            $mailService = new MailService();

            if($mailService->sendContactForm($model)) {
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->refresh();
            }
        }

        $siteSettingsService = new SiteSettingsService();
        $contactSettings = $siteSettingsService->getContactSettings();

        return $this->render('contact', [
            'model' => $model,
            'contactSettings' => $contactSettings
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $this->view->title = $this->seoService->getTitleAndSetMetaData(PageKey::ABOUT);
        return $this->render('about');
    }

    public function actionVacancies()
    {
        $this->view->title = $this->seoService->getTitleAndSetMetaData(PageKey::VACANCIES);
        $vacancies = Vacancy::find()->all();
        $feedBackForm = new FeedBackForm();

        if(Yii::$app->request->isPost) {
            if($feedBackForm->load(Yii::$app->request->post())) {
                $document = UploadedFile::getInstance($feedBackForm, 'upload_resume');
                if (!empty($document)) {
                    $feedBackForm->document = $document;
                    $feedBackForm->upload();
                }

                $mailService = new MailService();
                if($feedBackForm->validate() && $mailService->sendFeedback($feedBackForm)) {
                    $feedBackForm->deleteTemplFile();
                    Yii::$app->session->setFlash('contactFormSubmitted');

                    return $this->refresh();
                }
            }
        }
        
        return $this->render('vacancies', [
            'vacancies' => $vacancies,
            'feedBackForm' => $feedBackForm,
        ]);
    }

    public function actionAdvantages()
    {
        $this->view->title = $this->seoService->getTitleAndSetMetaData(PageKey::ADVANTAGES);
        return $this->render('advantages');
    }

    public function actionPortfolio()
    {
        $this->view->title = $this->seoService->getTitleAndSetMetaData(PageKey::PORTFOLIO);
        $portfolioItems = PortfolioItem::find()->all();
        return $this->render('portfolio', [
            'portfolioItems' => $portfolioItems,
        ]);
    }
}
