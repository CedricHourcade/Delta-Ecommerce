<?php

namespace App\Controller;

use App\Classe\Cart;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session", name="stripe_create_session")
     */
    public function index(Cart $cart)
    {

        $products_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        foreach ($cart->getFull() as $product) {
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice(),
                    'product_data' => [
                        'name' => $product['product']->getName(),
                        'images' => [$YOUR_DOMAIN."/uploads/".$product['product']->getIllustration()],
                    ],
                ],
                'quantity' => $product['quantity'],
            ];
        }

        Stripe::setApiKey('sk_test_51JileLLR0Gqh5u0VJLiX00D1Lc3o1Hmzwm5OWU4zpy256jNAyJ3goLRU7NIGakDkdqtfyK5gK6xTXLrN4gb74n6W00SVbIPmIc');

            $checkout_session = Session::create([
            'line_items' => [[
                # TODO: replace this with the `price` of the product you want to sell
                $products_for_stripe
            ]],
            'payment_method_types' => [
                'card',
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            ]);

            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkout_session->url);
            dd($checkout_session->url);
    }
}
