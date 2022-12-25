<?php
use Pleskachov\PhpPro\Core\WEB\Controllers\TestController;
use Pleskachov\PhpPro\Core\WEB\Controllers\PagesController;

echo 'Hello world';


//$controller = new TestController();
//$controller->TestCalcController();


$pagesController = new PagesController();
$pagesController->showAnyThings();
