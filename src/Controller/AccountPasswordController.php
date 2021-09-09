<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->entityManager = $entityManager;
        }
    /**
     * @Route("/compte/modifier-mon-mot-de-passe", name="account_password")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // Je récupere le mot de passe du champ (Mon mot de passe actuel) non crypter
            // get('old_password') correspond au nom du champs donner dans Form/ChangePasswordType
            $old_pwd = $form->get('old_password')->getData();
            
            // Je compare les mots de passes en base crypter et le mot de passe non crypter
            if($encoder->isPasswordValid($user, $old_pwd)){
                // get('new_password') correspond au nom du champs donner dans Form/ChangePasswordType
                $new_pwd = $form->get('new_password')->getData();
                
                $password = $encoder->hashPassword($user, $new_pwd);

                $user->setPassword($password);

                $this->entityManager->flush();
                $this->addFlash('PasswordChange', 'Votre mot de passe à bien été mis à jour');
            }else {
                $this->addFlash('PasswordError', "Votre mot de passe actuel n'est pas le bon");
            }
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
