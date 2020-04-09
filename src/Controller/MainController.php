<?php

namespace App\Controller;

use App\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route(path="/")
     * @var EntityManagerInterface $em
     */
    public function main(EntityManagerInterface $em)
    {
        return $this->render('index.html.twig');
    }
}