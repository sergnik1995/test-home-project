<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\TestQuestion;
use App\Entity\TestQuestionAnswer;
use App\Entity\TestResult;
use App\Entity\TestResultAnswer;
use App\Entity\TestTag;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route(path="/test")
     * @param Request $request
     * @return Response
     */
    public function test(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        die();
    }
}