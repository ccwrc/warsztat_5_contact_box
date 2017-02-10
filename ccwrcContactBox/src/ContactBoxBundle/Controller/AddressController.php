<?php

namespace ContactBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AddressController extends Controller
{
    /**
     * @Route("/addAddress")
     */
    public function addAddressAction()
    {
        return $this->render('ContactBoxBundle:Address:add_address.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deleteAddress")
     */
    public function deleteAddressAction()
    {
        return $this->render('ContactBoxBundle:Address:delete_address.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/editAddress")
     */
    public function editAddressAction()
    {
        return $this->render('ContactBoxBundle:Address:edit_address.html.twig', array(
            // ...
        ));
    }

}
