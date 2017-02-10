<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PhoneController extends Controller
{
    /**
     * @Route("/addPhone")
     */
    public function addPhoneAction()
    {
        return $this->render('ContactBoxBundle:Phone:add_phone.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deletePhone")
     */
    public function deletePhoneAction()
    {
        return $this->render('ContactBoxBundle:Phone:delete_phone.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/editPhone")
     */
    public function editPhoneAction()
    {
        return $this->render('ContactBoxBundle:Phone:edit_phone.html.twig', array(
            // ...
        ));
    }

}
