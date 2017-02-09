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

class PersonController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction() {
        
        return $this->render('ContactBoxBundle:Person:index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deletePerson")
     */
    public function deletePersonAction()
    {
        return $this->render('ContactBoxBundle:Person:delete_person.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/editPerson")
     */
    public function editPersonAction()
    {
        return $this->render('ContactBoxBundle:Person:edit_person.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showPerson/{id}", requirements={"id"="\d+"})
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
        $persons = $repo->findAll();

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
                ->add("name", "text", ["label" => "Podaj imię: "])
                ->add("surname", "text", ["label" => "Podaj nazwisko: "])
                ->add("description", "textarea", ["label" => "Wpisz opis: "])
                ->add("save", "submit", ["label" => "Kliknij żeby dodać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", ["id" => $person->getId()]);
        }

        return $this->render('ContactBoxBundle:Person:add_person.html.twig', array(
                    "form" => $form->createView()
        ));
    }

}
