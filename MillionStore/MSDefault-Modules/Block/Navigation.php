<?php

namespace MillionStore\MSDefault\Block;

//TODO: All of these variables should be configurable from the backend.
//      But as of now I have no clue how to do so, a thing to investigate later.
//      ~A.Bouma 02/10/20
class Navigation extends \Magento\Framework\View\Element\Template
{
    protected $_storeManager;
    protected $_request;
    protected $categoryRepo;
    protected $categoryFactory;

    private $logoSize = 1;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context, 
        \Magento\Framework\App\Request\Http $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = array())
    {
        parent::__construct($context, $data);

        $this->_request = $request;
        $this->_storeManager = $storeManager;
        $this->categoryRepo = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
    }
    
    public function getArgumentOrDefault($key, $default)
    {
        $keyValue = $this->getData($key);

        if(empty($keyValue)) 
        {
            return $default;
        } 
        else
        {
            return $keyValue;
        }
    }

    public function isOnLandingPage() {
        return $this->_request->getFullActionName() == 'cms_index_index';
    }

    public function isOnPrintPage() {
        return $this->_request->getFullActionName() == "sales_order_print";
    }

    public function getLogoSrc($isLight)
    {
        $imgUrl = "";

        if($isLight)
        {
            $imgUrl = $this->getArgumentOrDefault("logo_src_light", "images/logo.svg");
        }
        else
        {
            $imgUrl = $this->getArgumentOrDefault("logo_src_dark", "images/logo.svg");
        }
        
        return $this->getViewFileUrl($imgUrl);
    }

    public function getLogoAlt()
    {
        return $this->getArgumentOrDefault("logo_alt", "Store logo");
    }

    public function getLogoWidth()
    {
        $width =  $this->getArgumentOrDefault("logo_width", 600);

        if($this->isOnLandingPage()) {
            return $width;
        }

        return $width / $this->logoSize;
    }

    public function getLogoHeight() 
    {
        $height = $this->getArgumentOrDefault("logo_height", 250);

        if($this->isOnLandingPage()) {
            return $height;
        }

        return $height / $this->logoSize;
    }

    public function getCategoryUrl($id) 
    {
        $storeId = $this->_storeManager->getStore()->getId();
        $categoryObj = $this->categoryRepo->get($id, $storeId);
        return $categoryObj->getUrl();
    }

    public function getCategoryUrlByName($categoryName)
    {   
        $collection = $this->categoryFactory->create()->getCollection()
            ->addAttributeToFilter("name", $categoryName)
            ->setPageSize(1);

        if(empty($collection)) {
            return -2;
        }

        if ($collection->getSize()) {
            return $collection->getFirstItem()->getId();
        }

        return -1;
    }

    public function getCategoryLinkMap($names)
    {
        $linkMap = array();

        foreach($names as $name)
        {
            $link = $this->getCategoryUrlByName($name);

            if(!$link || $link < 0) 
            {
                $linkMap[$name] = "#" . abs($link);
            }
            else
            {
                $linkMap[$name] = $this->getCategoryUrl($link);
            }
        }

        return $linkMap;
    }
}