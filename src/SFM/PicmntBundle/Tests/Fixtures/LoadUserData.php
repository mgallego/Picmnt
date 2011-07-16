<?php

/*
 * This file is part of the Liip/FunctionalTestBundle
 *
 * (c) Lukas Kahwe Smith <smith@pooteeweet.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SFM\PicmntBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * @author Lea Haensenberger
 */
class LoadUserData implements FixtureInterface {

    public function load($manager)
    {
      $user = new \SFM\PicmntBundle\Entity\User();

      $user->setUserName('moises');
      $user->setEmail('foo@bar.com');
      // Set according to your security context settings
      $encoder = new MessageDigestPasswordEncoder('sha1', true, 3);
      $user->setPassword($encoder->encodePassword('password2jkjk', $user->getSalt()));
      $user->setAlgorithm('sha1');
      $user->setEnabled(true);
      $user->setConfirmationToken(null);
      $manager->persist($user);

      $manager->flush();

    }
}
