<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use ContactBoxBundle\Entity\Person;

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
            return $this->redirectToRoute("contactbox_person_showperson", ["id" => $id]);
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
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!is_string($user)) {
            $userId = $user->getId();
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT p FROM ContactBoxBundle:Person p WHERE p.user = '
                            . ':userId')->setParameter('userId', $userId);
            $persons = $query->getResult();

            return $this->render('ContactBoxBundle:Person:show_all_persons.html.twig', array(
                        "persons" => $persons
            ));
        }

        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:Person");
        $persons = $repo->findBy([], ["surname" => "ASC"]);


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
            $user = $this->container->get('security.context')->getToken()->getUser();

            if (is_string($user)) {
                $user = null;
            }
            $person->setUser($user);

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

    /**
     * @Route("/findPerson")
     */
    public function findPersonAction(Request $req) {
        $person = new Person();
        $form = $this->createFormBuilder($person)
                ->setMethod("POST")
                ->add("name", "text", ["label" => "Podaj imię lub nazwisko: "])
                ->add("save", "submit", ["label" => "Kliknij żeby wyszukać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $findByNameOrSurname = $req->request->get("form")["name"];
            $query = $em->createQuery('SELECT p FROM ContactBoxBundle:Person p WHERE p.name LIKE '
                            . ':findByNameOrSurname OR p.surname LIKE :findByNameOrSurname'
                            . '')->setParameter('findByNameOrSurname', "%" . $findByNameOrSurname . "%");
            $persons = $query->getResult();

            return $this->render('ContactBoxBundle:Person:show_all_persons.html.twig', array(
                        "persons" => $persons
            ));
        }

        return $this->render('ContactBoxBundle:Person:find_person.html.twig', array(
                    "form" => $form->createView()
        ));
    }

    /**
     * @Route("/addPersonToGroup/{id}", requirements={"id"="\d+"})
     */
    public function addPersonToGroupAction($id) {
        $groups = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup")->findAll();
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);

        return $this->render('ContactBoxBundle:PersonGroup:add_person_to_group.html.twig', array(
                    "groups" => $groups,
                    "person" => $person
        ));
    }

    /**
     * @Route("/deletePersonFromGroup/{id}", requirements={"id"="\d+"})
     */
    public function deletePersonFromGroupAction($id) {
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);

        return $this->render('ContactBoxBundle:PersonGroup:delete_person_from_group.html.twig', array(
                    "person" => $person
        ));
    }

}
