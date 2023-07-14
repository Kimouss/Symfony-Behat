<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Product
{
    #[Assert\NotNull]
    #[Assert\Length(
        min: 4,
        minMessage: "Ce champ doit comporter plus de {{ limit }} caractères."
    )]
    private string $name;

    private ?string $description = null;

    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(
        value: 20,
        message: "Cette valeur doit être supérieur à {{ compared_value }}."
    )]
    private int $price;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Product
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): Product
    {
        $this->price = $price;

        return $this;
    }
}
