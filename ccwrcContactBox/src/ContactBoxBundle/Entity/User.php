<?php

namespace ContactBoxBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="ContactBoxBundle\Repository\UserRepository")
 */
class User extends BaseUser {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Person", mappedBy="user", cascade={"persist"})
     */
    private $persons;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Add persons
     *
     * @param \ContactBoxBundle\Entity\Person $persons
     * @return User
     */
    public function addPerson(\ContactBoxBundle\Entity\Person $persons) {
        $this->persons[] = $persons;

        return $this;
    }

    /**
     * Remove persons
     *
     * @param \ContactBoxBundle\Entity\Person $persons
     */
    public function removePerson(\ContactBoxBundle\Entity\Person $persons) {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons() {
        return $this->persons;
    }

}
