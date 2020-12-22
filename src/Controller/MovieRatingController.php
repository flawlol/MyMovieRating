<?php


namespace App\Controller;

use App\Repository\MovieRatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/ratings/", name="Api ratings")
 */
class MovieRatingController extends AbstractController
{

    private MovieRatingRepository $movieRatingRepository;

    public function __construct(MovieRatingRepository $movieRatingRepository)
    {
        $this->movieRatingRepository = $movieRatingRepository;
    }

    /**
     * @Route("{movieId}", name="Movie Rating ID (get)")
     */
    public function getRating(int $movieId): JsonResponse
    {
        if ($this->movieRatingRepository->getAvgOfMovie($movieId)) {
            return $this->json($this->movieRatingRepository->getAvgOfMovie($movieId), Response::HTTP_OK);
        } else {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }
    }

}