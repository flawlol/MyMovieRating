<?php

namespace App\Controller;

use App\Form\MovieRatingType;
use App\Service\Movie\Rating\FormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Repository\MovieRatingRepository;

/**
 * @Route("api/ratings/", name="movie_rating/")
 */
class MovieRatingController extends AbstractController
{
    private MovieRatingType $movieRatingType;
    private FormHandler $formHandler;
    private MovieRatingRepository $movieRatingRepository;

    public function __construct(MovieRatingType $movieRatingType, FormHandler $formHandler, MovieRatingRepository $movieRatingRepository)
    {

        $this->movieRatingType = $movieRatingType;
        $this->formHandler = $formHandler;
        $this->movieRatingRepository = $movieRatingRepository;
    }

    /**
     * @Route("{movieId}", name="form1", methods={"POST"})
     */
    public function submitRequests(Request $request, EntityManagerInterface $entityManager, int $movieId): Response
    {
        if ($this->formHandler->isMethodPost($request) && $this->formHandler->requestIsValidated($request)) {
            $this->formHandler->persistData($entityManager, $request, $movieId);
            return $this->json(null, Response::HTTP_OK);
        }
        return $this->json(null, Response::HTTP_FORBIDDEN);
    }


    /**
     * @Route("{movieId}", name="Movie Rating ID (get)")
     */
    public function getRating(int $movieId): Response
    {
        if ($this->movieRatingRepository->getAvgOfMovie($movieId)) {
            return $this->json($this->movieRatingRepository->getAvgOfMovie($movieId), Response::HTTP_OK);
        } else {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }
    }
}
