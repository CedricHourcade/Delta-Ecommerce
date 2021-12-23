<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Classe\Mailjet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $cart, $stripeSessionId): Response
    {

        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if($order->getState() == 0) {
            // Vider la session "cart"
            $cart->remove();
            
            // Modifier le statut state de notre commande en mettant 1
            $order->setState(1); // Commande payée
            $this->entityManager->flush();

            // Envoyer un email à notre client pour lui confirmer sa commande
                $mail = new Mailjet();
                $content = "Bonjour ".$order->getUser()->getFirstname()."<br/>Merci pour votre commande.<br><br/>";
                $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande sur la boutique Delta Ecommerce est bien validée.', $content);
        }

        

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
