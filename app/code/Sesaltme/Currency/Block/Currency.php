<?php
namespace Sesaltme\Currency\Block;

class Currency extends \Magento\Framework\View\Element\Template
{
    protected $messageManager;

    private $currencyFactory;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Sesaltme\Currency\Model\CurrencyFactory $currencyFactory,
     * @param \Magento\Framework\Message\ManagerInterface $messageManager,
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Sesaltme\Currency\Model\CurrencyFactory $currencyFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->currencyFactory = $currencyFactory;
        $this->messageManager = $messageManager;
    }

    public function getExchangeRateInfo()
    {
        return $this->currencyFactory->create()->getCurrencyData();
    }
}
