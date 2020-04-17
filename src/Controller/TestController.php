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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestController extends AbstractController
{

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
     * @param ValidatorInterface $validator
     * @throws \Exception
     * @return Response
     */
    public function createTest(Request $request, ValidatorInterface $validator)
    {
        $em = $this->container->get('doctrine')->getManager();

        $token = $request->request->get('token');

        if($this->isCsrfTokenValid('create-test', $token)) {
            $testId = (new CreateTestForm($em, $validator))->createTest($request->request);
            return new RedirectResponse('/test/'.$testId);
        } else {
            return new Response('Что-то пошло не так, попробуйте обновить страницу', 419);
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

    /**
     * @Route(path="/test/{testId}", requirements={"testId"="\d+"})
     * @param int $testId
     * @param Request $request
     * @return Response
     */
    public function passTest(int $testId, Request $request)
    {
        $test = $this->getDoctrine()->getManager()->getRepository(Test::class)->find($testId);

        if(!isset($test)) {
            return new Response('Неверный айди теста', 404);
        }

        return $this->render('pass-test/pass-test.html.twig', [
            'test' => $test
        ]);
    }

    /**
     * @Route(path="/test/{testId}/question", requirements={"testId"="\d+"})
     * @param int $testId
     * @param Request $request
     * @return Response
     */
    public function getTestQuestion(int $testId, Request $request)
    {
        $em = $this->get('doctrine')->getManager();
        $test = $em->getRepository(Test::class)->find($testId);

        if(!isset($test)) {
            return new Response('Неверный айди теста', 404);
        }

        $session = $this->container->get('session');
        $tests = $session->get('tests', []);

        if(!isset($tests[$testId])) {
            $tests[$testId] = ($testResult = new TestResult());
            $testResult->setTest($test);
            $testResult->setCreatedAt(time());
            $testResult->setCreatedBy($this->getUser());
            $testResult->setCurrentQuestion(0);

            $em->persist($testResult);
            $em->flush();

            $session->set('tests', $tests);
        } else {
            $testResult = $tests[$testId];
        }

        //TODO: добавить редирект на страницу результата если testResult = null

        return $this->render('pass-test/pass-test-question.html.twig', [
            'test_id' => $testId,
            'question' => ($test->getQuestions())[$testResult->getCurrentQuestion()]
        ]);
    }

    /**
     * @Route(path="/test/{testId}/question/answer", methods={"POST"}, requirements={"testId"="\d+"})
     * @param int $testId
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function passTestQuestion(int $testId, Request $request)
    {
        $token = $request->get('token');

        if(!$this->isCsrfTokenValid('answer-question', $token)) {
            return new Response('Что-то пошло не так, попробуйте обновить страницу', 419);
        }

        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository(Test::class)->find($testId);

        if(!isset($test)) {
            return new Response('Такого теста не существует', 404);
        }

        $session = $this->container->get('session');
        $tests = $session->get('tests');

        if(!isset($tests[$testId])) {
            return new RedirectResponse('/test/'.$testId);
        }

        $testResult = $em->merge($tests[$testId]);
        $question = $test->getQuestions()->get($testResult->getCurrentQuestion());
        $questionAnswer = new TestResultAnswer();
        $questionAnswer->setResult($testResult);
        $questionAnswer->setQuestion($question);

        if($question->getQuestionType() === 'few-from-list') {
            $answers = $request->request->get('answers', []);
            $questionAnswer->setAnswer(implode(',', $answers));
        } else {
            $answer = $request->request->get('answer', '');

            if($answer === '') {
                return new Response('Не выбран ответ', 400);
            }
            $questionAnswer->setAnswer($answer);
        }

        if($testResult->getCurrentQuestion() === $test->getQuestions()->count() - 1) {
            $testResult->setCurrentQuestion(null);
        } else {
            $testResult->setCurrentQuestion($testResult->getCurrentQuestion() + 1);
        }
        $em->persist($questionAnswer);
        $em->flush();
        $em->detach($testResult);
        $tests[$testId] = $testResult;
        $session->set('tests', $tests);

        return new RedirectResponse('/test/'.$testId.'/question');
    }

}