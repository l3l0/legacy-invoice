<?php

declare (strict_types = 1);

namespace Tests\L3l0Labs;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DoctrineTestCase extends KernelTestCase
{
    public function setUp()
    {
        parent::setUp();
        parent::bootKernel();

        (new ORMPurger($this->get('doctrine.orm.default_entity_manager')))->purge();
    }

    protected function get(string $service)
    {
        return self::$kernel->getContainer()->get($service);
    }
}