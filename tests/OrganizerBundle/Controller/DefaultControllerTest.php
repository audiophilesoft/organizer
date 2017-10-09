<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\DailyTask;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $daily = new DailyTask();

    }
}
