<?php
namespace Bc\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Log\Loggable;
use Plenty\Modules\Item\DataLayer\Contracts\ItemDataLayerRepositoryContract;
use Plenty\Modules\Item\Item\Contracts\ItemRepositoryContract;
use Plenty\Modules\Item\VariationStock\Contracts\VariationStockRepositoryContract;

use Plenty\Modules\StockManagement\Stock\Contracts\StockRepositoryContract;
use Plenty\Modules\StockManagement\Stock\Models\Stock;

use Plenty\Plugin\Application;
use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Item\DataLayer\Models\RecordList;

//use Plenty\Modules\Item\Variation\Contracts\VariationSearchRepositoryContract;
use Illuminate\Support\Collection;
use Plenty\Repositories\Models\PaginatedResult;

use Plenty\Modules\Plugin\Libs\Contracts\LibraryCallContract;

use Bc\Helper\StockHelper;

/**
 * Class ContentController
 * @package HelloWorld\Controllers
 */
class ContentController extends Controller
{
	use Loggable;
	
	public $libCall;
	public $itemDataLayerRepository;
	public $stockHelper;
	public $stockRepository;
	
	public function __construct(LibraryCallContract $libCall, ItemDataLayerRepositoryContract $itemDataLayerRepository, StockHelper $stockHelper, StockRepositoryContract $stockRepositoryContract){
		$this->libCall = $libCall;
		$this->itemDataLayerRepository = $itemDataLayerRepository;
		$this->stockHelper = $stockHelper;
		$this->stockRepository = $stockRepositoryContract;
	}
	
	/**
	 * @param Twig $twig
	 * @return string
	 */
	public function sayHelloGetOrders(Twig $twig)
	{
		
		$this->getLogger(__METHOD__)->error('Bc::TEST1', 'TEST');
		$resultFields = [
			'itemBase' => [
				'id',
				'producer',
			],

			'itemShippingProfilesList' => [
				'id',
				'name',
			],

			'itemDescription' => [
				'params' => 10,
				'fields' => [
					'name1',
					'description',
					'shortDescription',
					'technicalData',
					'keywords',
					'lang',
				],
			],

			'variationMarketStatus' => [
				'params' => [
					'marketId' => 10
				],
				'fields' => [
					'id',
					'sku',
					'marketStatus',
					'additionalInformation',
				]
			],

			'variationBase' => [
				'id',
				'limitOrderByStockSelect',
				'weightG',
				'lengthMm',
				'widthMm',
				'heightMm',
				'attributeValueSetId',
			],

			'variationRetailPrice' => [
				'price',
				'currency',
			],
			'variationStandardCategory' => [
				'params' => [
					'plentyId' => pluginApp(Application::class)->getPlentyId(),
				],
				'fields' => [
					'categoryId'
				],
			],			

			'itemCharacterList' => [
				'itemCharacterId',
				'characterId',
				'characterValue',
				'characterValueType',
				'isOrderCharacter',
				'characterOrderMarkup'
			],

			'variationAttributeValueList' => [
				'attributeId',
				'attributeValueId'
			],

			'variationImageList' => [
				'params' => [
					'all_images'                                       => [
						'type'                 => 'all', // all images
						'fileType'             => ['gif', 'jpeg', 'jpg', 'png'],
						'imageType'            => ['internal'],
						'referenceMarketplace' => 10,
					],
					'only_current_variation_images_and_generic_images' => [
						'type'                 => 'item_variation', // current variation + item images
						'fileType'             => ['gif', 'jpeg', 'jpg', 'png'],
						'imageType'            => ['internal'],
						'referenceMarketplace' => 10,
					],
					'only_current_variation_images'                    => [
						'type'                 => 'variation', // current variation images
						'fileType'             => ['gif', 'jpeg', 'jpg', 'png'],
						'imageType'            => ['internal'],
						'referenceMarketplace' => 10,
					],
					'only_generic_images'                              => [
						'type'                 => 'item', // only item images
						'fileType'             => ['gif', 'jpeg', 'jpg', 'png'],
						'imageType'            => ['internal'],
						'referenceMarketplace' => 10,
					],
				],
				'fields' => [
					'imageId',
					'type',
					'fileType',
					'path',
					'position',
					'attributeValueId',
				],
			],
		];
		
		
		$itemFilter = [
				'itemBase.wasUpdatedBetween' => [
					'timestampFrom' => strtotime("-1 days"),
					'timestampTo'   => time(),
				],
				'variationBase.isActive?' => [],
				'variationVisibility.isVisibleForMarketplace' => [
					'mandatoryOneMarketplace' => [],
					'mandatoryAllMarketplace' => [
						10
					]
				],
			];
		
		$itemParams = [
		    'language' => 'en'
		];
		
		$check = $this->itemDataLayerRepository->search($resultFields, $itemFilter, $itemParams);
		$this->getLogger(__METHOD__)->error('Bc::CHECK11', $check);
		$this->getLogger(__METHOD__)->error('Bc::TEST21', 'TEST');
	}
	
