<?php
namespace Hcl\Subscription\Test\Unit\Helper;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Helper\Data
 */
class DataTest extends TestCase
{
    /**
     * Mock context
     *
     * @var \Magento\Framework\App\Helper\Context|PHPUnit\Framework\MockObject\MockObject
     */
    private $context;

    /**
     * Mock subsctiptionInstance
     *
     * @var \Hcl\Subscription\Model\Subscription|PHPUnit\Framework\MockObject\MockObject
     */
    private $subsctiptionInstance;

    /**
     * Mock subsctiption
     *
     * @var \Hcl\Subscription\Model\SubscriptionFactory|PHPUnit\Framework\MockObject\MockObject
     */
    private $subsctiption;

    /**
     * Mock order
     *
     * @var \Magento\Sales\Api\Data\OrderInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $order;

    /**
     * Mock date
     *
     * @var \Magento\Framework\Stdlib\DateTime\DateTime|PHPUnit\Framework\MockObject\MockObject
     */
    private $date;

    /**
     * Mock productRepositoryInterface
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $productRepositoryInterface;

    /**
     * Mock productOptionRepositoryInterface
     *
     * @var \Magento\Bundle\Api\ProductOptionRepositoryInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $productOptionRepositoryInterface;

    /**
     * Mock customOption
     *
     * @var \Magento\Catalog\Model\Product\Option|PHPUnit\Framework\MockObject\MockObject
     */
    private $customOption;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Helper\Data
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->context = $this->createMock(\Magento\Framework\App\Helper\Context::class);
        $this->subsctiptionInstance = $this->createMock(\Hcl\Subscription\Model\Subscription::class);
        $this->subsctiption = $this->createMock(\Hcl\Subscription\Model\SubscriptionFactory::class);
        $this->subsctiption->method('create')->willReturn($this->subsctiptionInstance);
        $this->order = $this->createMock(\Magento\Sales\Api\Data\OrderInterface::class);
        $this->date = $this->createMock(\Magento\Framework\Stdlib\DateTime\DateTime::class);
        $this->productRepositoryInterface = $this->createMock(\Magento\Catalog\Api\ProductRepositoryInterface::class);
        $this->productOptionRepositoryInterface = $this->createMock(\Magento\Bundle\Api\ProductOptionRepositoryInterface::class);
        $this->customOption = $this->createMock(\Magento\Catalog\Model\Product\Option::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Helper\Data::class,
            [
                'context' => $this->context,
                'subsctiption' => $this->subsctiption,
                'order' => $this->order,
                'date' => $this->date,
                'productRepositoryInterface' => $this->productRepositoryInterface,
                'productOptionRepositoryInterface' => $this->productOptionRepositoryInterface,
                'customOption' => $this->customOption,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestSaveHclSubscriptionForOrder()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestSaveHclSubscriptionForOrder
     */
    public function testSaveHclSubscriptionForOrder(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetSubscriptionState()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetSubscriptionState
     */
    public function testGetSubscriptionState(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetState()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetState
     */
    public function testGetState(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetStatus()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetStatus
     */
    public function testGetStatus(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestCalculateSubscriptionStartDate()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestCalculateSubscriptionStartDate
     */
    public function testCalculateSubscriptionStartDate(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestCalculateSubscriptionEndDate()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestCalculateSubscriptionEndDate
     */
    public function testCalculateSubscriptionEndDate(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestIsModuleOutputEnabled()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestIsModuleOutputEnabled
     */
    public function testIsModuleOutputEnabled(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }
}
