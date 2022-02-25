<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @param CategorieRepository $repository
     * @return Response
     * @Route ("/AfficheC",name="AfficheC")
     */
    public function AfficheC(CategorieRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Categorie::class);
        $categorie=$repository->findAll();
        return $this->render('categorie/AfficheC.html.twig',['categorie'=>$categorie]);


    }


    /**
     * @Route ("/SuppC/{id}",name="d")
     */
    public function DeleteC($id,CategorieRepository $repository){
        $cathegorie=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($cathegorie);
        $em->flush();
        return $this->redirectToRoute('AfficheC');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/categorie/AddC",name="AddC")
     */
    function AddC(Request $request){
        $categorie=new Categorie();
        $form=$this->createForm(CategorieType::class,$categorie);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('AfficheC');
        }
        return $this->render('categorie/AddC.html.twig',[
            'f'=>$form->createView()
        ]);

    }
    /**
     * @Route ("categorie/UpdateC/{id}",name="update")
     */
     function UpdateC(CategorieRepository $repository,$id,Request $request){
        $categorie=$repository->find($id);
        $form=$this->createForm(CategorieType::class,$categorie);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficheC");
        }
        return $this->render('categorie/UpdateC.html.twig',
        [
         'f'=>$form->createView()
        ]);


     }

     /**
     * @Route ("categorie/rechercheR",name="rechercheC")
     */
    function RechercheC(CategorieRepository $repository,Request $request){
        $data=$request->get('searchC');
        if (empty($data)){
            $categorie=$repository->findAll();
        }else{
            $categorie=$repository->findBy(['Type'=>$data]);
        }
        return $this->render('categorie/AfficheC.html.twig',
        [
            'categorie'=>$categorie
        ]);
    }



}
