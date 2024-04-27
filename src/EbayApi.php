<?php

namespace TremulantTech\LaravelEbayApi;

use DTS\eBaySDK\Sdk;

/**
 * Proxy to DTS\eBaySDK
 *
 * @method \DTS\eBaySDK\Account\Services\AccountService account(array $args = [])
 * @method \DTS\eBaySDK\Analytics\Services\AnalyticsService analytics(array $args = [])
 * @method \DTS\eBaySDK\Browse\Services\BrowseService browse(array $args = [])
 * @method \DTS\eBaySDK\BulkDataExchange\Services\BulkDataExchangeService bulkDataExchange(array $args = [])
 * @method \DTS\eBaySDK\BusinessPoliciesManagement\Services\BusinessPoliciesManagementService businessPoliciesManagement(array $args = [])
 * @method \DTS\eBaySDK\Feedback\Services\FeedbackService feedback(array $args = [])
 * @method \DTS\eBaySDK\FileTransfer\Services\FileTransferService fileTransfer(array $args = [])
 * @method \DTS\eBaySDK\Finding\Services\FindingService finding(array $args = [])
 * @method \DTS\eBaySDK\Fulfillment\Services\FulfillmentService fulfillment(array $args = [])
 * @method \DTS\eBaySDK\HalfFinding\Services\HalfFindingService halfFinding(array $args = [])
 * @method \DTS\eBaySDK\Inventory\Services\InventoryService inventory(array $args = [])
 * @method \DTS\eBaySDK\Marketing\Services\MarketingService marketing(array $args = [])
 * @method \DTS\eBaySDK\Merchandising\Services\MerchandisingService merchandising(array $args = [])
 * @method \DTS\eBaySDK\Metadata\Services\MetadataService metadata(array $args = [])
 * @method \DTS\eBaySDK\Order\Services\OrderService order(array $args = [])
 * @method \DTS\eBaySDK\PostOrder\Services\PostOrderService postOrder(array $args = [])
 * @method \DTS\eBaySDK\Product\Services\ProductService product(array $args = [])
 * @method \DTS\eBaySDK\ProductMetadata\Services\ProductMetadataService productMetadata(array $args = [])
 * @method \DTS\eBaySDK\RelatedItemsManagement\Services\RelatedItemsManagementService relatedItemsManagement(array $args = [])
 * @method \DTS\eBaySDK\ResolutionCaseManagement\Services\ResolutionCaseManagementService resolutionCaseManagement(array $args = [])
 * @method \DTS\eBaySDK\ReturnManagement\Services\ReturnManagementService returnManagement(array $args = [])
 * @method \DTS\eBaySDK\Shopping\Services\ShoppingService shopping(array $args = [])
 * @method \DTS\eBaySDK\Trading\Services\TradingService trading(array $args = [])
 */
class EbayApi
{
    private ?Sdk $ebaySdk = null;

    private array $config;

    const API_CLASSES = [
        'account' => \DTS\eBaySDK\Account\Services\AccountService::class,
        'analytics' => \DTS\eBaySDK\Analytics\Services\AnalyticsService::class,
        'browse' => \DTS\eBaySDK\Browse\Services\BrowseService::class,
        'bulkDataExchange' => \DTS\eBaySDK\BulkDataExchange\Services\BulkDataExchangeService::class,
        'businessPoliciesManagement' => \DTS\eBaySDK\BusinessPoliciesManagement\Services\BusinessPoliciesManagementService::class,
        'feedback' => \DTS\eBaySDK\Feedback\Services\FeedbackService::class,
        'fileTransfer' => \DTS\eBaySDK\FileTransfer\Services\FileTransferService::class,
        'finding' => \DTS\eBaySDK\Finding\Services\FindingService::class,
        'fulfillment' => \DTS\eBaySDK\Fulfillment\Services\FulfillmentService::class,
        'halfFinding' => \DTS\eBaySDK\HalfFinding\Services\HalfFindingService::class,
        'inventory' => \DTS\eBaySDK\Inventory\Services\InventoryService::class,
        'marketing' => \DTS\eBaySDK\Marketing\Services\MarketingService::class,
        'merchandising' => \DTS\eBaySDK\Merchandising\Services\MerchandisingService::class,
        'metadata' => \DTS\eBaySDK\Metadata\Services\MetadataService::class,
        'order' => \DTS\eBaySDK\Order\Services\OrderService::class,
        'postOrder' => \DTS\eBaySDK\PostOrder\Services\PostOrderService::class,
        'product' => \DTS\eBaySDK\Product\Services\ProductService::class,
        'productMetadata' => \DTS\eBaySDK\ProductMetadata\Services\ProductMetadataService::class,
        'relatedItemsManagement' => \DTS\eBaySDK\RelatedItemsManagement\Services\RelatedItemsManagementService::class,
        'resolutionCaseManagement' => \DTS\eBaySDK\ResolutionCaseManagement\Services\ResolutionCaseManagementService::class,
        'returnManagement' => \DTS\eBaySDK\ReturnManagement\Services\ReturnManagementService::class,
        'shopping' => \DTS\eBaySDK\Shopping\Services\ShoppingService::class,
        'trading' => \DTS\eBaySDK\Trading\Services\TradingService::class,
    ];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __call(string $name, array $arguments)
    {
        if (!$this->ebaySdk) {
            $this->ebaySdk = new Sdk([
                'credentials' => $this->config['sandbox']['credentials'],
                'authorization' => $this->config['sandbox']['oauthUserToken'],
                'authToken' => $this->config['sandbox']['authToken'],
                'siteId' => $this->config['siteId'],
                'globalId' => \DTS\eBaySDK\Constants\GlobalIds::US,
                'sandbox' => true
            ]);
        }

        return $this->ebaySdk->{'create' . ucfirst($name)}($arguments[0] ?? []);
    }
}
