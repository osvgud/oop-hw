<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$loader = new Twig_Loader_Filesystem('View', __DIR__ . '/src/Weather');
$twig = new Twig_Environment($loader, ['cache' => __DIR__ . '/cache', 'debug' => true]);
$controller = new \Weather\Controller\StartPage();
switch ($request->getRequestUri()) {
    case '/oop/wapi_week':
        $renderInfo = $controller->getWeekWeather(3);
        break;
    case '/oop/gapi_week':
        $renderInfo = $controller->getWeekWeather(2);
        break;
    case '/oop/week':
        $renderInfo = $controller->getWeekWeather(1);
        break;
    case '/oop/wapi_day':
        $renderInfo = $controller->getTodayWeather(3);
        break;
    case '/oop/gapi_day':
        $renderInfo = $controller->getTodayWeather(2);
        break;
    case '/oop/day':
        $renderInfo = $controller->getTodayWeather(1);
        break;
    default:
        $renderInfo = $controller->getTodayWeather(1);
    break;
}
$renderInfo['context']['resources_dir'] = 'src/Weather/Resources';

$content = $twig->render($renderInfo['template'], $renderInfo['context']);

$response = new Response(
    $content,
    Response::HTTP_OK,
    array('content-type' => 'text/html')
);
//$response->prepare($request);
$response->send();
