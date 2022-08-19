<?php
namespace Hcl\Subscription\Test\Unit\Setup\Patch\Data;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Setup\Patch\Data\AddSubscriptionInDaysProductAttribute
 */
class AddSubscriptionInDaysProductAttributeTest extends TestCase
{
    /**
     * Mock moduleDataSetup
     *
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $moduleDataSetup;

    /**
     * Mock eavSetupFactoryInstance
     *
     * @var \Magento\Eav\Setup\EavSetup|PHPUnit\Framework\MockObject\MockObject
     */
    private $eavSetupFactoryInstance;

    /**
     * Mock eavSetupFactory
     *
     * @var \Magento\Eav\Setup\EavSetupFactory|PHPUnit\Framework\MockObject\MockObject
     */
    private $eavSetupFactory;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Setup\Patch\Data\AddSubscriptionInDaysProductAttribute
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->moduleDataSetup = $this->createMock(\Magento\Framework\Setup\ModuleDataSetupInterface::class);
        $this->eavSetupFactoryInstance = $this->createMock(\Magento\Eav\Setup\EavSetup::class);
        $this->eavSetupFactory = $this->createMock(\Magento\Eav\Setup\EavSetupFactory::class);
        $this->eavSetupFactory->method('create')->willReturn($this->eavSetupFactoryInstance);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Setup\Patch\Data\AddSubscriptionInDaysProductAttribute::class,
            [
                'moduleDataSetup' => $this->moduleDataSetup,
                'eavSetupFactory' => $this->eavSetupFactory,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestApply()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestApply
     */
    public function testApply(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestRevert()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestRevert
     */
    public function testRevert(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetAliases()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetAliases
     */
    public function testGetAliases(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }
}
