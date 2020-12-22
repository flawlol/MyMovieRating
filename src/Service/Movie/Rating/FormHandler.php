<?php

namespace App\Service\Movie\Rating;

use App\Entity\MovieRating;
use App\Form\MovieRatingType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class FormHandler extends AbstractController
{
    /**
     * @var MovieRepository
     */
    private MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function initializeEntity(): MovieRating
    {
        return new MovieRating();
    }

    public function buildForm($entity): FormInterface
    {
        return $this->createForm(MovieRatingType::class, $entity);
    }

    public function createFormView(Environment $twig): Response
    {
        $form = $this->buildForm($this->initializeEntity());

        return new Response($twig->render('test.html.twig', [
            'test_form' => $form->createView()
        ]));
    }

    public function handleSubmitRequest(Request $request, $entity): FormInterface
    {
        return $this
            ->buildForm($entity)
            ->handleRequest($request);
    }

    public function requestIsValidated(Request $request): bool
    {
        $form = $this->handleSubmitRequest($request, $this->initializeEntity());

        return $form->isSubmitted() && $form->isValid();
    }

    public function persistData(EntityManagerInterface $entityManager, Request $request, int $movieId): void
    {
        $entity = $this->initializeEntity();
        $movie = $this->findMovieById($movieId);

        $entity->setMovie($movie);

        $this->handleSubmitRequest($request, $entity);

        $entityManager->persist($entity);
        $entityManager->flush();
    }

    public function findMovieById(int $id)
    {
        return $this->movieRepository->findById($id);
    }

    public function isMethodPost(Request $request): bool
    {
        return $request->isMethod('POST');
    }
}