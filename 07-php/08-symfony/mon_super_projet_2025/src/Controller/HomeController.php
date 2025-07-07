<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Ma super application !',
            "fruits"=>["banane", "tomate", "cerise"],
            "pays"=>["france"=>"bonjour le monde !", "angleterre"=>"Hello World !"],
            "chiffre"=>rand(0,10),
            "tableau_vide"=>[],
            "xss"=>"<script>alert('coucou');</script>"
        ]);
    }
    #[Route("/bonjour/anglais/{username}", 
        name:'app_hello', 
        defaults:["username"=>"John"], 
        requirements:["username"=>"^[a-zA-Z]+$"])]
    public function hello($username): RedirectResponse
    {
        // dd("Hello $username");
        return $this->redirectToRoute("app_bonjour", ["nom"=>"smith", "prenom"=>$username]);
    }
    #[Route("/bonjour/{nom<^[a-zA-Z]+$>}/{prenom<^[a-zA-Z]+$>?Jean}", name:"app_bonjour")]
    public function bonjour($nom, $prenom, Request $request): Response
    {
        // dump($request);
        // die;
        // dd($request);
        return $this->render("home/bonjour.html.twig", [
            "title"=>"Bonjour le monde !",
            "nom"=>$nom,
            "prenom"=>$prenom
        ]);
    }

    

}
