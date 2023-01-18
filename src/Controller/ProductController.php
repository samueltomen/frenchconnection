<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    # Gestionnaire d'entités, utilisé pour interagir avec la base de données
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        # Injection du gestionnaire d'entités dans le constructeur
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'products')]
    public function index(Request $request): Response
    {
        # Création d'un nouvel objet Search
        $search = new Search();
        # Création d'un formulaire avec la classe SearchType
        $form = $this->createForm(SearchType::class, $search);

        # Traitement de la requête du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            # Recherche des produits avec les critères de recherche
            $products = $this->entityManager
                ->getRepository(Product::class)
                ->findWithSearch($search);
        } else {
            # Si le formulaire n'est pas soumis ou n'est pas valide, récupérer tous les produits
            $products = $this->entityManager
                ->getRepository(Product::class)
                ->findAll();
        }

        # Retourner la vue avec les produits et le formulaire
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug): Response
    {
        # Trouver un produit par son slug
        $product = $this->entityManager
            ->getRepository(Product::class)
            ->findOneBySlug($slug);

        if (!$product) {
            # Si le produit n'est pas trouvé, rediriger vers la liste des produits
            return $this->redirectToRoute('products');
        }

        # Retourner la vue avec le produit
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
