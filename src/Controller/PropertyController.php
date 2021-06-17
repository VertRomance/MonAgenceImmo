<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use App\Notification\ContactNotification;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        // On pagine le tableau d'objet que nous retourne doctrine à l'aide de la méthode paginate du PaginatorInterface
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
   
    public function show(Property $property,string $slug, Request $request, ContactNotification $contactNotification): Response
    {
    
        // if($property->getSlug() !== $slug){
        //     return $this->redirectToRoute('property.show',[
        //         'id'=>$property->getId(),
        //         'slug'=>$property->getSlug()
        //     ],301);
        // }

        $contact = new Contact();
        $contact->setProperty($property);
        $form=$this->createForm(ContactType::class,$contact, [
            'action'=> $this->generateUrl('property.show', [
                'id' => $request->get('id'),
                'slug' => $request->get('slug')
                ])
            ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           
            $contactNotification->notify($contact);
            $this->addFlash('success', 'Votre message a bien été envoyé');
            // return $this->redirectToRoute('property.show',[
            //     'id'=>$property->getId(),
            //     'slug'=>$property->getSlug()
            // ]);
        }
        

        return $this->render('property/show.html.twig', [
            'property'=>$property,
            'menu' => 'properties',
            'form' => $form->createView()
        ]);
    }
}

