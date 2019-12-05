<?php
/**
 * PHP version 7.3
 * web/index.php
 *
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Controller/ResultsController.php';

use MiW\Results\Utils;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

Utils::loadEnv(__DIR__ . '/../');

$locator = new FileLocator([__DIR__ . '/../' . $_ENV['CONFIG_DIR']]);
$loader = new YamlFileLoader($locator);
/** @var RouteCollection $routes */
$routes = $loader->load($_ENV['ROUTES_FILE']);
$context = new RequestContext(filter_input(INPUT_SERVER, 'REQUEST_URI'));
$matcher = new UrlMatcher($routes, $context);
$path_info = filter_input(INPUT_SERVER, 'PATH_INFO') ?? '/';

try {
    $parameters = $matcher->match($path_info);
    $action = $parameters['_controller'];
    $param1 = $parameters['id'] ?? null;
    $action($param1);
} catch (ResourceNotFoundException $e) {
    echo 'Caught exception: The resource could not be found' . PHP_EOL;
} catch (MethodNotAllowedException $e) {
    echo 'Caught exception: the resource was found but the request method is not allowed' . PHP_EOL;
}
