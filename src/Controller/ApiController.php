<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\TestTag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;

class ApiController extends AbstractController
{
    /** @var EntityManager */
    private $em;

    /**
     * ApiController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route(path="/api/findTag", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function findTag(Request $request)
    {
        $tag = mb_strtolower(trim($request->get('tag', "")));

        if($tag !== "") {
            $suitableTags = $this->em->getRepository(TestTag::class)->createQueryBuilder('tt')
                ->select('tt.id, tt.name')
                ->where('tt.name LIKE :tag')
                ->setParameter("tag", "%" . $tag . "%")
                ->getQuery()->getResult();

            $data = [
                'status' => 'ok',
                'data' => $suitableTags
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'wrong input'
            ];
        }

        return new JsonResponse($data, 200);
    }

    /**
     * @Route("/api/getTestsTop")
     * @param Request $request
     * @return JsonResponse
     */
    public function getTestsTop(Request $request)
    {
        $tests = $this->em->getRepository(Test::class)->createQueryBuilder('t')
            ->select('t')
            ->orderBy('t.attempts', 'desc')
            ->setMaxResults(10)
            ->getQuery()->getResult();

        $testsData = [];
        foreach ($tests as $test) {
            $testData = [];
            $testData['id'] = $test->getId();
            $testData['name'] = $test->getName();
            $testData['description'] = $test->getDescription();

            foreach ($test->getTags() as $tag) {
                $tagData['name'] = $tag->getName();
                $testData['tags'][] = $tagData;
            }

            $testsData[] = $testData;
        }

        $data = [
            'status' => 'ok',
            'data' => $testsData
        ];

        return new JsonResponse($data, 200);
    }
}