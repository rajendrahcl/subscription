<?php
namespace Hcl\Subscription\Test\Unit\Helper;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \Hcl\Subscription\Helper\Send
 */
class SendTest extends TestCase
{
    /**
     * Mock context
     *
     * @var \Magento\Framework\App\Helper\Context|PHPUnit\Framework\MockObject\MockObject
     */
    private $context;

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
     * Mock storeManager
     *
     * @var \Magento\Store\Model\StoreManagerInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $storeManager;

    /**
     * Mock transportBuilder
     *
     * @var \Magento\Framework\Mail\Template\TransportBuilder|PHPUnit\Framework\MockObject\MockObject
     */
    private $transportBuilder;

    /**
     * Mock inlineTranslation
     *
     * @var \Magento\Framework\Translate\Inline\StateInterface|PHPUnit\Framework\MockObject\MockObject
     */
    private $inlineTranslation;

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
     * Mock confighelper
     *
     * @var \Hcl\Subscription\Helper\Config|PHPUnit\Framework\MockObject\MockObject
     */
    private $confighelper;

    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Object to test
     *
     * @var \Hcl\Subscription\Helper\Send
     */
    private $testObject;

    /**
     * Main set up method
     */
    public function setUp() : void
    {
        $this->objectManager = new ObjectManager($this);
        $this->context = $this->createMock(\Magento\Framework\App\Helper\Context::class);
        $this->collectionFactoryInstance = $this->createMock(\Hcl\Subscription\Model\ResourceModel\Subscription\Collection::class);
        $this->collectionFactory = $this->createMock(\Hcl\Subscription\Model\ResourceModel\Subscription\CollectionFactory::class);
        $this->collectionFactory->method('create')->willReturn($this->collectionFactoryInstance);
        $this->storeManager = $this->createMock(\Magento\Store\Model\StoreManagerInterface::class);
        $this->transportBuilder = $this->createMock(\Magento\Framework\Mail\Template\TransportBuilder::class);
        $this->inlineTranslation = $this->createMock(\Magento\Framework\Translate\Inline\StateInterface::class);
        $this->logger = $this->createMock(\Psr\Log\LoggerInterface::class);
        $this->resource = $this->createMock(\Magento\Framework\App\ResourceConnection::class);
        $this->confighelper = $this->createMock(\Hcl\Subscription\Helper\Config::class);
        $this->testObject = $this->objectManager->getObject(
        \Hcl\Subscription\Helper\Send::class,
            [
                'context' => $this->context,
                'collectionFactory' => $this->collectionFactory,
                'storeManager' => $this->storeManager,
                'transportBuilder' => $this->transportBuilder,
                'inlineTranslation' => $this->inlineTranslation,
                'logger' => $this->logger,
                'resource' => $this->resource,
                'confighelper' => $this->confighelper,
            ]
        );
    }

    /**
     * @return array
     */
    public function dataProviderForTestSubscriptionCollection()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestSubscriptionCollection
     */
    public function testSubscriptionCollection(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestSendMail()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestSendMail
     */
    public function testSendMail(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetStoreId()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetStoreId
     */
    public function testGetStoreId(array $prerequisites, array $expectedResult)
    {
        $this->assertEquals($expectedResult['param'], $prerequisites['param']);
    }

    /**
     * @return array
     */
    public function dataProviderForTestGetStore()
    {
        return [
            'Testcase 1' => [
                'prerequisites' => ['param' => 1],
                'expectedResult' => ['param' => 1]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestGetStore
     */
    public function testGetStore(array $prerequisites, array $expectedResult)
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
