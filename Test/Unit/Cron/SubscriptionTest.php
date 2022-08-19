<?php
namespace Hcl\Subscription\Test\Unit\Cron;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Cron\Subscription
 */
class SubscriptionTest extends TestCase
{
    /**
     * Mock sendhelper
     *
     * @var \Hcl\Subscription\Helper\Send|PHPUnit\Framework\MockObject\MockObject
     */
    private $sendhelper;

    /**
     * Mock datahelper
     *
     * @var \Hcl\Subscription\Helper\Data|PHPUnit\Framework\MockObject\MockObject
     */
    private $datahelper;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Cron\Subscription
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->sendhelper = $this->createMock(\Hcl\Subscription\Helper\Send::class);
        $this->datahelper = $this->createMock(\Hcl\Subscription\Helper\Data::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Cron\Subscription::class,
            [
                'sendhelper' => $this->sendhelper,
                'datahelper' => $this->datahelper,
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
