<?php

namespace Petr\Comments\Entity;

/**
 * @author Vehsamrak
 */
class Comment
{

    /** @var string */
    private $id;
    /** @var string */
    private $text;
    /** @var int */
    private $level;
    /** @var int */
    private $leftKey;
    /** @var int */
    private $rightKey;

    public function __construct(string $id, string $text, int $level, int $leftKey, int $rightKey)
    {
        $this->id = $id;
        $this->text = $text;
        $this->level = $level;
        $this->leftKey = $leftKey;
        $this->rightKey = $rightKey;
    }

    public function getId(): string
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

    public function getLeftKey(): int
    {
        return $this->leftKey;
    }

    public function getRightKey(): int
    {
        return $this->rightKey;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function hydrate(): array
    {
        return [
            'id' => $this->getId(),
            'text' => $this->getText(),
            'level' => $this->getLevel(),
        ];
    }
}
