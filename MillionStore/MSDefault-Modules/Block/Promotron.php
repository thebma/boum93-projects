<?php

namespace MillionStore\MSDefault\Block;

class Promotron extends \Magento\Framework\View\Element\Template
{
    protected $_request;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        array $data = array()
    )
    {
        parent::__construct($context, $data);
        $this->_request = $request;
    }

    public function isOnLandingPage() {
        return $this->_request->getFullActionName() == 'cms_index_index';
    }


    public function getArgOrDefault($key, $default)
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

    public function getPromotionBackdrop()
    {
        $promoBackdrop = $this->getArgOrDefault("promotron_image", "");
        return $this->getViewFileUrl($promoBackdrop);
    }

    public function getPromotionText() 
    {
        $promoText = $this->getArgOrDefault("promotron_heading", "");
        return $promoText;
    }

    public function getPromotionSubText() 
    {
        $promoSubText = $this->getArgOrDefault("promotron_sub", "");
        return $promoSubText;
    }
}