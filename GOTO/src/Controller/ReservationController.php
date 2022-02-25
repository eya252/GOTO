<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\AdminReservationType;
use App\Form\ClientReservationType;
use App\Form\ReservationType;
use App\Repository\LieuRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    /**
     * @param ReservationRepository $repository
     * @return Response
     * @Route ("/AdminAfficheR",name="AdminAfficheR")
     */
    public function AfficheR(ReservationRepository $repository){
        $reservation=$repository->findAll();
        return $this->render('reservation/AdminAfficheR.html.twig',
        ['reservation'=>$reservation]);
    }


    /**
     * @param ReservationRepository $repository
     * @return Response
     * @Route ("/ClientAfficheR",name="ClientAfficheR")
     */
    public function ClientAfficheR(ReservationRepository $repository){
       $reservation=$repository->findAll();
       return $this->render('reservation/ClientAfficheR.html.twig',
       ['reservation'=>$reservation]);
    }

    /**
     * @param $id
     * @param ReservationRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/DeleteR/{id}",name="dR")
     */
    public function DeleteR($id,ReservationRepository $repository){
        $reservation = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('ClientAfficheR');

    }

    /**
     * @param $id
     * @param ReservationRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/AdminDeleteR/{id}",name="AdR")
     */
    public function AdminDeleteR($id,ReservationRepository $repository){
        $reservation = $repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('AdminAfficheR');

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("reservation/AdminAddR",name="AdminAddR")
     */
  function AddR(Request $request){
   $reservation=new Reservation();
   $form=$this->createForm(ReservationType::class,$reservation);
   $form->add('Ajouter',SubmitType::class);
   $form->handleRequest($request);
   if($form->isSubmitted() && $form->isValid()){
       $em=$this->getDoctrine()->getManager();
       $em->persist($reservation);
       $em->flush();
       return $this->redirectToRoute('AdminAfficheR');
   }
   return $this->render('reservation/AdminAddR.html.twig',[
       'f'=>$form->createView()
   ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("reservation/ClientAddR",name="ClientAddR")
     */
    function ClientAddR(Request $request){
      $reservation=new Reservation();
      $form=$this->createForm(ClientReservationType::class,$reservation);
      $form->add('Ajouter',SubmitType::class);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
          $em=$this->getDoctrine()->getManager();
          $em->persist($reservation);
          $em->flush();
          return $this->redirectToRoute('ClientAfficheR');
      }
      return $this->render('reservation/ClientAddR.htm.twig',[
          'f'=>$form->createView()
      ]);
    }


   /**
    * @Route ("reservation/UpdateR/{id}",name="updateR")
    */
    function UpdateR(ReservationRepository $repository,Request $request,$id){
       $reservation=$repository->find($id);
       $form=$this->createForm(ReservationType::class,$reservation);
       $form->add('Update',SubmitType::class);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $em=$this->getDoctrine()->getManager();
           $em->flush();
           return $this->redirectToRoute("ClientAfficheR");
       }
       return $this->render('reservation/UpdateR.html.twig',
       [
           'f'=>$form->createView()
       ]);

    }

    /**
     * @Route ("reservation/AdminUpdateR/{id}",name="AdminupdateR")
     */

    function AdminUpdateR(ReservationRepository $repository, Request $request, $id)
    {
        $reservation = $repository->find($id);
        $form=$this->createForm(AdminReservationType::class, $reservation);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AdminAfficheR");
        }
        return $this->render('reservation/AdminUpdateR.html.twig',
        [
                'f'=>$form->createView()
        ]);

    }


    /**
     * @Route ("reservation/rechercheR",name="rechercheR")
     */
    function RechercheR(ReservationRepository $repository,Request $request){
        $data=$request->get('searchR');
        $date_find = new \DateTime($data);
        if(empty($data)){
            $reservation=$repository->findAll();
        }else{
            $reservation=$repository->findBy(['Date'=>$date_find]);
        }

        return $this->render('reservation/ClientAfficheR.html.twig',
            [
                'reservation'=>$reservation
            ]);
    }





}









