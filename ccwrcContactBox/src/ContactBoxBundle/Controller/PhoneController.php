<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use ContactBoxBundle\Entity\Phone;

class PhoneController extends Controller {

    /**
     * @Route("/{id}/addPhone", requirements={"id"="\d+"})
     */
    public function addPhoneAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();
        $phone = new Phone();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);

        if ($person == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $form = $this->createFormBuilder($phone)
                ->setMethod("POST")
                ->add("number", "text", ["label" => "Podaj telefon: "])
                ->add("type", "text", ["label" => "Typ telefonu: "])
                ->add("save", "submit", ["label" => "Kliknij żeby dodać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $phone = $form->getData();
            $phone->setPerson($person);
            $person->addPhone($phone);
            $em->persist($phone);
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", [
                        "id" => $person->getId()
            ]);
        }

        return $this->render('ContactBoxBundle:Phone:add_phone.html.twig', array(
                    "form" => $form->createView(),
                    "person" => $person
        ));
    }

    /**
     * @Route("/{id}/{phoneId}/deletePhone", requirements={"id"="\d+", "phoneId"="\d+"})
     */
    public function deletePhoneAction($id, $phoneId) {
        $em = $this->getDoctrine()->getManager();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $phone = $this->getDoctrine()->getRepository("ContactBoxBundle:Phone")->find($phoneId);

        if ($person == null || $phone == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $person->removePhone($phone);
        $em->remove($phone);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showperson", ["id" => $id]);
    }

    /**
     * @Route("/{id}/{phoneId}/editPhone", requirements={"id"="\d+", "phoneId"="\d+"})
     */
    public function editPhoneAction(Request $req, $id, $phoneId) {
        $em = $this->getDoctrine()->getManager();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $phone = $this->getDoctrine()->getRepository("ContactBoxBundle:Phone")->find($phoneId);

        if ($person == null || $phone == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $form = $this->createFormBuilder($phone)
                ->setMethod("POST")
                ->add("number", "text", ["label" => "Podaj telefon: "])
                ->add("type", "text", ["label" => "Typ telefonu: "])
                ->add("save", "submit", ["label" => "Kliknij żeby zapisać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $phone = $form->getData();
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", [
                        "id" => $person->getId()
            ]);
        }

        return $this->render('ContactBoxBundle:Phone:edit_phone.html.twig', array(
                    "form" => $form->createView(),
                    "person" => $person
        ));
    }

}
