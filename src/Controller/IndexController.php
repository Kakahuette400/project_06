<?php

namespace App\Controller;

use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;

class IndexController extends AbstractController
{

    #[Route('/', name: 'app_blog')]
    public function index(TrickRepository $tricksRepo, Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $tricksRepo->getTrickPaginator($offset);
        return $this->render('blog/index.html.twig', [
            'tricks' => $paginator,
            'previous' => $offset - TrickRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + TrickRepository::PAGINATOR_PER_PAGE)
        ]);
    }

}