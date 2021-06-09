<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
     private $encoder;
    
    private $em;
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $this->encoder = $encoder;
        $this->em = $em;
        
    }



    public function load(ObjectManager $em)
    {
        $user = new User();
        $user->setEmail('carine.bujalance@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user,'test'));

        $this->em->persist($user);
        $this->em->flush();
    }
}
