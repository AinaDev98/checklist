<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/register', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $addUser = new User();
        $formUser = $this->createForm(RegisterType::class, $addUser);
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid())
        {
            $addUser = $formUser->getData();
            $password = $passwordHasher->hashPassword($addUser, $addUser->getPassword());
            $addUser->setPassword($password);

            $this->entityManager->persist($addUser);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_user');
        }
        return $this->render('register/index.html.twig', [
            'formUser' => $formUser->createView()
        ]);
    }

    #[Route('/admin/register/list', name: 'app_list_user')]
    public function read()
    {
        $readUser = $this->entityManager->getRepository(User::class)->findAll();
        return $this->render('interface_admin/list_users.html.twig', [
            'readUser' => $readUser
        ]);
    }

    #[Route('/admin/register/delete/{id}', name: 'app_delete_user')]
    public function delete($id)
    {
        $deleteUser = $this->entityManager->getRepository(User::class)->findOneById($id);
        if ($deleteUser){
            $this->entityManager->remove($deleteUser);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_register');
        }
    }
}
