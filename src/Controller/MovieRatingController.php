<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\MovieRating;
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

    /**
     * @var MovieRatingType
     */
    private MovieRatingType $movieRatingType;
    /**
     * @var FormHandler
     */
    private FormHandler $formHandler;


    public function __construct(MovieRatingType $movieRatingType, FormHandler $formHandler)
    {

        $this->movieRatingType = $movieRatingType;
        $this->formHandler = $formHandler;
    }

    /**
     * @Route("rating", name="movie_rating", methods={"POST"})
     */
    public function index(Request $request): Response
    {

        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            //dd($request->get('visual'));
            if ($form->isSubmitted() && $form->isValid()) {
                dd('valid');
                $movie = $form->getData();
                dd(1);

                // $this->entityManager->persist($task);
                // $this->entityManager->flush();
            }
        }
        // $formHandler->handleRequest($request);

        //     if ($formHandler->isSubmitted()) {
        //         $formHandler->handle();
        //    }
        return $this->json(null, 200);
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
