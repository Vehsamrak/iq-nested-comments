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
    public function findById(string $id)
    {
        $queryResult = $this->connection->prepare('
            SELECT id, text, level, left_key, right_key FROM comments WHERE id = :id
        ');

        $queryResult->bindParam('id', $id, \PDO::PARAM_INT);
        $queryResult->execute();
        $queryResult = $queryResult->fetch(\PDO::FETCH_ASSOC);

        return $queryResult
            ? new Comment(
                $queryResult['id'],
                $queryResult['text'],
                $queryResult['level'],
                $queryResult['left_key'],
                $queryResult['right_key']
            ) : null;
    }

    /**
     * @return Comment[]
     */
    public function findRootComments(): array
    {
        $queryResult = $this->connection->prepare('
            SELECT id, text, level, left_key, right_key FROM comments WHERE level = 1 ORDER BY left_key
        ');

        $queryResult->execute();
        $commentsData = $queryResult->fetchAll(\PDO::FETCH_ASSOC);

        $comments = [];
        foreach ($commentsData as $commentData) {
            $comments[] = new Comment(
                $commentData['id'],
                $commentData['text'],
                $commentData['level'],
                $commentData['left_key'],
                $commentData['right_key']
            );
        }

        return $comments;
    }

    /**
     * @return Comment[]
     * @throws EntityNotFound
     */
    public function findChildComments(string $parentCommentId)
    {
        $parentComment = $this->findById($parentCommentId);

        if (!$parentComment) {
            throw new EntityNotFound();
        }

        $queryResult = $this->connection->prepare('
            SELECT id, text, level, left_key, right_key FROM comments
            WHERE left_key >= :left_key 
              AND right_key <= :right_key 
              AND level > :level 
            ORDER BY left_key
        ');

        $leftKey = $parentComment->getLeftKey();
        $rightKey = $parentComment->getRightKey();
        $level = $parentComment->getLevel();

        $queryResult->bindParam('left_key', $leftKey, \PDO::PARAM_INT);
        $queryResult->bindParam('right_key', $rightKey, \PDO::PARAM_INT);
        $queryResult->bindParam('level', $level, \PDO::PARAM_INT);
        $queryResult->execute();
        $commentsData = $queryResult->fetchAll(\PDO::FETCH_ASSOC);

        $comments = [];
        foreach ($commentsData as $commentData) {
            $comments[] = new Comment(
                $commentData['id'],
                $commentData['text'],
                $commentData['level'],
                $commentData['left_key'],
                $commentData['right_key']
            );
        }

        return $comments;
    }

    public function saveReplyComment(string $commentText, string $parentCommentId): string
    {
        $parentComment = $this->findById($parentCommentId);

        if (!$parentComment) {
            throw new EntityNotFound();
        }

        return $this->persistComment($commentText, $parentComment->getRightKey(), $parentComment->getLevel());
    }

    public function saveRootComment(string $commentText): string
    {
        $level = 0;
        $rightKey = $this->getMaximalRightKey() + 1;

        return $this->persistComment($commentText, $rightKey, $level);
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

    private function persistComment(string $commentText, int $rightKey, int $level): string
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
                    id = :id,
                    text = :text;
            
            UNLOCK TABLES;
        ');

        $id = $this->idGenerator->generateRandomId();

        $queryResults->bindParam('right_key', $rightKey, \PDO::PARAM_INT);
        $queryResults->bindParam('level', $level, \PDO::PARAM_INT);
        $queryResults->bindParam('text', $commentText, \PDO::PARAM_STR);
        $queryResults->bindParam('id', $id, \PDO::PARAM_STR);

        $queryResults->execute();

        return $id;
    }
}
