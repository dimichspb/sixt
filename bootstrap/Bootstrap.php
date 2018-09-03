<?php
namespace app\bootstrap;

use app\components\EntityManagerBuilder;
use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Type;
use app\events\dispatchers\DummyEventDispatcher;
use app\events\dispatchers\EventDispatcherInterface;
use app\forms\RequestForm;
use app\models\commission\Commission;
use app\models\commission\repositories\CommissionDoctrineRepository;
use app\models\commission\repositories\CommissionRepositoryInterface;
use app\models\commission\types\CreatedType;
use app\models\commission\types\IdType;
use app\models\commission\types\PercentType;
use app\models\history\History;
use app\models\history\repositories\HistoryDoctrineRepository;
use app\models\history\repositories\HistoryRepositoryInterface;
use app\models\history\types\AgentType;
use app\models\history\types\DateTimeType;
use app\models\history\types\DestinationType;
use app\models\history\types\IpType;
use app\models\history\types\OriginType;
use app\models\history\types\TypeType;
use app\models\history\types\UserIdType;
use app\models\vehicleClass\repositories\VehicleClassDoctrineRepository;
use app\models\vehicleClass\repositories\VehicleClassRepositoryInterface;
use app\models\vehicleClass\types\ExampleType;
use app\models\vehicleClass\types\NameType;
use app\models\vehicleClass\types\TitleType;
use app\models\vehicleClass\VehicleClass;
use app\parsers\MarkdownParser;
use app\sdk\MyDriver\entities\ApiKey;
use app\sdk\MyDriver\http\HttpClient;
use app\sdk\MyDriver\http\HttpClientInterface;
use app\sdk\MyDriver\parsers\JsonParser;
use app\sdk\MyDriver\parsers\ParserInterface;
use app\services\commission\CommissionService;
use app\services\history\HistoryService;
use app\services\vehicleClass\VehicleClassService;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * Define default delay after current datetime for request
     *
     * @var float|int
     */
    public $timeout = 24 * 60; // minutes

    public function bootstrap($app)
    {
        $container = \Yii::$container;

        /**
         * Define default origin, destination and start datetime values
         */
        $defaultOrigin = 'Munich Karlsplatz "Stachus"';
        $defaultDestination = 'Munich Airport';
        $defaultStartDateTime = date('c', time() + $this->timeout * 60);
        $defaultType = Type::DISTANCE;


        $container->set(CommissionService::class, CommissionService::class);
        $container->set(HistoryService::class, HistoryService::class);
        $container->set(VehicleClassService::class, VehicleClassService::class);

        /**
         * Define ApiKey to access to MyDriver (not used)
         */
        $container->set(ApiKey::class, function() {
            return new ApiKey('11223344556677889900');
        });

        $container->set(RequestForm::class, new RequestForm(
            new PlaceName($defaultOrigin),
            new PlaceName($defaultDestination),
            new DateTime($defaultStartDateTime),
            new Type($defaultType)
        ));

        $container->set(HttpClientInterface::class, HttpClient::class);

        $container->set(ParserInterface::class, JsonParser::class);

        $container->set(\app\parsers\ParserInterface::class, MarkdownParser::class);

        $container->set(EventDispatcherInterface::class, DummyEventDispatcher::class);

        Yii::$app->db->open();

        $container->setSingleton(EntityManager::class, function () use ($app) {
            return (new EntityManagerBuilder())
                ->withProxyDir(Yii::getAlias('@runtime/doctrine/proxy'), 'Proxies', !YII_ENV_PROD)
                ->withCache(YII_ENV_PROD ? new FilesystemCache(Yii::getAlias('@runtime/doctrine/cache')) : new ArrayCache())
                ->withMapping(new SimplifiedYamlDriver([
                    Yii::getAlias('@app/models/commission/mapping') => 'app\models\commission',
                    Yii::getAlias('@app/models/history/mapping') => 'app\models\history',
                    Yii::getAlias('@app/models/vehicleClass/mapping') => 'app\models\vehicleClass'
                ]))
                ->withTypes([
                    CreatedType::NAME => CreatedType::class,
                    IdType::NAME => IdType::class,
                    PercentType::NAME => PercentType::class,

                    AgentType::NAME => AgentType::class,
                    \app\models\history\types\CreatedType::NAME => \app\models\history\types\CreatedType::class,
                    DateTimeType::NAME => DateTimeType::class,
                    DestinationType::NAME => DestinationType::class,
                    \app\models\history\types\IdType::NAME => \app\models\history\types\IdType::class,
                    IpType::NAME => IpType::class,
                    OriginType::NAME => OriginType::class,
                    TypeType::NAME => TypeType::class,
                    UserIdType::NAME => UserIdType::class,

                    ExampleType::NAME => ExampleType::class,
                    \app\models\vehicleClass\types\IdType::NAME => \app\models\vehicleClass\types\IdType::class,
                    NameType::NAME => NameType::class,
                    TitleType::NAME => TitleType::class,
                ])
                ->withAutocommit(true)
                ->build(['pdo' => $app->db->pdo]);
        });


        /** @var EntityManager $em */
        $em = $container->get(EntityManager::class);

        $commissionRepository = new CommissionDoctrineRepository($em, $em->getRepository(Commission::class));
        $historyRepository = new HistoryDoctrineRepository($em, $em->getRepository(History::class));
        $vehicleClassRepository = new VehicleClassDoctrineRepository($em, $em->getRepository(VehicleClass::class));

        $container->set(CommissionRepositoryInterface::class, $commissionRepository);
        $container->set(HistoryRepositoryInterface::class, $historyRepository);
        $container->set(VehicleClassRepositoryInterface::class, $vehicleClassRepository);

    }
}