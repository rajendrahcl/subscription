<?php
namespace Hcl\Subscription\Test\Unit\Observer;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Observer\CheckoutIndexActionObserver
 */
class CheckoutIndexActionObserverTest extends TestCase
{
    /**
     * Mock context
     *
     * @var \Magento\Framework\App\Action\Context|PHPUnit\Framework\MockObject\MockObject
     */
    private $context;

    /**
     * Mock session
     *
     * @var \Magento\Checkout\Model\Session|PHPUnit\Framework\MockObject\MockObject
     */
    private $session;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Observer\CheckoutIndexActionObserver
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->context = $this->createMock(\Magento\Framework\App\Action\Context::class);
        $this->session = $this->createMock(\Magento\Checkout\Model\Session::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Observer\CheckoutIndexActionObserver::class,
            [
                'context' => $this->context,
                'session' => $this->session,
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
