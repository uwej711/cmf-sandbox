<?php

namespace Bundle\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    private $client;
    private $dm_already_cleaned = false;

    public function setUp()
    {
        $this->client = $this->createClient();

        if (!$this->dm_already_cleaned) {
            $dm = $this->kernel->getContainer()->get('doctrine.phpcr_odm.document_manager');
            $dm->emptyRepository();
            $this->dm_already_cleaned = true;
        }
    }

    public function testSet()
    {
        $crawler = $this->client->request('GET', '/set/Pippo');

        $this->assertTrue($crawler->filter('html:contains("Ok")')->count() > 0);
    }

    /**
     * @depends testSet
     */
    public function testGet()
    {
        $crawler = $this->client->request('GET', '/get/Pippo');

        $this->assertTrue($crawler->filter('html:contains("Pippo")')->count() > 0);
    }
}