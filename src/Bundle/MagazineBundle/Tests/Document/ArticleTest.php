<?php
namespace Bundle\MagazineBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleTest extends WebTestCase
{
  public function testValidation()
  {
      $this->kernel = $this->createKernel();
      $this->kernel->boot();

      $validator = $this->kernel->getContainer()->get('validator');

      $article = new \Bundle\MagazineBundle\Document\Article();
      $article->title = '1';
      $validation_result = $validator->validate($article);

      $this->assertContains('This value is too short. It should have 3 characters or more', (string)$validation_result);
      $this->assertContains('This value should not be blank', (string)$validation_result);

      $article->title = '123456789012345678901234567890+';
      $validation_result = $validator->validate($article);

      $this->assertContains('This value is too long. It should have 30 characters or less', (string)$validation_result);

      $article->title = 'Min';
      $article->body = 'Not empty';
      $validation_result = $validator->validate($article);

      $this->assertEmpty((string)$validation_result);
  }
}