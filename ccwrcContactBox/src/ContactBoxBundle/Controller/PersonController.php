<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use ContactBoxBundle\Entity\Person;

class PersonController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction()
    {
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
     * @Route("/showPerson")
     */
    public function showPersonAction()
    {
        return $this->render('ContactBoxBundle:Person:show_person.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showAllPersons")
     */
    public function showAllPersonsAction() {
        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $persons = $repo->findAll();
        
        return $this->render('ContactBoxBundle:Person:show_all_persons.html.twig', array(
            "persons" => $persons
        ));
    }

}
