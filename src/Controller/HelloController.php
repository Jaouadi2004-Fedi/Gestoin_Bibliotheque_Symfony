<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HelloController extends AbstractController
{
    private array $messages = [
"nermine", "fedi", "nour"
];
#[Route('/', name: 'app_index')]
public function index(): Response
{
    return $this->redirectToRoute('app_login');
}
#[Route('/messages/{id}', name: 'app_show_one')]
public function showOne($id): Response
{
return new Response($this->messages[$id]);
}
  }
