<?php
namespace Hcl\Subscription\Test\Unit\Model\Source;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Model\Source\State
 */
class StateTest extends TestCase
{
    /**
     * Mock helper
     *
     * @var \Hcl\Subscription\Helper\Data|PHPUnit\Framework\MockObject\MockObject
     */
    private $helper;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Model\Source\State
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->helper = $this->createMock(\Hcl\Subscription\Helper\Data::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Model\Source\State::class,
            [
                'helper' => $this->helper,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetOptionArray()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetOptionArray
     */
    public function testGetOptionArray(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestToOptionArray()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestToOptionArray
     */
    public function testToOptionArray(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }
}
