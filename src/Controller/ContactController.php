<?php

namespace App\Controller;

use App\Entity\User;
use App\Classe\Mailjet;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = new User();

            $content = "Bonjour ".$form->get('prenom')->getData()."<br/>Vous avez fait une demande de prise de contact.<br/><br/>";
            $content .= "Notre équipe va vous répondre dans les meilleurs délais";

            $mail = new Mailjet();
            $mail->send($form->get('email')->getData(), $form->get('prenom')->getData().' '.$form->get('nom')->getData(), 'Demande de contact', $content );


            $this->addFlash('success', 'Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais.');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
