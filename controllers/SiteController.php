<?php

namespace app\controllers;

use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Type;
use app\forms\RequestForm;
use app\services\quotation\QuotationService;
use Yii;
use yii\base\Module;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var RequestForm
     */
    protected $requestForm;

    /**
     * @var QuotationService
     */
    protected $quotationService;

    public function __construct($id, Module $module, Request $request, Response $response, RequestForm $requestForm,
                                QuotationService $quotationService, array $config = [])
    {
        $this->request = $request;
        $this->response = $response;
        $this->requestForm = $requestForm;
        $this->quotationService = $quotationService;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     * Displays homepage.
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        try {
            $requestParams = $this->request->post($this->requestForm->formName());
            if (isset($requestParams['origin'])) {
                $this->requestForm->setOrigin($requestParams['origin']);
            }
            if (isset($requestParams['destination'])) {
                $this->requestForm->setDestination($requestParams['destination']);
            }
            if (isset($requestParams['startDateTime'])) {
                $this->requestForm->setStartDateTime($requestParams['startDateTime']);
            }
            if (isset($requestParams['type'])) {
                $this->requestForm->setType($requestParams['type']);
            }

            if ($this->requestForm->validate()) {
                $quotations = $this->quotationService->getQuotations($this->requestForm);
            } else {
                $quotations = [];
            }
        } catch (\Exception $exception) {
            return $this->render('index', [
                'requestForm' => $this->requestForm,
                'exception' => $exception,
            ]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $quotations,
        ]);

        return $this->render('index', [
            'requestForm' => $this->requestForm,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
