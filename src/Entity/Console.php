<?php

namespace App\Entity;

use App\Entity\Stocks;
use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConsoleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ConsoleRepository::class)]
class Console
{

    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'console', targetEntity: Stocks::class, orphanRemoval: true)]
    private Collection $stocks;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $console_name = null;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Stocks>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stocks $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setConsole($this);
        }

        return $this;
    }

    public function removeStock(Stocks $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getConsole() === $this) {
                $stock->setConsole(null);
            }
        }

        return $this;
    }

    public function getLogoName(): ?string
    {
        return $this->logo_name;
    }

    public function setLogoName(string $logo_name): static
    {
        $this->logo_name = $logo_name;

        return $this;
    }

    public function getConsoleName(): ?string
    {
        return $this->console_name;
    }

    public function setConsoleName(string $console_name): static
    {
        $this->console_name = $console_name;

        return $this;
    }
}
