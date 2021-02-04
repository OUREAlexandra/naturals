<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\MailerService;
use App\Form\RegistrationFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getEmail() != 'admin@admin.com') {
                $user->setRoles(['ROLE_BUYER']);
            }
            
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from($form->get('email')->getData())
                ->to('alexandra.oure@hotmail.com')
                ->subject('Ever Naturals')
                ->htmlTemplate('emails/register.html.twig')
                ->context([
                    'mail' => $form->get('email')->getData(),
                    'firstname' => $form->get('firstname')->getData(),
                    'lastname' => $form->get('lastname')->getData()

                ]);
            $mailer->send($email);
            $this->addFlash('message', 'Mail de contact envoyé !');
            return $this->redirectToRoute('success');
        }

            return $this->redirectToRoute('success');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
