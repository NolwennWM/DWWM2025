<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageForm;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/message")]
final class MessageController extends AbstractController
{
    #[Route('/add', name: 'app_message_create')]
    public function createMessage(EntityManagerInterface $em, Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageForm::class, $message);
        // Le formulaire récupère toute les données envoyées
        $form->handleRequest($request);

        // Est ce que le formulaire a été soumit et est-il valide?
        if($form->isSubmitted() && $form->isValid())
        {
            // dd($message);
            $em->persist($message);
            $em->flush();

            $this->addFlash("success", "Un nouveau message a été ajouté");
            return $this->redirectToRoute("app_message_read");
        }


        // $message->setContent("Ceci est un message de test")
        //         ->setCreatedAt(new \DateTimeImmutable());
        // $em->persist($message);
        // $em->flush();
        return $this->render('message/create.html.twig', [
            'messageForm' => $form,
        ]);
    }

    #[Route("/{page<^\d+$>?1}/{nb<^\d+$>?5}", name: "app_message_read")]
    public function readMessage(MessageRepository $repo, $page, $nb): Response
    {
        // $messages = $repo->findAll();
        // Paramètre 1: WHERE, Paramètre 2: ORDER BY
        // $messages = $repo->findBy([], ["createdAt"=>"DESC"]);
        // paramètre 3 : LIMIT, Paramètre 4: OFFSET
        $messages = $repo->findBy([], ["createdAt"=>"DESC"], $nb, ($page-1)*$nb);
        // $messages = $repo->findByDateInterval("2022-01-01", "2025-07-10");
        // nombre total de message
        $total = $repo->count();
        // $total = count($messages);

        // nombre de page :
        $nbPage = ceil($total / $nb);

        return $this->render('message/index.html.twig', [
            'listMessage' => $messages,
            "nbPage"=>$nbPage,
            "nombre"=>$nb,
            "currentPage"=>$page
        ]);
    }

    #[Route("/delete/{id<^\d+$>}", name: "app_message_delete")]
    public function deleteMessage(MessageRepository $repo, $id, EntityManagerInterface $em): Response
    {
        $message = $repo->find($id);
        if(!$message)
        {
            $this->addFlash("danger", "Aucun Message Correspondant");
        }
        else
        {
            $em->remove($message);
            $em->flush();
            $this->addFlash("success", "Votre message a été supprimé");
        }

        return $this->redirectToRoute("app_message_read");
    }

    #[Route("/update/{id<^\d+$>}", name:"app_message_update")]
    public function updateMessage(?Message $message, EntityManagerInterface $em, Request $request):Response
    {
        if($message)
        {
            $form = $this->createForm(MessageForm::class, $message);
            // Le formulaire récupère toute les données envoyées
            $form->handleRequest($request);

            // Est ce que le formulaire a été soumit et est-il valide?
            if($form->isSubmitted() && $form->isValid())
            {
                // dd($message);
                $em->flush();

                $this->addFlash("success", "Un nouveau message a été ajouté");
                return $this->redirectToRoute("app_message_read");
            }
        }
        else
        {
            $this->addFlash("danger", "Aucun message correspondant");
            return $this->redirectToRoute("app_message_read");
        }
        return $this->render('message/create.html.twig', [
            'messageForm' => $form,
        ]);
    }
}
