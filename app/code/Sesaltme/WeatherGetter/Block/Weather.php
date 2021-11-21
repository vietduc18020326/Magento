<?php
namespace Sesaltme\WeatherGetter\Block;

class Weather extends \Magento\Framework\View\Element\Template
{
    private $response;

    protected $messageManager;

    private $weatherFactory;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Sesaltme\WeatherGetter\Model\WeatherFactory $weatherFactory,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->weatherFactory = $weatherFactory;
        $this->response = $response;
        $this->messageManager = $messageManager;
    }

    public function getWeatherInformation()
    {
        $result = $this->weatherFactory->create()->getWeatherResponse();
        if ($result->cod != '200') {
            $this->response->setRedirect('/weather');
            $this->messageManager->addError('City not found');
        }
        return $result;
    }
}
