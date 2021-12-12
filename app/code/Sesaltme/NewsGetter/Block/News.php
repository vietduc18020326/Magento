<?php
namespace Sesaltme\NewsGetter\Block;

use Sesaltme\NewsGetter\Model\News as NewsModel;

class News extends \Magento\Framework\View\Element\Template
{
    private $newsFactory;
    private $model;
    
    private $resultData;
    private $totalPage;

    const PER_PAGE = 12;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Sesaltme\NewsGetter\Model\NewsFactory $newsFactory,
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Sesaltme\NewsGetter\Model\NewsFactory $newsFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->newsFactory = $newsFactory;
        $this->createModel();
    }
    
    public function get() {
        return $this->resultData;
    }

    /**
     * @param String $type
     * @return $this
     */
    public function articles(String $type)
    {
        $this->resultData = $this->model->getArticles($type);

        return $this;
    }

    /**
     * @param String $page
     * @param int $perPage
     * @return $this
     */
    public function paginate(int $page = 1, int $perPage = self::PER_PAGE) {
        $items = &$this->resultData->rss['_value']['channel']['item'];
        $this->totalPage = ceil(count($items) / $perPage);
        
        $items = array_slice($items, ($page - 1) * $perPage, $perPage);

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPages() {
        return $this->totalPage;
    }

    public function parseDescription(String $str) {
        $regex = '/"([^<]*)".*"(?<img>[^<]*)".*<\/br>(?<desc>.*)/m';
        preg_match_all($regex, $str, $matches, PREG_SET_ORDER, 0);
        return $matches[0] ?? ['img'=>'', 'desc'=>''];
    }
    
    private function createModel()
    {
        if (!$this->model) {
            $this->model = $this->newsFactory->create();
        }
    }
}
