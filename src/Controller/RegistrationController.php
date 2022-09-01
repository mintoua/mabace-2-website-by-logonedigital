<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager
        )
    {
        
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->add("password", RepeatedType::class, [
                
                'type'=>PasswordType::class,
                'invalid_message'=> 'le mot de passe et la confirmation doivent être identique.',
                'first_options'=>[
                    'constraints'=>[
                        new Regex(
                    [
                        "pattern"=>"/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/",
                        "match"=>true,
                        "message"=>"mot de passe invalid"
                    ]
                    ),
                    new NotBlank([
                        'message' => 'Entrez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    ],
                    'help'=> 'Le mot de passe doit contenir au moins 8 caractères, dont au moins: une Majuscule, un chiffre, un caractère spéciale.',
                    ],
                'second_options'=>[
                    
                ]
                ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );
            $user->setRoles(["ROLE_USER"]);
            $user->setCreatedAt(new \DateTimeImmutable('now'));
            $user->setIsVerifyEd(true);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path:'/devenir-membre', name:'app_new_member')]
    public function member(Request $request): Response{

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    md5(uniqid())
                )
            );
            $user->setRoles(["ROLE_MEMBER"]);
            $user->setCreatedAt(new \DateTimeImmutable('now'));
            $user->setIsVerifyEd(true);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/member.html.twig', [
             'form' => $form->createView(),
        ]);
    }
}
