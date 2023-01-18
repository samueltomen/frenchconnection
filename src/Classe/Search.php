<?php
namespace App\Classe;

use App\Entity\Category;
class Search
{
    /**
     * @var string
     * La chaîne de recherche
     */
    public $string = '';

    /**
     * @var Category[]
     * Tableau des catégories de recherche
     */
    public $categories = [];
}
