<?php

namespace Bundle\MagazineBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MagazineControllerTest extends WebTestCase
{
    private $client;
    private $dm_already_cleaned = false;
    private $test_node = '/test';

    public function setUp()
    {
        $this->client = $this->createClient();

        if (!$this->dm_already_cleaned) {
            $dm = $this->kernel->getContainer()->get('doctrine.phpcr_odm.document_manager');
            $article = $dm->find('Bundle\MagazineBundle\Document\Article', $this->test_node);

            try {
              $dm->remove($article);
              $dm->flush();
            }
            catch (\Exception $e) {
              // no test node present
            }
            
            $article = new \Bundle\MagazineBundle\Document\Article();
            $dm->persist($article, $this->test_node);
            $dm->flush();

            $this->dm_already_cleaned = true;
        }
    }

    public function testNew()
    {
        $crawler = $this->client->request('GET', '/new');
        $form = $crawler->filter('form')->selectButton('Save')->form();

        $form['article[title]'] = 'Pippo';
        $form['article[body]'] = 'Contenuto dell\'articolo';
        $form['article[path]'] = $this->test_node;

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('h1:contains("Pippo")')->count() > 0);
        $this->assertTrue($crawler->filter('p:contains("Contenuto dell\'articolo")')->count() > 0);
    }

    /**
     * @depends testNew
     */
    public function testGet()
    {
        $crawler = $this->client->request('GET', '/get/Pippo');

        $this->assertTrue($crawler->filter('html:contains("Pippo")')->count() > 0);
    }
}