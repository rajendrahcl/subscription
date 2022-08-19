<?php
namespace Hcl\Subscription\Test\Unit\Observer;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Observer\OrderObserver
 */
class OrderObserverTest extends TestCase
{
    /**
     * Mock hclHelper
     *
     * @var \Hcl\Subscription\Helper\Data|PHPUnit\Framework\MockObject\MockObject
     */
    private $hclHelper;

    /**
     * Mock helperConfig
     *
     * @var \Hcl\Subscription\Helper\Config|PHPUnit\Framework\MockObject\MockObject
     */
    private $helperConfig;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Observer\OrderObserver
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->hclHelper = $this->createMock(\Hcl\Subscription\Helper\Data::class);
        $this->helperConfig = $this->createMock(\Hcl\Subscription\Helper\Config::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Observer\OrderObserver::class,
            [
                'hclHelper' => $this->hclHelper,
                'helperConfig' => $this->helperConfig,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestExecute()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestExecute
     */
    public function testExecute(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }
}
