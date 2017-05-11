<?php
namespace CliveWalkden\Usersnap\Test\Unit\Helper;

use Magento\Store\Model\ScopeInterface;

class DataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CliveWalkden\Usersnap\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $configMock;

    protected function setUp()
    {
        $objectManagerHelper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $className = 'CliveWalkden\Usersnap\Helper\Data';
        $arguments = $objectManagerHelper->getConstructArguments($className);
        /** @var \Magento\Framework\App\Helper\Context $context */
        $context = $arguments['context'];
        $this->configMock = $context->getScopeConfig();
        $this->helper = $objectManagerHelper->getObject($className, $arguments);

        $this->configMock = $this->getMockBuilder('Magento\Framework\View\Page\Config')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @covers \Magento\Captcha\Helper\Data::getConfig
     */
    public function testDefaultStatus()
    {
        $defaultValue = false;

        $scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $scopeConfigMock->method('getValue')
            ->willReturn($defaultValue);

        $this->assertEquals($defaultValue, $this->helper->getEnabled());
    }

    /**
     * @covers \Magento\Captcha\Helper\Data::getConfig
     */
    public function testWidgetValue()
    {
        $testValue = '2727dfjhsdfjhk378y93efsd.js';

        $scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $scopeConfigMock->method('getValue')
            ->willReturn($testValue);

        $this->assertEquals($testValue, $this->helper->getWidgetId());
    }
}
