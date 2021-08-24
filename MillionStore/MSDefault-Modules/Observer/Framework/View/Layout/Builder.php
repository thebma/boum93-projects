<?php
namespace MillionStore\MSDefault\Observer\Framework\View\Layout;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config as PageConfig;

class Builder implements ObserverInterface
{
    /** @var PageConfig $pageConfig */
    private $pageConfig;

    private $_attributes = [];

    /**
     * Builder constructor.
     *
     * @param PageConfig  $pageConfig
     */
    public function __construct(PageConfig $pageConfig) {
        $this->pageConfig  = $pageConfig;

        //Preconnects
        $this->addPreconnect("googleAnalytics", "https://www.google-analytics.com");
        
        //Stylesheets
        $this->addPreload("stylesheet_medium", "style", "static/frontend/MillionStore/MSDefault/nl_NL/css/styles-m.css");
        $this->addPreload("stylesheet_large", "style", "static/frontend/MillionStore/MSDefault/nl_NL/css/styles-l.css");
        $this->addPreload("font-awesome", "style", "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
        $this->addPreload("main-font-style", "style", "https://fonts.googleapis.com/css2?family=Piazzolla:wght@500&display=swap");

        //Fonts
        $this->addPreload("main-font", "font", "https://fonts.gstatic.com/s/piazzolla/v3/N0b52SlTPu5rIkWIZjVKKtYtfxYqZ4RJBFzFfYUjkSDdlqZgy7LqxkL13gA.woff2");
        //$this->addPreload("black-theme-icons", "font", "static/frontend/MillionStore/MSDefault/nl_NL/fonts/Blank-Theme-Icons/Blank-Theme-Icons.woff2");
        //$this->addPreload("black-theme-icons2", "font", "static/frontend/MillionStore/MSDefault/nl_NL/fonts/Blank-Theme-Icons/Blank-Theme-Icons.woff");
        //$this->addPreload("fallback-font-regularwoff2", "font", "static/frontend/MillionStore/MSDefault/nl_NL/fonts/opensans/regular/opensans-400.woff2");
        //$this->addPreload("fallback-font-boldwoff2", "font", "static/frontend/MillionStore/MSDefault/nl_NL/fonts/opensans/bold/opensans-700.woff2");
        //$this->addPreload("fallback-font-regularwoff", "font", "static/frontend/MillionStore/MSDefault/nl_NL/fonts/opensans/regular/opensans-400.woff");
        //$this->addPreload("fallback-font-boldwoff", "font", "static/frontend/MillionStore/MSDefault/nl_NL/fonts/opensans/bold/opensans-700.woff");

    }

    /**
     * @param Observer $observer
     *
     * @return $this
     */
    public function execute(Observer $observer)
    {
        foreach ($this->_attributes as $resource) {
            $attributes = [];
            $attributes['rel'] = $resource['type'];

            if($resource['type'] == 'preload') {
                $attributes['as'] = $resource['as'];
            }

            $this->pageConfig->addRemotePageAsset(
                $resource['resource'],
                'link_rel',
                [
                    'attributes' => $attributes
                ]
            );
        }

        return $this;
    }

    private function addPreload($name, $as, $resource) {
        $this->_attributes[$name] = [
            'resource' => $resource,
            'type' => 'preload',
            'crossorigin' => 'anonymous',
            'as' => $as,
        ];
    }

    private function addPreconnect($name, $resource) {
        $this->_attributes[$name] = [
            "resource" => $resource,
            "type" => "preconnect"
        ];
    }
}