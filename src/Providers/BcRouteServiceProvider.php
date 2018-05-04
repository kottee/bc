<?php
namespace Bc\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class HelloWorldRouteServiceProvider
 * @package HelloWorld\Providers
 */
class BcRouteServiceProvider extends RouteServiceProvider
{
	/**
	 * @param Router $router
	 */
	public function map(Router $router)
	{
		$router->get('wishhello', 'Bc\Controllers\ContentController@sayHelloUpdateItems');
		$router->get('hellotest', 'Bc\Controllers\ContentController@sayHelloGetOrders');
		$router->get('hello', 'Bc\Controllers\ContentController@sayHello');
	}

}
