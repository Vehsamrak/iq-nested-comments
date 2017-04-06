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
    /** @var int */
    private $rightKey;

    public function __construct(string $text, int $level, int $rightKey, int $id = null)
    {
        $this->id = $id;
        $this->text = $text;
        $this->level = $level;
        $this->rightKey = $rightKey;
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

    public function getRightKey(): int
    {
        return $this->rightKey;
    }
}
