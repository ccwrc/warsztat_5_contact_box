<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PersonGroupController extends Controller
{
    /**
     * @Route("/addGroup")
     */
    public function addGroupAction()
    {
        return $this->render('ContactBoxBundle:PersonGroup:add_group.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showAllGroups")
     */
    public function showAllGroupsAction()
    {
        return $this->render('ContactBoxBundle:PersonGroup:show_all_groups.html.twig', array(
            // ...
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
