<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Url;

#[Entity(repositoryClass: MovieRepository::class)]
#[Table(name: 'movies')]
#[UniqueEntity('imdbID')]
class Movie
{
    #[Id, GeneratedValue, Column(type: 'integer')]
    private ?int $id;

    #[Column(type: 'string', length: 255)]
    private ?string $title;

    #[Column(type: 'date')]
    private ?\DateTimeInterface $releaseDate;

    #[Column(type: 'string', length: 12)]
    private ?string $imdbId;

    #[Column(type: 'string', length: 255, nullable: true)]
    #[Url]
    private ?string $poster;

    #[Column(type: 'text', nullable: true)]
    private ?string $plot;

    #[Column(type: 'string', length: 10)]
    private ?string $duration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getImdbId(): ?string
    {
        return $this->imdbId;
    }

    public function setImdbId(string $imdbId): self
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(?string $plot): self
    {
        $this->plot = $plot;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public static function fromApi(array $movieInfo): self
    {
        return (new self())
            ->setTitle($movieInfo['Title'])
            ->setImdbId($movieInfo['imdbID'])
            ->setReleaseDate(new \DateTime($movieInfo['Released']))
            ->setPoster($movieInfo['Poster'])
            ->setPlot($movieInfo['Plot'])
            ->setDuration($movieInfo['Runtime']);
    }
}
