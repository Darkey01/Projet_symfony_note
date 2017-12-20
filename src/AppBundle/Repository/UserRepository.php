<?php
/**
 * Created by PhpStorm.
 * Propietaire: Reynald
 * Date: 01/12/2017
 * Time: 14:02
 */

namespace AppBundle\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

