<?php


namespace App\Entity;


class PropertySearch
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var string|null
     */
    private $category;

    /**
     * @var string|null
     */
    private $keyword;

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return PropertySearch
     */
    public function setCategory(?string $category): PropertySearch
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    /**
     * @param string|null $keyword
     * @return PropertySearch
     */
    public function setKeyword(?string $keyword): PropertySearch
    {
        $this->keyword = $keyword;
        return $this;
    }

}