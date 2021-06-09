<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ContainerZl3fGfM\PaginatorInterface_82dac15;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class PropertyController extends AbstractController 
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;
    public function __construct(PropertyRepository $repository,$em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
   
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search= new PropertySearch();
        $form=$this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);


        $properties =$paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), 
            12);

        return $this->render('property/index.html.twig', [
            'menu' => 'properties',
            'properties' => $properties,
            'form'=> $form->createView(),
        ]);
    }
   
    public function show($slug, $id): Response
    {
        $property=$this->repository->find($id);
        return $this->render('property/show.html.twig', [
            'property'=>$property,
            'menu' => 'properties'
        ]);
    }
}

