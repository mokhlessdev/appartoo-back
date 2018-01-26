<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="marsupilami")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarsupilamiRepository")
 * 
 */
class Marsupilami extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $famille;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $race;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $nourriture;

     /**
     * @ORM\ManyToMany(targetEntity="Marsupilami", inversedBy="friendOf")
     * @ORM\JoinTable(name="friends",
     * joinColumns={
     *      @ORM\JoinColumn(name="friends_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="friend_id", referencedColumnName="id")
     *  })
     */    
    private $friends;

    /**
     * @ORM\ManyToMany(targetEntity="Marsupilami", mappedBy="friends")
     */
    private $friendOf;

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return User
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set race
     *
     * @param string $race
     *
     * @return User
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set nourriture
     *
     * @param string $nourriture
     *
     * @return User
     */
    public function setNourriture($nourriture)
    {
        $this->nourriture = $nourriture;

        return $this;
    }

    /**
     * Get nourriture
     *
     * @return string
     */
    public function getNourriture()
    {
        return $this->nourriture;
    }

    

    /**
     * Add friend
     *
     * @param \AppBundle\Entity\Marsupilami $friend
     *
     * @return Marsupilami
     */
    public function addFriend(\AppBundle\Entity\Marsupilami $friend)
    {
        $this->friends[] = $friend;

        return $this;
    }

    /**
     * Remove friend
     *
     * @param \AppBundle\Entity\Marsupilami $friend
     */
    public function removeFriend(\AppBundle\Entity\Marsupilami $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Add friendOf
     *
     * @param \AppBundle\Entity\Marsupilami $friendOf
     *
     * @return Marsupilami
     */
    public function addFriendOf(\AppBundle\Entity\Marsupilami $friendOf)
    {
        $this->friendOf[] = $friendOf;

        return $this;
    }

    /**
     * Remove friendOf
     *
     * @param \AppBundle\Entity\Marsupilami $friendOf
     */
    public function removeFriendOf(\AppBundle\Entity\Marsupilami $friendOf)
    {
        $this->friendOf->removeElement($friendOf);
    }

    /**
     * Get friendOf
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendOf()
    {
        return $this->friendOf;
    }
}
