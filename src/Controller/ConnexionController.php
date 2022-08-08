<?php

namespace App\Controller;

use App\Entity\Connexion;
use App\Form\ConnexionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/connexion', name:'app_connexion')]
    public function index(Request $request): Response
    {
        $addConnexion = new Connexion();
        $formConnexion = $this->createForm(ConnexionType::class, $addConnexion);

        $formConnexion->handleRequest($request);
        if ($formConnexion->isSubmitted() && $formConnexion->isValid())
        {
            $this->entityManager->persist($addConnexion);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_connexion');
        }
        return $this->render('interface_admin/connexion.html.twig', [
            'formConnexion' => $formConnexion->createView()
        ]);
    }

    #[Route('/admin/connexion/list', name: 'app_list_connexion')]
    public function read()
    {
        $readConnexion = $this->entityManager->getRepository(Connexion::class)->findAll();

        return $this->render('interface_admin/list_connexion.html.twig', [
            'readConnexion' => $readConnexion
        ]);
    }

    #[Route('/admin/connexion/list/{id}', name: 'app_delete_connexion')]
    public function delete($id)
    {
        $deleteConnexion = $this->entityManager->getRepository(Connexion::class)->findOneById($id);

        if ($deleteConnexion)
        {
            $this->entityManager->remove($deleteConnexion);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_list_connexion');
        }
    }
}
