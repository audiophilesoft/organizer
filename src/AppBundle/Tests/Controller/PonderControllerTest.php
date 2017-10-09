<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PonderControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/ponder/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(),
            'Unexpected HTTP status code for GET /ponder/');
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'appbundle_ponder[title]'  => 'Test title',
            'appbundle_ponder[details]'  => 'Test details',
            'appbundle_ponder[show]'  => 1
        ));
        $form['appbundle_ponder[show]']->tick();

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test title")')->count(), 'Missing element td:contains("Test title")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test details")')->count(), 'Missing element td:contains("Test details")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Yes")')->count(), 'Missing element td:contains("Yes")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Save')->form(array(
            'appbundle_ponder[title]'  => 'Foo title',
            'appbundle_ponder[details]'  => 'Foo details'
        ));
        $form['appbundle_ponder[show]']->untick();

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Foo title")')->count(), 'Missing element td:contains("Foo title")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Foo details")')->count(), 'Missing element td:contains("Foo details")');
        $this->assertGreaterThan(0, $crawler->filter('td:contains("No")')->count(), 'Missing element td:contains("No")');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }


}
