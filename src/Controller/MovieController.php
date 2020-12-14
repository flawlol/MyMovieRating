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
        /// a remote_id vel nem fogunk dolgozni, csak a lekérésnél, tehát a findnál // itt nem
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

        // még itt sem feltétlenül foglalkozunk vele, mert itt az a cél, hogy lekérjük név alapján

        /*$entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Movie::class)->findBy(['id' => 1]);

        foreach ($product as $test) {
            $test->setMovieRemoteId('New proeeduct name!')->setUrl('asdfffasd');
            $entityManager->flush();
        }*/

        //return $this->json($movies);

        //return New Response(null,Response::HTTP_OK);
        // // ha lehet nem hozunk létre new -val osztályt soha, csak ha nem elkerülhető
        // ok: töri az elvet miszerint: single responsibility  - az egyik alapelve a cleancodenak

        //dd($product->setMovieRemoteId('New product name!'));
    }
}
