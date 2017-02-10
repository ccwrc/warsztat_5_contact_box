<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class EmailController extends Controller
{
    /**
     * @Route("/addEmail")
     */
    public function addEmailAction()
    {
        return $this->render('ContactBoxBundle:Email:add_email.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deleteEmail")
     */
    public function deleteEmailAction()
    {
        return $this->render('ContactBoxBundle:Email:delete_email.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/editEmail")
     */
    public function editEmailAction()
    {
        return $this->render('ContactBoxBundle:Email:edit_email.html.twig', array(
            // ...
        ));
    }

}
