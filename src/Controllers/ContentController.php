<?php
namespace Bc\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Log\Loggable;
use Plenty\Modules\Item\DataLayer\Contracts\ItemDataLayerRepositoryContract;

use Plenty\Modules\Plugin\Libs\Contracts\LibraryCallContract;

/**
 * Class ContentController
 * @package HelloWorld\Controllers
 */
class ContentController extends Controller
{
	use Loggable;
	
	public $libCall;
	
	public function __construct(LibraryCallContract $libCall){
		$this->libCall = $libCall;
	}
	
	/**
	 * @param Twig $twig
	 * @return string
	 */
	public function sayHelloT(Twig $twig):string
	{
		return $twig->render('Bc::content.hello');
	}
	
	public function sayHello(Twig $twig, ItemDataLayerRepositoryContract $itemRepository):string
    	{
		$sofortRequestParams['id'] = '123';
		$paymentResult = $this->libCall->call('Bc::getConnection', ['packagist_query' => 'plentymarkets']);
		$this->getLogger(__METHOD__)->error('Bc::LIBCALLLLLLKKK', $paymentResult);
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
				'producerId'				
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
			],
			'variationRetailPrice' => [
				'price',
				'currency'
			],
			'variationImageList' => [
				'imageId',
				'type',
				'fileType',
				'path',
				'position',
				'attributeValueId',
				'cleanImageName'
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
		    $items[] = $item;
			$product[] = array(
			  'name'=>$item->itemDescription->name1,
			  'main_image'=>'https://www.google.com/images/srpr/logo11w.png',
			  'sku'=>'prod 7',
			  'parent_sku'=>'prod 7',
			  'shipping'=>'10',
			  'tags'=>'red,shoe,cool',
			  'description'=>$item->itemDescription->shortDescription,
			  'price'=>$item->variationRetailPrice->price,
			  'inventory'=>'10',
			  'randomfield'=>'12321'
  			);
		}
		
		$templateData = array(
		    'resultCount' => $resultItems->count(),
		    'currentItems' => $items
		);
		$this->getLogger(__METHOD__)->error('Bc::proDD', $product);
		$this->getLogger(__METHOD__)->error('Bc::itemRepositoryTTT', $resultItems);
		return $twig->render('Bc::content.TopItems', $templateData);
    	}
}
