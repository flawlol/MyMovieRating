<?php

namespace App\Service;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\RemoteApi\MovieFinder;
use Doctrine\ORM\EntityManagerInterface;
use PoLaKoSz\Mafab\Models\MafabMovie;
use Psr\Log\LoggerInterface;

class MovieService
{
    private MovieRepository $movieRepository;
    private EntityManagerInterface $entityManager;
    private MovieFinder $movieFinder;
    private ImageHandler $imageHandler;

    public function __construct(
        MovieRepository $moviesRepository,
        EntityManagerInterface $entityManager,
        MovieFinder $movieFinder,
        ImageHandler $imageHandler,
        LoggerInterface $logger)
    {
        $this->movieRepository = $moviesRepository;
        $this->entityManager = $entityManager;
        $this->movieFinder = $movieFinder;
        $this->imageHandler = $imageHandler;
        $this->logger = $logger;
    }

    /**
     * @param string $name
     * @return iterable|Movie[]
     */
    public function findMovieListByName(string $name): iterable
    {
        /** @var MafabMovie[] $results */
        $results = $this->movieFinder->find($name);

        $movieList = [];
        foreach ($results as $mafabMovie) {
            $movie = $this->makeMovie($mafabMovie);

            $movieList[] = $this->movieRepository->findOrCreate($movie);

            try {
                $this->imageHandler->save($mafabMovie->getID() . '.jpg', $mafabMovie->getThumbnailImage());
                throw new \Exception('Test exception');
            } catch (\Exception $exception) {
                // TODO: $this->logger ......   (LoggerInterface)
                $this->logger->error(
                    'Failed to save image',
                    [
                        'link' => $mafabMovie->getThumbnailImage(),
                        'remote_id' => $mafabMovie->getID(),
                        'exception' => $exception
                    ]
                );
            }
        }

        return $movieList;
    }

    private function makeMovie(MafabMovie $mafabMovie)
    {
        $movie = new Movie();
        return $movie
            ->setOriginalTitle($mafabMovie->getOriginalTitle())
            ->setHungarianTitle($mafabMovie->getHungarianTitle())
            ->setMovieRemoteId($mafabMovie->getID())
            ->setUrl($mafabMovie->getURL())
            ->setYear($mafabMovie->getYear())
            ->setThumbnailImage($mafabMovie->getID() . '.jpg');
    }
}
