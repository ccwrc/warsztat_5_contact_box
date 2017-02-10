<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use ContactBoxBundle\Entity\Person;
use ContactBoxBundle\Entity\Address;

class AddressController extends Controller {

    /**
     * @Route("/{id}/addAddress", requirements={"id"="\d+"})
     */
    public function addAddressAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();
        $address = new Address();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);

        if ($person == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $form = $this->createFormBuilder($address)
                ->setMethod("POST")
                ->add("city", "text", ["label" => "Podaj miasto: "])
                ->add("street", "text", ["label" => "Podaj ulicę: "])
                ->add("houseNumber", "text", ["label" => "Numer domu: "])
                ->add("flatNumber", "text", ["label" => "Numer mieszkania: "])
                ->add("save", "submit", ["label" => "Kliknij żeby dodać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $address->setPerson($person);
            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", [
                        "id" => $person->getId()
            ]);
        }

        return $this->render('ContactBoxBundle:Address:add_address.html.twig', array(
                    "form" => $form->createView(),
                    "person" => $person
        ));
    }

    /**
     * @Route("/{id}/{addressId}/deleteAddress", requirements={"id"="\d+", "addressId"="\d+"})
     */
    public function deleteAddressAction($id, $addressId) {
        $em = $this->getDoctrine()->getManager();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $address = $this->getDoctrine()->getRepository("ContactBoxBundle:Address")->find($addressId);

        if ($person == null || $address == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $em->remove($address);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showperson", ["id" => $id]);
    }

    /**
     * @Route("/{id}/{addressId}/editAddress", requirements={"id"="\d+", "addressId"="\d+"})
     */
    public function editAddressAction(Request $req, $id, $addressId) {
        $em = $this->getDoctrine()->getManager();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $address = $this->getDoctrine()->getRepository("ContactBoxBundle:Address")->find($addressId);

        if ($person == null || $address == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $form = $this->createFormBuilder($address)
                ->setMethod("POST")
                ->add("city", "text", ["label" => "Podaj miasto: "])
                ->add("street", "text", ["label" => "Podaj ulicę: "])
                ->add("houseNumber", "text", ["label" => "Numer domu: "])
                ->add("flatNumber", "text", ["label" => "Numer mieszkania: "])
                ->add("save", "submit", ["label" => "Kliknij żeby zapisać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", [
                        "id" => $person->getId()
            ]);
        }

        return $this->render('ContactBoxBundle:Address:edit_address.html.twig', array(
                    "form" => $form->createView(),
                    "person" => $person
        ));
    }

}
