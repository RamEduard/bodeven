<?php
/**
 * Description of base.php.
 *
 * @author Ramon Serrano <ramon.calle.88@gmail.com>
 */

$app->match('/addToCart', function() use($app) {

    $productId = (int) $app['request']->get('product_id');
    $count     = $app['request']->get('count');
    $color     = $app['request']->get('color');
    $size     = $app['request']->get('size');

    $product = new Bodeven\Cart\Product($productId, $app, $color, $size, $count);

    $app['cart']->addProduct($product);
    
	$app['session']->getFlashBag()->add(
		'info',
		array(
			'message' => '¡Producto agregado al pedido!',
		)
	);

    return $app->redirect($app['url_generator']->generate('catalog_item', array("id" => $productId)));

})
->method('POST')
->bind('addToCart');

$app->match('/pedido', function() use($app) {

    $products = $app['cart']->getProducts();

//    print "<pre>";
//    print_r($products);
//    print "</pre>";

    $total_mount = $app['cart']->getTotalMount();

    $initial_data = array(
        'ci'        => null,
        'nombres'   => '',
        'apellidos' => '',
        'correo'    => ''
    );

    $formOrder = $app['form.factory']->createBuilder('form', $initial_data);

    $formOrder = $formOrder->add('ci', 'number', array('required' => true));
    $formOrder = $formOrder->add('nombres', 'text', array('required' => true));
    $formOrder = $formOrder->add('apellidos', 'text', array('required' => true));
    $formOrder = $formOrder->add('correo', 'email', array('required' => true));

    $formOrder = $formOrder->getForm();

    if ('POST' == $app['request']->getMethod()) {

        $formOrder->handleRequest($app["request"]);

        if ($formOrder->isValid()) {
            $data = $formOrder->getData();

            $order = new Bodeven\Cart\Order($app['cart']);

            # Correo de administrador
            $subject = 'Uniformes Escolares Bodeven - Nuevo pedido';
            $message  = '<div style="margin:auto;position: relative;background: #FFF;border-top: 2px solid #00C0EF;margin-bottom: 20px;border-radius: 3px;width: 90%;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);padding: 20px 30px">';
            $message .= '<h3 style="padding-bottom: 9px;border-bottom: 1px solid #EEE;">Nuevo pedido</h3>';
            $message .= '<p>Ha recibido un pedido en Uniformes Escolares Bodeven.</p>';
            $message .= '<h4 style="padding-bottom: 9px;border-bottom: 1px solid #EEE;">Datos del pedido</h4>';
            $message .= $order->getTableProducts();
            $message .= '<h4 style="padding-bottom: 9px;border-bottom: 1px solid #EEE;">Datos del cliente</h4>';
            $message .= "<p><b>Cédula de Identidad:</b> $data[ci].</p>";
            $message .= "<p><b>Nombre(s) y Apellido(s):</b> $data[nombres] $data[apellidos].</p>";
            $message .= "<p><b>Correo electrónico:</b> $data[correo]</p>";
            $message .= '</div>';

            # Correo del cliente
            $subject2 = 'Uniformes Escolares Bodeven - Nuevo pedido';
            $message2  = '<div style="margin:auto;position: relative;background: #FFF;border-top: 2px solid #00C0EF;margin-bottom: 20px;border-radius: 3px;width: 90%;box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);padding: 20px 30px">';
            $message2 .= '<h3 style="padding-bottom: 9px;border-bottom: 1px solid #EEE;">Nuevo pedido</h3>';
            $message2 .= '<p>Ha hecho un pedido en Uniformes Escolares Bodeven.</p>';
            $message2 .= '<h4 style="padding-bottom: 9px;border-bottom: 1px solid #EEE;">Datos del pedido</h4>';
            $message2 .= $order->getTableProducts();
            $message2 .= '<h4 style="padding-bottom: 9px;border-bottom: 1px solid #EEE;">Datos enviados</h4>';
            $message2 .= "<p><b>Cédula de Identidad:</b> $data[ci].</p>";
            $message2 .= "<p><b>Nombre(s) y Apellido(s):</b> $data[nombres] $data[apellidos].</p>";
            $message2 .= "<p><b>Correo electrónico:</b> $data[correo]</p>";
            $message2 .= '</div>';

//            $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
//                ->setUsername("ramon.calle.88@gmail.com")
//                ->setPassword("ramoncito.1");
            $transport = Swift_SmtpTransport::newInstance('mx1.hostinger.es', 2525)
                ->setUsername("info@bodeven.com.ve")
                ->setPassword("bodeven1#");

            $mailer = Swift_Mailer::newInstance($transport);
            $mailMessage = Swift_Message::newInstance($subject)
                ->setFrom(array($data['correo'] => $data['nombres'] . " " . $data['apellidos']))
                ->setTo('uniformesbodeven@hotmail.com')
                ->setBody($message, 'text/html');
            $result = $mailer->send($mailMessage);

            $mailMessage2 = Swift_Message::newInstance($subject2)
                ->setFrom(array('info@bodeven.com.ve' => 'Uniformes Escolares Bodeven'))
                ->setTo($data['correo'])
                ->setBody($message2, 'text/html');
            $result2 = $mailer->send($mailMessage2);

            if ($result && $result2) {
                $app['cart'] = new \Bodeven\Cart\Cart();
                
                $app['session']->getFlashBag()->add(
					'success',
					array(
						'message' => '¡Su pedido fue enviado con éxito!',
					)
				);
				
                return $app->redirect($app['url_generator']->generate('cart'));
            } else {
                return new \Symfony\Component\HttpFoundation\Response('<h1>Fallo al enviar alguno de los mensajes.</h1>' . $message . $message2, 500);
            }

        }

    }

    return $app['twig']->render('frontend/cart/cart.html.twig', array(
        'products' => $products,
        'total_mount' => $total_mount,
        'form'   => $formOrder->createView()
    ));

})
->method('GET|POST')
->bind('cart');

$app->match('/product_plus', function() use($app){

    $productId = $app['request']->get('product_id');
    $color     = $app['request']->get('color');
    $size      = $app['request']->get('size');

    $product = new Bodeven\Cart\Product($productId, $app, $color, $size);

    $app['cart']->addProduct($product);

    return $app->redirect($app['url_generator']->generate('cart'));

})
->method('POST')
->bind('product_plus');

$app->match('/product_minus', function() use($app){

    $productId = $app['request']->get('product_id');
    $color     = $app['request']->get('color');
    $size      = $app['request']->get('size');

    $app['cart']->removeProduct($productId, $color, $size);

    return $app->redirect($app['url_generator']->generate('cart'));

})
->method('POST')
->bind('product_minus');

$app->match('/product_remove', function () use ($app) {

    $productId = $app['request']->get('product_id');
    $color     = $app['request']->get('color');
    $size      = $app['request']->get('size');

    $product = $app['cart']->getProduct($productId, $color, $size);

    if (is_object($product)) {
        for ($i = $product->count; $i >= 0; $i--) {
            $app['cart']->removeProduct($productId, $color, $size);
        }
    }
    
	$app['session']->getFlashBag()->add(
		'success',
		array(
			'message' => '¡Producto removido del pedido!',
		)
	);

    return $app->redirect($app['url_generator']->generate('cart'));

})
->bind('product_remove');
