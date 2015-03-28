<?php
/**
 * Description of contact.php.
 * 
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 */

$app->match('/contact', function() use($app) {

    if ('POST' == $app['request']->getMethod()) {
        $nombre = $app['request']->get('nombre');
        $asunto = $app['request']->get('asunto');
        $correo = $app['request']->get('correo');
        $mensaje = $app['request']->get('mensaje');

        $message  = '<div style="margin:auto;position: relative;background: #FFF;border-top: 2px solid #00C0EF;margin-bottom: 20px;border-radius: 3px;width: 90%;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);padding: 20px 30px">';
        $message .= "<p>Ha recibido un mensaje de $nombre < $correo > por medio de Uniformes Escolares Bodeven.</p>";
        $message .= "<p>El mensaje es el siguiente:";
        $message .= "<div style=\"background-color: #F0F7FD;margin: 0px 0px 20px;padding: 15px 30px 15px 15px;border-left: 5px solid #D0E3F0;\">$mensaje</div>";
        $message .= '</div>';

//        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
//            ->setUsername("ramon.calle.88@gmail.com")
//            ->setPassword("ramoncito.1");
        $transport = Swift_SmtpTransport::newInstance('mx1.hostinger.es', 2525)
            ->setUsername("info@bodeven.com.ve")
            ->setPassword("bodeven1#");

        $mailer = Swift_Mailer::newInstance($transport);
        $mailMessage = Swift_Message::newInstance($asunto)
            ->setFrom(array($correo => $nombre))
            ->setTo('tania_1019@hotmail.com')
            ->setBody($message, 'text/html');
        $result = $mailer->send($mailMessage);
        if ($result) {
            return $app->redirect($app['url_generator']->generate('contact'));
        } else {
            return new \Symfony\Component\HttpFoundation\Response('<h1>Fallo al enviar mensaje.</h1>' . $message, 500);
        }
    }

    return $app['twig']->render('frontend/contact.html.twig', array());

})
->method('GET|POST')
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