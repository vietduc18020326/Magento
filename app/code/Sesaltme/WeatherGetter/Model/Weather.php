<?php
namespace Sesaltme\WeatherGetter\Model;

class Weather extends \Magento\Framework\Model\AbstractModel
{
    const REQUEST_TIMEOUT = 5000;

    const END_POINT_URL = 'api.openweathermap.org/data/2.5/forecast?units=metric';

    const API_KEY = "878c3e59cf87a22ace43c4fc763ecc33";

    private $response;
    /**
     * @var \Magento\Framework\HTTP\Client\CurlFactory
     */
    private $curlFactory;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $http;
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    private $jsonHelper;

    /**
     * Weather constructor.
     * @param \Magento\Framework\HTTP\Client\CurlFactory $curlFactory
     * @param Http $http
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\HTTP\Client\CurlFactory $curlFactory,
        \Magento\Framework\App\Request\Http $http,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    )
    {
        $this->curlFactory = $curlFactory;
        $this->http = $http;
        $this->jsonHelper = $jsonHelper;
    }

    public function getWeatherResponse()
    {
        if(!$this->response){
            $this->response = (object) $this->getResponseFromEndPoint();
        }
        
        return $this->response;
    }

    private function getResponseFromEndPoint()
    {
        return $this->jsonHelper->jsonDecode($this->getResponse());
    }

    private function getResponse()
    {
        /** @var \Magento\Framework\HTTP\Client\Curl $client */
        $client = $this->curlFactory->create();
        $client->setTimeout(self::REQUEST_TIMEOUT);
        $client->get($this->getUrl());
        
        return $client->getBody();
    }

    /**
     * @return String
     */
    private function getUrl() {
        $city = $this->http->getParam('city') ?? 'Hanoi';
        
        return self::END_POINT_URL . '&q=' . $city . '&APPID=' . self::API_KEY;
    }
}
