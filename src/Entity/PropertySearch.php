<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PropertySearch
{
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     * @var string|null
     */
    private $category;

    /**
     * @var SubCategory|null
     */
    private $subcategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubCategory", inversedBy="properties")
     * @var string|null
     */
    private $keyword;

    /**
     * @var App\Entity\User|null
     */
    private $username;

    public function __construct()
    {
        $property = new Property();
        $this->category = $property->getCategory();
        $this->subcategory = $property->getSubCategory();
    }

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
     * @return SubCategory|null
     */
    public function getSubcategory(): ?SubCategory
    {
        return $this->subcategory;
    }

    /**
     * @param SubCategory|null $subcategory
     * @return PropertySearch
     */
    public function setSubcategory(?SubCategory $subcategory): PropertySearch
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