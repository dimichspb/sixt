<?php
namespace app\bootstrap;

use app\commands\RequestController;
use app\entities\Commission;
use app\entities\DateTime;
use app\entities\PlaceName;
use app\entities\Type;
use app\forms\RequestForm;
use app\sdk\MyDriver\entities\ApiKey;
use app\sdk\MyDriver\http\HttpClient;
use app\sdk\MyDriver\http\HttpClientInterface;
use app\sdk\MyDriver\http\HttpMethod;
use app\sdk\MyDriver\MyDriver;
use app\sdk\MyDriver\parsers\JsonParser;
use app\sdk\MyDriver\parsers\ParserInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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

        /**
         * Define default Commission value in percents
         */
        $container->set(Commission::class, new Commission(20));

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
    }
}