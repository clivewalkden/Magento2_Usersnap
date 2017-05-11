<?php

namespace CliveWalkden\Usersnap\Test\Unit\Block;

class DisplayTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \CliveWalkden\Usersnap\Helper\Data
     */
    protected $helper;

    /**
     * @var \CliveWalkden\Usersnap\Block\Display
     */
    protected $block;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->block = $objectManager->getObject('CliveWalkden\Usersnap\Block\Display');
        $this->helper = $objectManager->getObject('CliveWalkden\Usersnap\Helper\Data');
    }

    public function testGetWidgetId()
    {
        $this->assertTrue(false);
    }

    protected function tearDown()
    {
        $this->block = null;
        $this->helper = null;
    }
}
