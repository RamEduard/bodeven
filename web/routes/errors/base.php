<?php
/**
 * Description of base.php.
 * 
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 */

use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Process\Exception\LogicException,
    Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

$app->error( function(LogicException $logicException, $code) {
    return new Response($logicException->getMessage());
});

$app->error(function(MethodNotAllowedHttpException $methodNotAllowedHttpException, $code) {
    return new Response($methodNotAllowedHttpException->getMessage());
});