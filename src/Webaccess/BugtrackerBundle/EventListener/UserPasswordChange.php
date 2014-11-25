<?php

/**
 * PreUpdate class file
 *
 * PHP 5.3
 *
 * @category Library
 * @package  WebaccessBugtrackerBundle
 * @author   Antonin Jourdan <antonin.jourdan@webcraft-studio.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.webcraft-studio.com
 *
 */
// src/Acme/SearchBundle/EventListener/SearchIndexer.php
namespace Webaccess\BugtrackerBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Webaccess\BugtrackerBundle\Entity\User;

class UserPasswordChange
{
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof User) {
            // ... do something with the Product
            // echo $entity->getPassword();
            // die("USER");
        }
    }
}

