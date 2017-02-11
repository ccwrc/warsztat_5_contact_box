<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use ContactBoxBundle\Entity\Person;
use ContactBoxBundle\Entity\Address;
use ContactBoxBundle\Entity\Email;
use ContactBoxBundle\Entity\Phone;

class PersonController extends Controller {
    
    /**
     * @Route("/")
     */
    public function indexAction() {
        return $this->render('ContactBoxBundle:Person:index.html.twig');
    }

    /**
     * @Route("/{id}/deletePerson", requirements={"id"="\d+"})
     */
    public function deletePersonAction($id) {
        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $person = $repo->find($id);

        if ($person == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }
        //TODO zmienic na DQL i sprawdzic/porownac efektywnosc
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();
        
        return $this->redirectToRoute("contactbox_person_showallpersons");
    }

    /**
     * @Route("/{id}/editPerson", requirements={"id"="\d+"})
     */
    public function editPersonAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $person = $repo->find($id);

        if ($person == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $form = $this->createFormBuilder($person)
                ->setMethod("POST")
                ->add("name", "text", ["label" => "Podaj imię: "])
                ->add("surname", "text", ["label" => "Podaj nazwisko: "])
                ->add("description", "textarea", ["label" => "Wpisz opis: "])
                ->add("save", "submit", ["label" => "Zapisz nowe dane"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showallpersons");
        }

        return $this->render('ContactBoxBundle:Person:edit_person.html.twig', array(
                    "form" => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/showPerson", requirements={"id"="\d+"})
     */
    public function showPersonAction($id) {
        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $person = $repo->find($id);

        if ($person == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        return $this->render('ContactBoxBundle:Person:show_person.html.twig', array(
                    "person" => $person
        ));
    }

    /**
     * @Route("/showAllPersons")
     */
    public function showAllPersonsAction() {
        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        // $persons = $repo->findAll();
        $persons = $repo->findBy([], ["surname" => "ASC"]);

        if ($persons == null) {
            throw $this->createNotFoundException("Brak osób w bazie");
        }

        return $this->render('ContactBoxBundle:Person:show_all_persons.html.twig', array(
                    "persons" => $persons
        ));
    }
    
    /**
     * @Route("/addPerson")
     */
    public function addPersonAction(Request $req) {
        $person = new Person();
        $form = $this->createFormBuilder($person)
                ->setMethod("POST")
                ->add("name", "text", ["label" => "Podaj imię: "])
                ->add("surname", "text", ["label" => "Podaj nazwisko: "])
                ->add("description", "textarea", ["label" => "Wpisz opis: "])
                ->add("save", "submit", ["label" => "Kliknij żeby dodać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", [
                        "id" => $person->getId()
            ]);
        }

        return $this->render('ContactBoxBundle:Person:add_person.html.twig', array(
                    "form" => $form->createView()
        ));
    }

}
