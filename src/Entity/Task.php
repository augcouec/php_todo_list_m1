<?php

namespace App\Entity;


use phpDocumentor\Reflection\Types\Boolean;

class Task
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     *
     */
    private $title;

    /**
     * @var string|null
     *
     */
    private $content;

    /**
     * @var Boolean
     *
     */
    private $done = false;




    public function getId(): ?string
    {
        return $this->id;
    }
    public function setId()
    {
        $this->id = uniqid();

        return $this;
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
