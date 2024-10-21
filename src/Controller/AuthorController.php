<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/listauthor', name: 'app1_author')]
    public function list(AuthorRepository $authorRepository ): Response
    {   
        $authors=$authorRepository->findAll();
        return $this->render('author/list.html.twig', [
            'controller_name' => 'AuthorController',
            'authors' => $authors,
        ]);
    }
    #[Route('/addauthor', name: 'app2_author')]
    public function add(ManagerRegistry $manager): Response
    {   
        $author=new Author();
        $em=$manager->getManager();
        $author->setEmail("bechir.zarrouki@gmail.com");
        $author->setUsername("bechir zarrouki");
        $em->persist($author);
        $em->flush();
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/addformauthor', name: 'app3_author')]
    public function addform(ManagerRegistry $manager,Request $req): Response
    {   
        $author=new Author();
        $em=$manager->getManager();
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($req);
        $em->persist($author);
        $em->flush();
        return $this->renderForm('author/add.html.twig', [
            'controller_name' => 'AuthorController',
            'form'=>$form->createView(),
        ]);
    }
    #[Route('/updateformauthor/{id}', name: 'app4_author')]
    public function updateform(ManagerRegistry $manager,Request $req,$id): Response
    {   
        $em=$manager->getManager();
        $author=$em->getRepository(Author::class)->find($id);
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($req);
        $em->persist($author);
        $em->flush();
        return $this->renderForm('author/add.html.twig', [
            'controller_name' => 'AuthorController',
            'form'=>$form,
        ]);
    }
}
