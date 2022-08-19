<?php
namespace Hcl\Subscription\Test\Unit\Observer;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Observer\OrderSaveAfter
 */
class OrderSaveAfterTest extends TestCase
{
    /**
     * Mock logger
     *
     * @var \Psr\Log\LoggerInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $logger;

    /**
     * Mock resource
     *
     * @var \Magento\Framework\App\ResourceConnection|PHPUnit\Framework\MockObject\MockObject
     */
    private $resource;

    /**
     * Mock subscriptionRepository
     *
     * @var \Hcl\Subscription\Api\SubscriptionRepositoryInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $subscriptionRepository;

    /**
     * Mock collectionFactoryInstance
     *
     * @var \Hcl\Subscription\Model\ResourceModel\Subscription\Collection|PHPUnit\Framework\MockObject\MockObject
     */
    private $collectionFactoryInstance;

    /**
     * Mock collectionFactory
     *
     * @var \Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory|PHPUnit\Framework\MockObject\MockObject
     */
    private $collectionFactory;

    /**
     * Mock dataHelper
     *
     * @var \Hcl\Subscription\Helper\Data|PHPUnit\Framework\MockObject\MockObject
     */
    private $dataHelper;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Observer\OrderSaveAfter
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->resource = $this->createMock(\Magento\Framework\App\ResourceConnection::class);
        $this->subscriptionRepository = $this->createMock(\Hcl\Subscription\Api\SubscriptionRepositoryInterface::class);
        $this->collectionFactoryInstance = $this->createMock(\Hcl\Subscription\Model\ResourceModel\Subscription\Collection::class);
        $this->collectionFactory = $this->createMock(\Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory::class);
        $this->collectionFactory->method('create')->willReturn($this->collectionFactoryInstance);
        $this->dataHelper = $this->createMock(\Hcl\Subscription\Helper\Data::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Observer\OrderSaveAfter::class,
            [
                'logger' => $this->logger,
                'resource' => $this->resource,
                'subscriptionRepository' => $this->subscriptionRepository,
                'collectionFactory' => $this->collectionFactory,
                'dataHelper' => $this->dataHelper,
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
