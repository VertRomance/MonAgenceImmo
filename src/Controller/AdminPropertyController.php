<?php
namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController 
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    
    public function __construct(PropertyRepository $repository,EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function index()
    {
        $properties= $this -> repository ->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($property);
                $this->em->flush();
                $this->addFlash('success', 'Bien créé avec succès');
                return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form ->createView()
        ]);

    }
    /**
     * @param Property
     * @param Request
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
                $this->em->flush();
                $this->addFlash('success', 'Bien modifié avec succès');
                return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form ->createView()
        ]);
            
    }
    /**
     * @param Property $property
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$property->getId(),$request->get('_token')))
        {
        
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.property.index');
    }

}