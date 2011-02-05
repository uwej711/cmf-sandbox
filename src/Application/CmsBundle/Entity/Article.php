<?php

class Article
{
    public $title;

    public $intro;

    public $body;

    public $created_at;

    public $updated_at;

    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime);

        $this->setUpdatedAt(new \DateTime);
    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime);
    }
}
