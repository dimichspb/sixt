<?php

namespace app\commands;

use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Type;
use app\forms\RequestForm;
use app\services\quotation\QuotationService;
use yii\base\Module;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\i18n\Formatter;

class RequestController extends Controller
{
    protected $quotationService;
    protected $requestForm;
    protected $formatter;

    public function __construct($id, Module $module, QuotationService $quotationService, RequestForm $requestForm,
                                Formatter $formatter, array $config = [])
    {
        $this->quotationService = $quotationService;
        $this->requestForm = $requestForm;
        $this->formatter = $formatter;

        parent::__construct($id, $module, $config);
    }

    /**
     * This command echoes quotation.
     * @param $origin
     * @param $destination
     * @param null $startDateTime
     * @param string $type
     * @return int Exit code
     */
    public function actionQuotation($origin = null, $destination = null, $startDateTime = null, $type = Type::DISTANCE)
    {
        if ($origin) {
            $this->requestForm->setOrigin($origin);
        }

        if ($destination) {
            $this->requestForm->setDestination($destination);
        }

        if ($startDateTime) {
            $this->requestForm->setStartDateTime($startDateTime);
        }

        if ($type) {
            $this->requestForm->setType($type);
        }

        $this->stdout('Origin place: ' . $this->requestForm->getOrigin()->getValue() . PHP_EOL);
        $this->stdout('Destination place: ' . $this->requestForm->getDestination()->getValue() . PHP_EOL);
        $this->stdout('Scheduled time: ' . $this->requestForm->getStartDateTime()->getValue() . PHP_EOL);

        try {
            $quotations = $this->quotationService->getQuotations($this->requestForm);

            $this->stdout(PHP_EOL);
            $this->stdout('Results: ' . PHP_EOL);
            foreach ($quotations as $quotation) {
                $this->stdout(
                    'Vehicle class: ' . $quotation->getVehicleClass()->getValue() .
                    ', offer price: ' . $this->formatter->asDecimal($quotation->getOffer()->getPrice()->getValue()) .
                    ', price: ' . $this->formatter->asDecimal($quotation->getPrice()->getValue()) .
                    ', currency: ' . $quotation->getCurrency()->getValue() . PHP_EOL
                );
            }
            return ExitCode::OK;
        } catch (\Exception $exception) {
            $this->stderr($exception);
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
