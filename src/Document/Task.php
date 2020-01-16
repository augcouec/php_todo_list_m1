<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;

/** @Document(db="php-todo", collection="tasks") */

class Task
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $title;

    /**
     * @MongoDB\Field(type="string")
     */
    private $content;

    /**
     * @MongoDB\Field(type="boolean")
     */
    private $done = false;


    public function getId(): ?string
    {
        return $this->id;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


    public function getDone()
    {
        return $this->done;
    }
    public function setDone($done)
    {
        $this->done = $done;
        return $this;
    }
}
