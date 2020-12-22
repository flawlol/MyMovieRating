<?php

namespace App\Repository;

use App\Entity\MovieRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method MovieRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieRating[]    findAll()
 * @method MovieRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRatingRepository extends ServiceEntityRepository
{
    private MovieRepository $movieRepository;

    public function __construct(ManagerRegistry $registry, MovieRepository $movieRepository)
    {
        parent::__construct($registry, MovieRating::class);
        $this->movieRepository = $movieRepository;
    }

    public function getAvgOfMovie(int $id)
    {
        $movieRating = $this->createQueryBuilder('m')
            ->select('
                avg(m.historical_fidelity) as historical_fidelity,
                avg(m.acting) as acting,
                avg(m.visual) as visual,
                avg(m.story) as story,
                avg(m.entertainment_value) as entertainment_value,
                avg(m.overall) as overall,
                count(m.id) as quantity
                ')
            ->andWhere('m.movie = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        return $movieRating['quantity'] > 0 ? $movieRating : null;
    }

    public function isMovieRatingExists(int $movieId): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.movie_id = :id')
            ->setParameter('id', $movieId)
            ->getQuery()
            ->getResult();
    }
}