	public function sayHello(Twig $twig, ItemDataLayerRepositoryContract $itemRepository):string
    	{
		$sofortRequestParams['id'] = '123';
		$paymentResult = $this->libCall->call('Bc::getConnection', ['packagist_query' => 'plentymarkets']);
		$this->getLogger(__METHOD__)->error('Bc::LIBCALLLLLLKKKNNKKKKK', $paymentResult);
		$itemColumns = [
			'itemDescription' => [				
				'name1',
				'name2',
				'name3',
				'description',
				'shortDescription',
				'technicalData',
				'keywords',
				'lang'		
			],
			'itemBase' => [				
				'id',
				'createDate',
				'lastUpdateTimestamp',
				'type',
				'variationCount',
				'producerId',
				'defaultShippingCost',
				'createDate',
				'variationCount'
			],
			'variationBase' => [
				'id',
				'limitOrderByStockSelect',
				'weightG',
				'lengthMm',
				'widthMm',
				'heightMm',
				'attributeValueSetId',
				'availability',
				'availableUntil',
				'availability',
				'content',
				'operatingCostsPercent',
				'purchasePrice'
			],
			'variationRetailPrice' => [
				'price',
				'currency',
				'retailPriceNet',
				'basePrice',
				'basePriceNet',
				'unitPrice',
				'unitPriceNet',
				'orderParamsMarkup',
				'orderParamsMarkupNet'
			],
			'variationMarketStatus' => [
				'id',
				'sku',
				'initialSku',
				'parentSku',
				'marketStatus',
				'additionalInformation'
			],
			'variationImageList' => [
				'params' => [
					'all_images'                                       => [
						'type'                 => 'all', // all images
						'fileType'             => ['gif', 'jpeg', 'jpg', 'png'],
						'imageType'            => ['internal'],
						'referenceMarketplace' => 10,
					],
					'only_current_variation_images_and_generic_images' => [
						'type'                 => 'item_variation', // current variation + item images
						'fileType'             => ['gif', 'jpeg', 'jpg', 'png'],
						'imageType'            => ['internal'],
						'referenceMarketplace' => 10,
					],
					'only_current_variation_images'                    => [
						'type'                 => 'variation', // current variation images
						'fileType'             => ['gif', 'jpeg', 'jpg', 'png'],
						'imageType'            => ['internal'],
						'referenceMarketplace' => 10,
					],
					'only_generic_images'                              => [
						'type'                 => 'item', // only item images
						'fileType'             => ['gif', 'jpeg', 'jpg', 'png'],
						'imageType'            => ['internal'],
						'referenceMarketplace' => 10,
					],
				],
				'fields' => [
					'imageId',
					'type',
					'fileType',
					'path',
					'position',
					'attributeValueId',
				],
			]
		];
		
		//$itemFilter['itemBase.wasUpdatedBetween'] = [
		//		'timestampFrom' => strtotime("-1 days"),
		//		'timestampTo'   => time(),
		//	];
		$itemFilter = [
				'itemBase.wasUpdatedBetween' => [
					'timestampFrom' => strtotime("-1 days"),
					'timestampTo'   => time(),
				],
				'variationBase.isActive?' => [],
				'variationVisibility.isVisibleForMarketplace' => [
					'mandatoryOneMarketplace' => [],
					'mandatoryAllMarketplace' => [
						10
					]
				],
			];
			

		//$itemFilter = [
		//    'itemBase.isStoreSpecial' => [
		//	'shopAction' => [3]
		//    ]
		//];

		$itemParams = [
		    'language' => 'en'
		];

		$resultItems = $itemRepository
		    ->search($itemColumns, $itemFilter, $itemParams);
		//$resultItems = $vv->search($itemColumns, $itemFilter, $itemParams);
		
		//$totalitemsin_marketplace=$this->libCall->call('Bc::getAllProduct', ['packagist_query' => 'plentymarkets']);

		$items = array();
		$items_update = array();
		$items_create = array();
		$product = array();
		
		foreach ($resultItems as $item)
		{
			//if(in_array($item['id'],$totalitemsin_marketplace)){
			//	$items_update[] = $item;
			//} else {
			//	$items_create[] = $item;
			//}
			
			//$itemstockData = $itemstock->listStockByWarehouse($item->variationBase->id, ['variationId','warehouseId','valueOfGoods','purchasePrice','physicalStock','reservedStock','netStock']);
		    $items[] = $item;
			$product[] = array(
			  'name'=>$item->itemDescription->name1,
			  'main_image'=>'https://www.google.com/images/srpr/logo11w.png',
			  'sku'=>$item->variationBase->id,
			  'parent_sku'=>$item->variationBase->id,
			  'shipping'=>'10',
			  'tags'=>'red,shoe,cool',
			  'description'=>$item->itemDescription->shortDescription,
			  'price'=>$item->variationRetailPrice->price,
			  'inventory'=>$item,
			  'randomfield'=>'12321'
  			);
		}
		
		$templateData = array(
		    'resultCount' => $resultItems->count(),
		    'currentItems' => $items
		);
		
		$this->stockRepository->setFilters(['variationId' => $item->variationBase->id]);
		$stockNet = 0;
		$stockResult = $this->stockRepository->listStock(['*']);
		if($stockResult instanceof PaginatedResult)
        {
			$result = $stockResult->getResult();
			if($result instanceof Collection)
			{
				foreach($result as $model)
				{
					if($model instanceof Stock)
					{
						$stockNet += (int)$model->stockNet;
					}
				}
			}
		}
		//$stockResult = $this->stockRepository->listStock(['itemId','variationId','warehouseId','stockPhysical','reservedStock','stockNet','averagePurchasePrice','updatedAt'], 1, 1);
		
		$this->getLogger(__METHOD__)->error('Bc::stockResultSS', $stockResult);
		$this->getLogger(__METHOD__)->error('Bc::stockNet', $stockNet);
		$this->getLogger(__METHOD__)->error('Bc::proDD', $product);
		$this->getLogger(__METHOD__)->error('Bc::itemRepositoryL', $resultItems);
		return $twig->render('Bc::content.TopItems', $templateData);
    	}
}
