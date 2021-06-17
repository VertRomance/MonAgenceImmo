<?php
namespace App\Controller;


use App\Entity\Picture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/picture")
 */
class AdminPictureController extends AbstractController{
    
    public function delete(Picture $picture, Request $request) {

        $data=json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete'. $picture->getId(), $data['_token'])) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();
            return new JsonResponse(['success'=>1]);
        }
        return new JsonResponse(['error'=> 'Token invalid'], 400);
            
    }
}