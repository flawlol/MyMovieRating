<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoviesRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $movie_remote_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $movie_url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $movie_hungarian_title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $movie_original_title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $movie_year;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $movie_thumbnail_image;

    /**
     * @ORM\OneToMany(targetEntity=MovieRating::class, mappedBy="movie")
     */
    private $ratings;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieRemoteId(): ?string
    {
        return $this->movie_remote_id;
    }

    public function getUrl()
    {
        return $this->movie_url;
    }

    public function getHungarianTitle()
    {
        return $this->movie_hungarian_title;
    }

    public function getOriginalTitle()
    {
        return $this->movie_original_title;
    }

    public function getYear()
    {
        return $this->movie_year;
    }

    public function getThumbnailImage()
    {
        return $this->movie_thumbnail_image;
    }

    public function setMovieRemoteId(?string $movie_remote_id): self
    {
        $this->movie_remote_id = $movie_remote_id;

        return $this;
    }

    public function setUrl(?string $movie_url): self
    {
        $this->movie_url = $movie_url;

        return $this;
    }

    public function setHungarianTitle(?string $movie_hungarian_title): self
    {
        $this->movie_hungarian_title = $movie_hungarian_title;

        return $this;
    }

    public function setOriginalTitle(?string $movie_original_title): self
    {
        $this->movie_original_title = $movie_original_title;

        return $this;
    }

    public function setYear(?string $movie_year): self
    {
        $this->movie_year = $movie_year;

        return $this;
    }

    public function setThumbnailImage(?string $movie_thumbnail_image): self
    {
        $this->movie_thumbnail_image = $movie_thumbnail_image;

        return $this;
    }

    /**
     * @return Collection|MovieRating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(MovieRating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setMovie($this);
        }

        return $this;
    }

    public function removeRating(MovieRating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getMovie() === $this) {
                $rating->setMovie(null);
            }
        }
        return $this;
    }
}
