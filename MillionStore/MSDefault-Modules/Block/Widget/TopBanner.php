<?php
namespace MillionStore\MSDefault\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class TopBanner extends Template implements BlockInterface
{
    protected $_template = "widget/top-banner.phtml";
}