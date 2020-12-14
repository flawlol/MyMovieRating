<?php

namespace App\Controller;

use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @var MovieService
     */
    private MovieService $movieService;


    public function __construct(MovieService $movieService)
    {

        $this->movieService = $movieService;
    }

    /**
     * @Route("/movie/{name}", name="movie")
     */
    public function show(int $id): JsonResponse
    {
        //TODO finish
    }

    /**
     * @Route("/movie/find/{name}", name="movie")
     */
    public function find(string $name): JsonResponse
    {
        $movies = $this->movieService->findMovieListByName($name);

        $moviesArray = []; // TODO: Models & Transformers
        foreach ($movies as $movie) {
            $moviesArray[] = [
                'id' => $movie->getId(),
                'remote_id' => $movie->getMovieRemoteId(),
                'hungarian_title' => $movie->getHungarianTitle(),
                'original_title' => $movie->getOriginalTitle(),
                'thumbnail_image' => $movie->getThumbnailImage(),
                'year' => $movie->getYear(),
                'url' => $movie->getUrl(),
            ];
        }
        return $this->json($moviesArray);
    }
}
