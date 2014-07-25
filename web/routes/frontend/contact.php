<?php
/**
 * Description of contact.php.
 * 
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 */

$app->match('/contact', function() use($app) {

    return $app['twig']->render('frontend/contact.html.twig', array());

})
->method('GET')
->bind('contact');

$app->match('/mail', function() use($app) {

    #$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
    $transport = Swift_SmtpTransport::newInstance('mx1.hostinger.es', 2525)
        ->setUsername("info@bodeven.com.ve")
        ->setPassword("bodeven1#");

    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance('Prueba de envio de mensaje')
        ->setFrom('ramon.calle.88@gmail.com')
        ->setTo('ramon.calle.88@gmail.com')
        ->setBody('<h1>Test Message Body</h1>', 'text/html');
    $result = $mailer->send($message);

    print_r($result);die;
})
->method('GET')
->bind('mail');