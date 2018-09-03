<?php

use yii\db\Migration;

/**
 * Class m180903_104135_FillCommissionTable
 */
class m180903_104335_FillCommissionTable extends Migration
{
    protected $data = [
        [
            'percent' => 20,
        ],
    ];

    protected $service;

    public function __construct(\app\services\commission\CommissionService $service,
                                array $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        foreach ($this->data as $item) {
            $commission = $this->service->createFromArray($item);
            $this->service->save($commission);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $commissions = $this->service->all();

        foreach ($commissions as $commission) {
            $this->service->delete($commission);
        }
    }
}
