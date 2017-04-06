<?php

namespace Petr\Comments\Entity;

use Petr\Comments\Core\AbstractRepository;

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
        $queryResult = $this->connection->prepare("SELECT id, text, level FROM comments c WHERE c.id = :id");
        $queryResult->bindParam('id', $id, \PDO::PARAM_INT);
        $queryResult->execute();
        $queryResult = $queryResult->fetch(\PDO::FETCH_ASSOC);

        return $queryResult
            ? new Comment($queryResult['id'], $queryResult['text'], $queryResult['level'])
            : null;
    }
}
