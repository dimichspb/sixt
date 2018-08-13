<?php
namespace app\modules\api\controllers;

use app\entities\Type;
use app\forms\RequestForm;
use app\services\quotation\QuotationService;
use yii\base\Module;
use yii\rest\Controller;
use yii\web\Request;
use yii\web\Response;

class RequestController extends Controller
{
    protected $quotationService;
    protected $requestForm;
    protected $request;
    protected $response;

    public function __construct($id, Module $module, QuotationService $quotationService, RequestForm $requestForm,
                                Request $request, Response $response, array $config = [])
    {
        $this->quotationService = $quotationService;
        $this->requestForm = $requestForm;
        $this->request = $request;
        $this->response = $response;

        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'quotations' => ['POST'],
        ];
    }

    public function actionQuotations()
    {
        $requestParams = $this->request->post();
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

        return $quotations;
    }
}