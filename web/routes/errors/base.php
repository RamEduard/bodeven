<?php
/**
 * Description of base.php.
 * 
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 */

use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Process\Exception\LogicException,
    Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException,
    Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException,
    Doctrine\DBAL\DBALException;

$app->error( function(LogicException $logicException, $code) {
    return new Response($logicException->getMessage());
});

$app->error(function(MethodNotAllowedHttpException $methodNotAllowedHttpException, $code) {
    return new Response($methodNotAllowedHttpException->getMessage());
});

$app->error(function(AccessDeniedHttpException $accessDeniedHttpException) {
    return new Response($accessDeniedHttpException->getMessage());
});

//$app->error(function (DBALException $DBALException) {
//    return new Response($DBALException->getMessage());
//});