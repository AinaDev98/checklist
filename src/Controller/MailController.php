<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\MailType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/mail', name: 'app_mail')]
    public function index(Request $request): Response
    {
        $addMail = new Mail();
        $formMail = $this->createForm(MailType::class, $addMail);

        $formMail->handleRequest($request);
        if ($formMail->isSubmitted() && $formMail->isValid())
        {
            $this->entityManager->persist($addMail);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_mail');
        }
        return $this->render('interface_admin/mail.html.twig', [
            'formMail' => $formMail->createView()
        ]);
    }

    #[Route('/admin/mail/list', name: 'app_list_mail')]
    public function read()
    {
        $readMail = $this->entityManager->getRepository(Mail::class)->findAll();

        return $this->render('interface_admin/list_mail.html.twig', [
            'readMail' => $readMail
        ]);
    }

    #[Route('/admin/mail/list{id}', name: 'app_delete_mail')]
    public function delete($id)
    {
        $deleteMail = $this->entityManager->getRepository(Mail::class)->findOneById($id);

        if ($deleteMail)
        {
            $this->entityManager->remove($deleteMail);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_mail');
        }
    }
}
