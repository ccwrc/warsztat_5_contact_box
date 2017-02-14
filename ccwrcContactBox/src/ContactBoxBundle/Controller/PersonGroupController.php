<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use ContactBoxBundle\Entity\PersonGroup;

class PersonGroupController extends Controller {

    /**
     * @Route("/addGroup")
     */
    public function addGroupAction(Request $req) {
        $em = $this->getDoctrine()->getManager();
        $group = new PersonGroup();

        $form = $this->createFormBuilder($group)
                ->setMethod("POST")
                ->add("name", "text", ["label" => "Podaj nazwę grupy: "])
                ->add("save", "submit", ["label" => "Kliknij żeby dodać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $em->persist($group);
            $em->flush();
            return $this->redirectToRoute("contactbox_persongroup_showallgroups");
        }

        return $this->render('ContactBoxBundle:PersonGroup:add_group.html.twig', array(
                    "form" => $form->createView()
        ));
    }

    /**
     * @Route("/showAllGroups")
     */
    public function showAllGroupsAction() {
        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup");
        $groups = $repo->findAll();

        return $this->render('ContactBoxBundle:PersonGroup:show_all_groups.html.twig', array(
                    "groups" => $groups
        ));
    }

    /**
     * @Route("/{id}/editGroup", requirements={"id"="\d+"})
     */
    public function editGroupAction(Request $req, $id) {
        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup");
        $group = $repo->find($id);
        $em = $this->getDoctrine()->getManager();

        if ($group == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $form = $this->createFormBuilder($group)
                ->setMethod("POST")
                ->add("name", "text", ["label" => "Podaj nazwę grupy: "])
                ->add("save", "submit", ["label" => "Kliknij żeby zapisać"])
                ->getForm();

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $em->flush();
            return $this->redirectToRoute("contactbox_persongroup_showallgroups");
        }

        return $this->render('ContactBoxBundle:PersonGroup:edit_group.html.twig', array(
                    "form" => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/deleteGroup", requirements={"id"="\d+"})
     */
    public function deleteGroupAction($id) {
        $repo = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup");
        $em = $this->getDoctrine()->getManager();
        $group = $repo->find($id);

        if ($group == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $em->remove($group);
        $em->flush();

        return $this->redirectToRoute("contactbox_persongroup_showallgroups");
    }

    /**
     * @Route("/{id}/{groupId}/addPersonToGroup", requirements={"id"="\d+", "groupId"="\d+"})
     */
    Public function addPersonToGroupAction($id, $groupId) {
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $group = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup")->find($groupId);
        $em = $this->getDoctrine()->getManager();

        if ($group == null || $person == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }
   
        if ($person->getGroups()->contains($group)) { 
            return $this->redirectToRoute("contactbox_person_showperson", ["id" => $id]);
        }

        $group->addPerson($person);
        $person->addGroup($group);
        $em->flush();

        return $this->redirectToRoute("contactbox_person_showperson", ["id" => $id]);
    }

    /**
     * @Route("/{id}/{groupId}/deletePersonFromGroup", requirements={"id"="\d+", "groupId"="\d+"})
     */
    Public function deletePersonFromGroupAction($id, $groupId) {
        $person = $this->getDoctrine()->getRepository("ContactBoxBundle:Person")->find($id);
        $group = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup")->find($groupId);
        $em = $this->getDoctrine()->getManager();

        if ($group == null || $person == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        if ($person->getGroups()->contains($group)) {
            $person->removeGroup($group);
            $group->removePerson($person);
            $em->flush();
            return $this->redirectToRoute("contactbox_person_showperson", ["id" => $id]);
        }
        
        return $this->redirectToRoute("contactbox_person_showperson", ["id" => $id]);
    }

    /**
     * @Route("/{groupId}/findPersonsFromGroup", requirements={"groupId"="\d+"})
     */
    public function findPersonsFromGroupAction($groupId) {
        $em = $this->getDoctrine()->getManager();
        $group = $this->getDoctrine()->getRepository("ContactBoxBundle:PersonGroup")->find($groupId);

        if ($group == null) {
            throw $this->createNotFoundException("Brak ID w bazie");
        }

        $query = $em->createQuery('SELECT p FROM ContactBoxBundle:Person p WHERE :groupId '
                        . 'MEMBER OF p.groups')->setParameter('groupId', $groupId);
        $persons = $query->getResult();

        return $this->render('ContactBoxBundle:Person:show_all_persons.html.twig', array(
                    "persons" => $persons
        ));
    }

}
