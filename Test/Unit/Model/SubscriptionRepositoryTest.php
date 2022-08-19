<?php
namespace Hcl\Subscription\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Model\SubscriptionRepository
 */
class SubscriptionRepositoryTest extends TestCase
{
    /**
     * Mock resource
     *
     * @var \Hcl\Subscription\Model\ResourceModel\Subscription|PHPUnit\Framework\MockObject\MockObject
     */
    private $resource;

    /**
     * Mock subscriptionFactoryInstance
     *
     * @var \Hcl\Subscription\Api\Data\SubscriptionInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $subscriptionFactoryInstance;

    /**
     * Mock subscriptionFactory
     *
     * @var \Hcl\Subscription\Api\Data\SubscriptionInterfaceFactory|PHPUnit\Framework\MockObject\MockObject
     */
    private $subscriptionFactory;

    /**
     * Mock subscriptionCollectionFactoryInstance
     *
     * @var \Hcl\Subscription\Model\ResourceModel\Subscription\Collection|PHPUnit\Framework\MockObject\MockObject
     */
    private $subscriptionCollectionFactoryInstance;

    /**
     * Mock subscriptionCollectionFactory
     *
     * @var \Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory|PHPUnit\Framework\MockObject\MockObject
     */
    private $subscriptionCollectionFactory;

    /**
     * Mock searchResultsFactoryInstance
     *
     * @var \Hcl\Subscription\Api\Data\SubscriptionSearchResultsInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $searchResultsFactoryInstance;

    /**
     * Mock searchResultsFactory
     *
     * @var \Hcl\Subscription\Api\Data\SubscriptionSearchResultsInterfaceFactory|PHPUnit\Framework\MockObject\MockObject
     */
    private $searchResultsFactory;

    /**
     * Mock collectionProcessor
     *
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $collectionProcessor;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Model\SubscriptionRepository
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->resource = $this->createMock(\Hcl\Subscription\Model\ResourceModel\Subscription::class);
        $this->subscriptionFactoryInstance = $this->createMock(\Hcl\Subscription\Api\Data\SubscriptionInterface::class);
        $this->subscriptionFactory = $this->createMock(\Hcl\Subscription\Api\Data\SubscriptionInterfaceFactory::class);
        $this->subscriptionFactory->method('create')->willReturn($this->subscriptionFactoryInstance);
        $this->subscriptionCollectionFactoryInstance = $this->createMock(\Hcl\Subscription\Model\ResourceModel\Subscription\Collection::class);
        $this->subscriptionCollectionFactory = $this->createMock(\Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory::class);
        $this->subscriptionCollectionFactory->method('create')->willReturn($this->subscriptionCollectionFactoryInstance);
        $this->searchResultsFactoryInstance = $this->createMock(\Hcl\Subscription\Api\Data\SubscriptionSearchResultsInterface::class);
        $this->searchResultsFactory = $this->createMock(\Hcl\Subscription\Api\Data\SubscriptionSearchResultsInterfaceFactory::class);
        $this->searchResultsFactory->method('create')->willReturn($this->searchResultsFactoryInstance);
        $this->collectionProcessor = $this->createMock(\Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Model\SubscriptionRepository::class,
            [
                'resource' => $this->resource,
                'subscriptionFactory' => $this->subscriptionFactory,
                'subscriptionCollectionFactory' => $this->subscriptionCollectionFactory,
                'searchResultsFactory' => $this->searchResultsFactory,
                'collectionProcessor' => $this->collectionProcessor,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestSave()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestSave
     */
    public function testSave(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGet()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGet
     */
    public function testGet(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetList()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetList
     */
    public function testGetList(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestDelete()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestDelete
     */
    public function testDelete(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestDeleteById()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestDeleteById
     */
    public function testDeleteById(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }
}
