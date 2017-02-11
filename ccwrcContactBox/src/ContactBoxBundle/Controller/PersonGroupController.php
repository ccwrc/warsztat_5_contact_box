<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use ContactBoxBundle\Entity\Person;
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
     * @Route("/editGroup")
     */
    public function editGroupAction()
    {
        return $this->render('ContactBoxBundle:PersonGroup:edit_group.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deleteGroup")
     */
    public function deleteGroupAction()
    {
        return $this->render('ContactBoxBundle:PersonGroup:delete_group.html.twig', array(
            // ...
        ));
    }

}
