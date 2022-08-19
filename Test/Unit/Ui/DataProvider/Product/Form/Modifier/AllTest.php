<?php
namespace Hcl\Subscription\Test\Unit\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Ui\DataProvider\Product\Form\Modifier\All
 */
class AllTest extends TestCase
{
    /**
     * Mock pool
     *
     * @var \Magento\Ui\DataProvider\Modifier\PoolInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $pool;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Ui\DataProvider\Product\Form\Modifier\All
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->pool = $this->createMock(\Magento\Ui\DataProvider\Modifier\PoolInterface::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Ui\DataProvider\Product\Form\Modifier\All::class,
            [
                'pool' => $this->pool,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestModifyData()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestModifyData
     */
    public function testModifyData(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestModifyMeta()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestModifyMeta
     */
    public function testModifyMeta(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }
}
