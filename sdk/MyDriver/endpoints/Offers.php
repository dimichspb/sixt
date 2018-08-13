<?php
namespace app\sdk\MyDriver\endpoints;

use app\sdk\MyDriver\Endpoint;
use app\sdk\MyDriver\entities\ApiKey;
use app\sdk\MyDriver\entities\Currency;
use app\sdk\MyDriver\entities\Price;
use app\sdk\MyDriver\entities\VehicleClass;
use app\sdk\MyDriver\http\HttpClientInterface;
use app\sdk\MyDriver\http\HttpMethod;
use app\sdk\MyDriver\http\HttpRequest;
use app\sdk\MyDriver\OffersRequest;
use app\sdk\MyDriver\Offer;
use app\sdk\MyDriver\parsers\ParserInterface;
use app\sdk\MyDriver\Request;
use Psr\Http\Message\ResponseInterface;

class Offers extends Endpoint
{
    /**
     * @var ApiKey
     */
    protected $apiKey;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var ParserInterface
     */
    protected $parser;

    protected $method = HttpMethod::POST;
    protected $uri = 'https://www.mydriver.com/api/v2/offers';
    protected $headers = [ 'Content-Type' => 'application/json' ];

    /**
     * Offers constructor.
     * @param ApiKey $apiKey
     * @param HttpClientInterface $httpClient
     * @param ParserInterface $parser
     */
    public function __construct(ApiKey $apiKey, HttpClientInterface $httpClient, ParserInterface $parser)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
        $this->parser = $parser;
    }

    /**
     * @param Request $request
     * @return Offer[]
     * @throws \Psr\Http\Client\ClientException
     */
    public function run(Request $request)
    {
        $httpRequest = $this->prepareRequest($request);
        $httpResponse = $this->httpClient->sendRequest($httpRequest);

        return $this->parseResponse($httpResponse);
    }

    /**
     * @param OffersRequest $offersRequest
     * @return HttpRequest
     */
    protected function prepareRequest(OffersRequest $offersRequest)
    {
        $request = new \stdClass();
        $request->origin = $offersRequest->getOrigin()->getValue();
        $request->destination = $offersRequest->getDestination()->getValue();
        $request->selectedStartDate = $offersRequest->getDateTime()->getValue();
        $request->type = $offersRequest->getType()->getValue();

        $body = $this->parser->prepareRequestBody($request);

        $httpRequest = new HttpRequest($this->method, $this->uri, $this->headers, $body);

        return $httpRequest;
    }

    /**
     * @param ResponseInterface $httpResponse
     * @return Offer[]
     */
    protected function parseResponse(ResponseInterface $httpResponse)
    {
        $results = [];

        $responseArray = $this->parser->parseResponseBody($httpResponse->getBody());

        foreach ($responseArray as $item) {
            $results[] = new Offer(
                new VehicleClass($item['vehicleType']['name']),
                new Price($item['amount']),
                new Currency($item['currency'])
            );
        }

        return $results;
    }

}