<?php


namespace App\Entity;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
    private $subcategory;

    /**
     * @var string|null
     */
    private $keyword;

    /**
     * @var App\Entity\User|null
     */
    private $username;

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
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return PropertySearch
     */
    public function setCategory(?Category $category): PropertySearch
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubcategory(): ?string
    {
        return $this->subcategory;
    }

    /**
     * @param string|null $subcategory
     * @return PropertySearch
     */
    public function setSubcategory(?string $subcategory): PropertySearch
    {
        $this->subcategory = $subcategory;
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

    /**
     * @return App\Entity\User|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param App\Entity\User|null $username
     * @return PropertySearch
     */
    public function setUsername($username): PropertySearch
    {
        $this->username = $username;
        return $this;
    }



}