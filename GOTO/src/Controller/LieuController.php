<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieu", name="lieu")
     */
    public function index(): Response
    {
        return $this->render('lieu/index.html.twig', [
            'controller_name' => 'LieuController',
        ]);
    }


    /**
     * @param LieuRepository $repository
     * @return Response
     * @Route ("/AdminAfficheL",name="AdminAfficheL")
     */
    public function AfficheL(LieuRepository $repository)
    {
        $Lieu = $repository->findAll();
        return $this->render('lieu/AfficheL.html.twig', ['lieu' => $Lieu]);

    }


    /**
     * @param $id
     * @param LieuRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/DeleteL/{id}",name="dL")
     */
    public function DeleteL($id, LieuRepository $repository)
    {
        $lieu = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($lieu);
        $em->flush();
        return $this->redirectToRoute('AdminAfficheL');


    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     * @Route ("lieu/AddL",name="AddL")
     */
   function AddL(\Symfony\Component\HttpFoundation\Request $request){
        $lieu=new Lieu();
        $form=$this->createForm(LieuType::class,$lieu);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $lieu->setMenu('Menu.pdf');

            $menuFile = $form->get('MenuFile')->getData();
            if ($menuFile){
                $menuFileName = pathinfo($menuFile->getClientOriginalNme(),PATHINFO_FILENAME);
                try{
                    $menuFile->move($this->getParameter('upload_directory'),$menuFileName);

                } catch (FileException $e){
                    return $this->render("Erreur dans le téléchargement");
                }
                $menuFileName = 'Error ...';
                $lieu->setMenu($menuFileName);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($lieu);
            $em->flush();
            return $this->redirectToRoute('AdminAfficheL');

        }
        return $this->render('lieu/AddL.html.twig',[
            'f'=>$form->createView()
        ]);

   }



    /**
     * @Route ("lieu/UpdateL/{id}",name="updateL")
     */
    function UpdateL(LieuRepository $repository,\Symfony\Component\HttpFoundation\Request $request,$id){
        $lieu=$repository->find($id);
        $form=$this->createForm(LieuType::class,$lieu);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AdminAfficheL");
         }
        return $this->render('lieu/UpdateL.html.twig',
        [
            'f'=>$form->createView()
        ]);


    }

    /**
     * @Route ("lieu/rechercheL",name="rechercheL")
     */
    function RechercheL(LieuRepository $repository,\Symfony\Component\HttpFoundation\Request $request){
       $data=$request->get('searchL');
       $lieu=$repository->findBy(['Nom'=>$data]);
       return $this->render('lieu/AfficheL.html.twig',
       [
           'lieu'=>$lieu
       ]);
    }

}


