<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/zoo/arcadia', name: 'app__api_zoo_arcadia')]
class ZooArcadiaController extends AbstractController
{
    #[Route('/{id}', name: 'edit', methods:'PUT')]
    public function edit(int $id): Response
    
    {

    }
    

    
    #[Route('/{id}', name: 'delete', methods:'DELETE')]
    public function delete(int $id): Response
    
    {

    }
    
}
