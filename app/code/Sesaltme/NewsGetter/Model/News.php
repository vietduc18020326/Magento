<?php
namespace Sesaltme\NewsGetter\Model;

class News extends \Magento\Framework\Model\AbstractModel
{
    const REQUEST_TIMEOUT = 5000;

    const BUSINESS = 'BUSINESS';
    const LATEST = 'LATEST';
    const ENTERTAINMENT = 'ENTERTAINMENT';
    const HOTTEST = 'HOTTEST';
    const SPORT = 'SPORT';
    const TRAVEL = 'TRAVEL';

    const NEWS_API = [
        self::BUSINESS => 'https://vnexpress.net/rss/kinh-doanh.rss',
        self::LATEST => 'https://vnexpress.net/rss/tin-moi-nhat.rss',
        self::ENTERTAINMENT => 'https://vnexpress.net/rss/giai-tri.rss',
        self::HOTTEST => 'https://vnexpress.net/rss/tin-noi-bat.rss',
        self::SPORT => 'https://vnexpress.net/rss/the-thao.rss',
        self::TRAVEL => 'https://vnexpress.net/rss/du-lich.rss',
    ];

    private $response;
    
    /**
     * @var \Magento\Framework\HTTP\Client\CurlFactory
     */
    private $curlFactory;
    
    /**
     * @var \Magento\Framework\Xml\Parser
     */
    private $xmlParser;

    /**
     * @param \Magento\Framework\HTTP\Client\CurlFactory $curlFactory
     * @param \Magento\Framework\Xml\Parser $jsonHelper
     */
    public function __construct(
        \Magento\Framework\HTTP\Client\CurlFactory $curlFactory,
        \Magento\Framework\Xml\Parser $xmlParser
    )
    {
        $this->curlFactory = $curlFactory;
        $this->xmlParser = $xmlParser;
    }

    public function getArticles(String $type)
    {
        if(!$this->response){
            $this->response = (object) $this->xmlParser->loadXML($this->getResponse($type))->xmlToArray();
        }
        
        return $this->response;
    }

    private function getResponse(String $type)
    {
        /** @var \Magento\Framework\HTTP\Client\Curl $client */
        $client = $this->curlFactory->create();
        $client->setTimeout(self::REQUEST_TIMEOUT);
        $client->get(self::NEWS_API[$type]);
        
        return $client->getBody();
    }
}
