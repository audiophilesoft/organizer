<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DailyTaskControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'doh2000']);
        $translator = $client->getContainer()->get('translator');


        // Create a new entry in the database
        $crawler = $client->request('GET', '/daily_tasks/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(),
            'Unexpected HTTP status code for GET /daily_tasks/');
        $crawler = $client->click($crawler->selectLink($translator->trans('default.index.create'))->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton($translator->trans('default.new.create'))->form(array(
            'appbundle_dailytask[name]'  => 'Test name',
            'appbundle_dailytask[description]'  => 'Test description',
            'appbundle_dailytask[priority]'  => 1,
            'appbundle_dailytask[time][hour]'  => 12,
            'appbundle_dailytask[time][minute]'  => 05,
            'appbundle_dailytask[length][hour]'  => 0,
            'appbundle_dailytask[length][minute]'  => 10
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test name")')->count(), 'Missing element td:contains("Test name")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test description")')->count(), 'Missing element td:contains("Test description")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("1")')->count(), 'Missing element td:contains("1")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("12:05")')->count(), 'Missing element td:contains("12:05:00")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("00:10")')->count(), 'Missing element td:contains("00:10:00")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink($translator->trans('default.show.edit'))->link());

        $form = $crawler->selectButton($translator->trans('default.edit.save'))->form(array(
            'appbundle_dailytask[name]'  => 'Foo name',
            'appbundle_dailytask[description]'  => 'Foo description',
            'appbundle_dailytask[priority]'  => 2,
            'appbundle_dailytask[time][hour]'  => 13,
            'appbundle_dailytask[time][minute]'  => 15,
            'appbundle_dailytask[length][hour]'  => 1,
            'appbundle_dailytask[length][minute]'  => 15
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Foo name")')->count(), 'Missing element td:contains("Foo name")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Foo description")')->count(), 'Missing element td:contains("Foo description")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("2")')->count(), 'Missing element td:contains("2")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("13:15")')->count(), 'Missing element td:contains("13:15:00")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("01:15")')->count(), 'Missing element td:contains("01:15:00")');

        // Delete the entity
        $client->submit($crawler->selectButton($translator->trans('default.show.delete'))->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo name/', $client->getResponse()->getContent());
    }


}
