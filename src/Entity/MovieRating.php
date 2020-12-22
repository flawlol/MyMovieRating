<?php

namespace App\Entity;

use App\Repository\MovieRatingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MovieRatingRepository::class)
 */
class MovieRating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *     min = 1,
     *     max = 10,
     *     minMessage="Minimum value must be equal to 1, or higher",
     *     maxMessage="Maximum value must be equal to 10, or lower"
     * )
     */
    private $movie_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $acting;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *     min = 1,
     *     max = 10,
     *     minMessage="Minimum value must be equal to 1, or higher",
     *     maxMessage="Maximum value must be equal to 10, or lower",
     * )
     */
    private $visual;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *     min = 1,
     *     max = 10,
     *     minMessage="Minimum value must be equal to 1, or higher",
     *     maxMessage="Maximum value must be equal to 10, or lower",
     * )
     */
    private $story;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *     min = 1,
     *     max = 10,
     *     minMessage="Minimum value must be equal to 1, or higher",
     *     maxMessage="Maximum value must be equal to 10, or lower",
     * )
     */
    private $entertainment_value;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *     min = 1,
     *     max = 10,
     *     minMessage="Minimum value must be equal to 1, or higher",
     *     maxMessage="Maximum value must be equal to 10, or lower",
     * )
     */
    private $historical_fidelity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *     min = 1,
     *     max = 10,
     *     minMessage="Minimum value must be equal to 1, or higher",
     *     maxMessage="Maximum value must be equal to 10, or lower",
     * )
     */
    private $overall;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieId(): ?int
    {
        return $this->movie_id;
    }

    public function setMovieId(?int $movie_id): self
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    public function getActing(): ?int
    {
        return $this->acting;
    }

    public function setActing(?int $acting): self
    {
        $this->acting = $acting;

        return $this;
    }

    public function getVisual(): ?int
    {
        return $this->visual;
    }

    public function setVisual(?int $visual): self
    {
        $this->visual = $visual;

        return $this;
    }

    public function getStory(): ?int
    {
        return $this->story;
    }

    public function setStory(?int $story): self
    {
        $this->story = $story;

        return $this;
    }

    public function getEntertainmentValue(): ?int
    {
        return $this->entertainment_value;
    }

    public function setEntertainmentValue(?int $entertainment_value): self
    {
        $this->entertainment_value = $entertainment_value;

        return $this;
    }

    public function getHistoricalFidelity(): ?int
    {
        return $this->historical_fidelity;
    }

    public function setHistoricalFidelity(?int $historical_fidelity): self
    {
        $this->historical_fidelity = $historical_fidelity;

        return $this;
    }

    public function getOverall(): ?int
    {
        return $this->overall;
    }

    public function setOverall(?int $overall): self
    {
        $this->overall = $overall;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
