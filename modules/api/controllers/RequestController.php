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
    /**
     * @var QuotationService
     */
    protected $quotationService;

    /**
     * @var RequestForm
     */
    protected $requestForm;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * RequestController constructor.
     * @param $id
     * @param Module $module
     * @param QuotationService $quotationService
     * @param RequestForm $requestForm
     * @param Request $request
     * @param Response $response
     * @param array $config
     */
    public function __construct($id, Module $module, QuotationService $quotationService, RequestForm $requestForm,
                                Request $request, Response $response, array $config = [])
    {
        $this->quotationService = $quotationService;
        $this->requestForm = $requestForm;
        $this->request = $request;
        $this->response = $response;

        parent::__construct($id, $module, $config);
    }

    /**
     * @return array
     */
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

    /**
     * Quotations method result
     *
     * @return \app\models\quotation\Quotation[]
     * @throws \Psr\Http\Client\ClientException
     */
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