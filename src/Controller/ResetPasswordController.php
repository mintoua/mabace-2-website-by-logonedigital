<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use App\Services\MailSender;
use DateTimeImmutable;
use Flasher\Prime\FlasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ResetPasswordController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager, private MailSender $sender)
    {
        $this->manager = $manager;

    }

    #[Route('/mot-de-passe-oublie', name: 'app_forgot_password')]
    public function forgotPassword(
        Request $req, 
        TokenGeneratorInterface $tokenGenarator,
        FlasherInterface $flasher
        ): Response
    {   
        if($this->getUser()){
            return $this->redirectToRoute('app_home');
        }
        
        if($req->get('email')){
            
            $user = $this->manager->getRepository(User::class)->findOneByEmail($req->get('email'));
           
            if($user){
                
                //1 : enregistrer en base la demande de reset password avec user, tokem et createdAt

                $resetPassword = new ResetPassword();
                $resetPassword->setUser($user);
                $token = $tokenGenarator->generateToken();
                $resetPassword->setToken($token);
                $resetPassword->setCreatedAt(new \DateTime());

                $this->manager->persist($resetPassword);
                $this->manager->flush();

                // 2 :Envoyer un email à l'utilisateur avec le lien lui permettant de mettre à jour son mot de passe.
                

                $url = $this->generateUrl('app_reset_password', [
                    'token'=>$token
                ]);

                $url = $this->generateUrl("app_reset_password", [
                "token"=>$token
                ], UrlGeneratorInterface::ABSOLUTE_URL);
                
                 $content = "Bonjour ".$user->getFirstname()."<br> Vous avez demander à reinitialiser votre mot de passe sur le site scoops feraga <br> <br>";
                 $content .="Merci de bien vouloir cliquez sur le lien suivant pour <a href='".$url."'>mettre à jour votre mot de passe</a>.";
                // $this->sender->send($user->getEmail(), $user->getFirstname().''.$user->getLastname(), $content,  "reinitialiser votre mot de passe");
                
                // $this->mailHelper->send(
                //     "Reinitialisation du mot de passe", 
                //      $user->getEmail(), 
                //      "email/reset_password.html.twig", 
                //      ["token" => $token ],
                //      "no-reply@scoopsferaga.com"
                //     );
                
                $this->sender->send(
                $user->getEmail(), 
                $user->getFirstname().' '.$user->getLastname(),
                $content,
                "réinitialisation de mot de passe"
            );
                $flasher->addInfo('Un email de reinitialisation vous a été envoyé.');
                return $this->redirectToRoute('app_login');
            }else{
                $flasher->addWarning('Cette email n\'existe pas.');
                return $this->redirectToRoute('app_forgot_password');
            }
        }
        return $this->render('reset_password/forgot_password.html.twig');
    }

    #[Route('/mot-de-passe-oublie/modifier-mot-de-passe/{token}', name:'app_reset_password')]
    public function resetPassword(
        ResetPassword $resetPassword, 
        Request $req,
        UserPasswordHasherInterface $userPasswordHasher,
        FlasherInterface $flasher
        ){
        if(!$resetPassword){
           // $this->addFlash('notice');
            return $this->redirectToRoute('app_forgot_password');
        }

        $now  = new \DateTime();
        if($now > $resetPassword->getCreatedAt()->modify("+ 3 hour")){
            $flasher->addWarning('votre demande de réinitialisation de mot de passe a expirée veuillez la renouvellez.');
            return $this->redirectToRoute('app_forgot_password');
        }

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($req);

        if($form->isSubmitted() and $form->isValid()){
            $newPassword = $form->get('new_password')->getData();

            $userPasswordHasher->hashPassword($resetPassword->getUser(),$newPassword);
            $resetPassword->getUser()->setPassword($userPasswordHasher->hashPassword($resetPassword->getUser(),$newPassword));
            $resetPassword->getUser()->setUpdatedAt(new \DateTimeImmutable('now'));
            $this->manager->flush();
            $flasher->addSuccess('Votre mot de passe a bien été modifié. </br> vous pouvez maintenant vous connectez.');

            return $this->redirectToRoute('app_login');
        }
        return $this->render('reset_password/reset_password.html.twig', ['form'=>$form->createView()]);

    }
}
