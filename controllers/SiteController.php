<?php

namespace app\controllers;

use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Type;
use app\forms\RequestForm;
use app\parsers\ParserInterface;
use app\services\quotation\QuotationService;
use Assert\Assertion;
use Yii;
use yii\base\Module;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
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

    /**
     * @var ParserInterface
     */
    protected $parser;

    public function __construct($id, Module $module, Request $request, Response $response, RequestForm $requestForm,
                                QuotationService $quotationService, ParserInterface $parser, array $config = [])
    {
        $this->request = $request;
        $this->response = $response;
        $this->requestForm = $requestForm;
        $this->quotationService = $quotationService;
        $this->parser = $parser;

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
                    'request' => ['post'],
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
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'requestForm' => $this->requestForm,
        ]);
    }

    public function actionRequest()
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
            return $this->render('request', [
                'requestForm' => $this->requestForm,
                'exception' => $exception,
            ]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $quotations,
        ]);

        return $this->render('request', [
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
        $content = $this->getFileContent('@app/README.md');

        return $this->render('about', [
            'content' => $this->parser->parse($content),
        ]);
    }

    protected function getFileContent($filePath)
    {
        $filePath = \Yii::getAlias($filePath);

        $filePath = FileHelper::normalizePath($filePath);

        Assertion::file($filePath);

        return file_get_contents($filePath);
    }
}
