<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }


    //TODO: https://stackoverflow.com/questions/20023426/symfony-doctrine-sum-and-avg-score-of-players


    public function save($value): void
    {
        $this->getEntityManager()->persist($value);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id)
    {
        return $this->createQueryBuilder('m')
            ->where('m.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByRemoteId($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.movie_remote_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOrCreate(Movie $movie)
    {
        $selectedMovie = $this->findByRemoteId($movie->getMovieRemoteId());
        if ($selectedMovie === null) {
            $this->save($movie);
            $selectedMovie = $movie;
        }
        return $selectedMovie;
    }
}
