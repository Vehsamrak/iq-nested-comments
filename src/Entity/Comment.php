<?php

namespace Petr\Comments\Entity;

/**
 * @author Vehsamrak
 */
class Comment
{

    /** @var int */
    private $id;
    /** @var string */
    private $text;
    /** @var int */
    private $level;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
