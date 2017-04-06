<?php

namespace Petr\Comments\Entity;

use Petr\Comments\Core\AbstractRepository;
use Petr\Comments\Core\Exception\EntityNotFound;

/**
 * @author Vehsamrak
 */
class CommentRepository extends AbstractRepository
{

    /**
     * @return Comment|null
     */
    public function findById(int $id)
    {
        $queryResult = $this->connection->prepare('
            SELECT id, text, level, right_key FROM comments c WHERE c.id = :id
        ');

        $queryResult->bindParam('id', $id, \PDO::PARAM_INT);
        $queryResult->execute();
        $queryResult = $queryResult->fetch(\PDO::FETCH_ASSOC);

        return $queryResult
            ? new Comment(
                $queryResult['text'],
                $queryResult['level'],
                $queryResult['right_key'],
                $queryResult['id']
            ) : null;
    }

    public function saveReplyComment(string $commentText, int $parentCommentId)
    {
        $parentComment = $this->findById($parentCommentId);

        if (!$parentComment) {
            throw new EntityNotFound();
        }

        $this->persistComment($commentText, $parentComment->getRightKey(), $parentComment->getLevel());
    }

    public function saveRootComment(string $commentText)
    {
        $level = 0;
        $rightKey = $this->getMaximalRightKey() + 1;

        $this->persistComment($commentText, $rightKey, $level);
    }

    private function getMaximalRightKey(): int
    {
        $queryResult = $this->connection->prepare('
            SELECT MAX(right_key) FROM comments;
        ');

        $queryResult->execute();

        $maximalRightKey = $queryResult->fetch(\PDO::FETCH_COLUMN);

        return (int) $maximalRightKey;
    }

    private function persistComment(string $commentText, int $rightKey, int $level): void
    {
        $queryResults = $this->connection->prepare('
            LOCK TABLE comments WRITE;
            
            UPDATE comments 
            SET right_key = right_key + 2, 
                left_key = IF(left_key > :right_key, left_key + 2, left_key)
            WHERE right_key >= :right_key;
            
            INSERT INTO comments 
                SET left_key = :right_key, 
                    right_key = :right_key + 1, 
                    level = :level + 1,
                    text = :text;
            
            UNLOCK TABLES;
        ');

        $queryResults->bindParam('right_key', $rightKey, \PDO::PARAM_INT);
        $queryResults->bindParam('level', $level, \PDO::PARAM_INT);
        $queryResults->bindParam('text', $commentText, \PDO::PARAM_STR);

        $queryResults->execute();
    }
}
