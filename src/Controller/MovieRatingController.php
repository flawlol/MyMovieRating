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

/**
 * @Route("api/ratings/", name="movie_rating/")
 */
class MovieRatingController extends AbstractController
{
    private MovieRatingType $movieRatingType;
    private FormHandler $formHandler;

    public function __construct(MovieRatingType $movieRatingType, FormHandler $formHandler)
    {

        $this->movieRatingType = $movieRatingType;
        $this->formHandler = $formHandler;
    }

    /**
     * @Route("{movieId}", name="form", methods={"GET"})
     */
    public function returnView(Environment $twig): Response
    {
        return $this->formHandler->createFormView($twig);
    }

    /**
     * @Route("{movieId}", name="form1", methods={"POST"})
     */
    public function submitRequests(Request $request, EntityManagerInterface $entityManager, int $movieId): Response
    {
        if ($this->formHandler->isMethodPost($request) && $this->formHandler->requestIsValidated($request)) {
            $this->formHandler->persistData($entityManager, $request, $movieId);
        }
        return $this->json(null, Response::HTTP_FORBIDDEN);
    }
}
