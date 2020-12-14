<?php

namespace App\Service;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\RemoteApi\MovieFinder;
use Doctrine\ORM\EntityManagerInterface;
use PoLaKoSz\Mafab\Models\MafabMovie;

class MovieService
{
    private MovieRepository $movieRepository;
    private EntityManagerInterface $entityManager;
    private MovieFinder $movieFinder;
    private ImageHandler $imageHandler;

    ///// symfony esetén nem kell kiirni a service neve után hogy service, hanem elég a funkcionalitását megfogalmazni 1-2 szóban. bár itt ennél a MovieServicenél
    // igy JÓ!!!!

    public function __construct(
        MovieRepository $moviesRepository,
        EntityManagerInterface $entityManager,
        MovieFinder $movieFinder,
        ImageHandler $imageHandler)
    {
        $this->movieRepository = $moviesRepository;
        $this->entityManager = $entityManager;
        $this->movieFinder = $movieFinder;
        $this->imageHandler = $imageHandler;
    }


    public function test()
    {


        //$entityManager1 = $this->getDoctrine()->getManager();
        $test = $this->movieRepository->findById(1);

        //$mafab = new Mafab();
        //$search = $mafab->search(); // @return PoLaKoSz\Mafab\EndPoints\SearchEndpointInterface

        //$results = $search->quicklyFor('Avatar');

        // Igazából azt akartam hogy megnézze, hogy létezik-e az adatbázisban már vagy sem. (A movie_remote_Id alapján)
        // ez egy "egyszerű" findOrCreate, csak itt neked kell implementálni a funkcióját

        //$this->movieRepository->save($results);

        $test->setUrl('test1');


        //return '1';
    }

    public function findOrCreateMovie(): Movie
    {

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
                $this->imageHandler->save($mafabMovie->getID().'.jpg',$mafabMovie->getThumbnailImage());
            } catch (\Exception $exception) {
                // TODO: $this->logger ......   (LoggerInterface)
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
