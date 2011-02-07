<?php

namespace Bundle\MagazineBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleCrudTest extends WebTestCase
{
    private $client;
    private $dm_already_cleaned = false;
    private $test_node = '/test';

    public function setUp()
    {
        $this->client = $this->createClient();

        if (!$this->dm_already_cleaned) {
            $dm = $this->kernel->getContainer()->get('doctrine.phpcr_odm.document_manager');
            $folder = $dm->find('Bundle\MagazineBundle\Document\Folder', $this->test_node);

            try {
              $dm->remove($folder);
              $dm->flush();
            }
            catch (\Exception $e) {
              // no test node present
            }
            
            $folder = new \Bundle\MagazineBundle\Document\Folder();
            $dm->persist($folder, $this->test_node);
            $dm->flush();

            $this->dm_already_cleaned = true;
        }
    }

    public function testNewValidation()
    {
        $crawler = $this->client->request('GET', '/new');
        $form = $crawler->filter('form')->selectButton('Save')->form();

        $form['article[title]'] = '1';
        $form['article[body]'] = 'Contenuto dell\'articolo';
        $form['article[path]'] = $this->test_node;

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('li:contains("This value is too short. It should have 3 characters or more")')->count() > 0);
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