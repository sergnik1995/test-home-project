<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\TestQuestion;
use App\Entity\TestQuestionAnswer;
use App\Entity\TestResult;
use App\Entity\TestResultAnswer;
use App\Entity\TestTag;
use App\Entity\User;
use App\Form\CreateTestForm;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestController extends AbstractController
{
    private $createTestForm;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->createTestForm = new CreateTestForm($entityManager, $validator);
    }

    /**
     * @Route(path="/test")
     * @param Request $request
     * @return Response
     */
    public function test(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /*$test = new Test();
        $test->setCreatedAt(time());
        $test->setName("Тест");
        $test->setCreatedBy(null);
        $test->setTime(0);
        $test->setAttempts(0);
        $test->setQuestions(new ArrayCollection());
        $test->setResults(new ArrayCollection());
        $test->setTags(new ArrayCollection());
        $em->persist($test);
        $em->flush();*/
        $test = $em->getRepository(Test::class)->find(2);
        dump($test->getCreatedBy());
        die();
    }

    /**
     * @Route(path="/create-test", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function testConstructor(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('create-test/create-test.html.twig');
    }

    /**
     * @Route(path="/create-test", methods={"POST"})
     * @param Request $request
     * @throws \Exception
     */
    public function createTest(Request $request)
    {
        $token = $request->request->get('token');

        if($this->isCsrfTokenValid('create-test', $token)) {
            $testId = $this->createTestForm->createTest($request->request);
            return new RedirectResponse('/test/'.$testId);
        } else {
            return new Response('Неверный csrf токен', 400);
        }
    }

    /**
     * @Route(path="/top")
     * @return Response
     */
    public function showTestsTop()
    {
        return $this->render('top/top.html.twig');
    }

}