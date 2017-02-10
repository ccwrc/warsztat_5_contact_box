<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use ContactBoxBundle\Entity\Person;
use ContactBoxBundle\Entity\Email;

class EmailController extends Controller
{
    /**
     * @Route("/{id}/addEmail", requirements={"id"="\d+"})
     */
    public function addEmailAction(Request $req, $id) {
        $em = $this->getDoctrine()->getManager();
        $email = new Email();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        
        if ($person == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $form = $this->createFormBuilder($email)
                ->setMethod("POST")
                ->add("address", "email", ["label" => "Podaj e-mail: "])
                ->add("type", "text", ["label" => "Typ adresu: "])
                ->add("save", "submit", ["label" => "Kliknij żeby dodać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();
            $email->setPerson($person);
            $em->persist($email);
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", [
                        "id" => $person->getId()
            ]);
        }

        return $this->render('ContactBoxBundle:Email:add_email.html.twig', array(
                    "form" => $form->createView(),
                    "person" => $person
        ));
    }

    /**
     * @Route("/{id}/{emailId}/deleteEmail", requirements={"id"="\d+", "emailId"="\d+"})
     */
    public function deleteEmailAction($id, $emailId) {
        $em = $this->getDoctrine()->getManager();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $email = $this->getDoctrine()->getRepository("ContactBoxBundle:Email")->find($emailId);

        if ($person == null || $email == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $em->remove($email);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showperson", ["id" => $id]);
    }

    /**
     * @Route("/{id}/{emailId}/editEmail", requirements={"id"="\d+", "addressId"="\d+"})
     */
    public function editEmailAction(Request $req, $id, $emailId) {
        $em = $this->getDoctrine()->getManager();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $email = $this->getDoctrine()->getRepository("ContactBoxBundle:Email")->find($emailId);

        if ($person == null || $email == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $form = $this->createFormBuilder($email)
                ->setMethod("POST")
                ->add("address", "email", ["label" => "Podaj e-mail: "])
                ->add("type", "text", ["label" => "Typ adresu: "])
                ->add("save", "submit", ["label" => "Kliknij żeby zapisać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", [
                        "id" => $person->getId()
            ]);
        }

        return $this->render('ContactBoxBundle:Email:edit_email.html.twig', array(
                    "form" => $form->createView(),
                    "person" => $person
        ));
    }

}
