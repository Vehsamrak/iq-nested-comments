<?php

namespace Petr\Comments\Controller;

use Petr\Comments\Core\AbstractController;
use Petr\Comments\Core\Database;
use Petr\Comments\Core\Exception\ValidationError;
use Petr\Comments\Entity\CommentRepository;

/**
 * @author Vehsamrak
 */
class CommentController extends AbstractController
{

    public function addAction(): void
    {
        $commentText = $this->getParameter('text');
        $parentCommentId = $this->getParameter('parentCommentId');

        if (!$commentText) {
        	throw new ValidationError('text');
        }

        $repository = $this->getCommentRepository();

        $result = null;
        if ($parentCommentId) {
            $result = $repository->saveRootComment($commentText);
        } else {
            $result = $repository->saveReplyComment($commentText, $parentCommentId);
        }

        $this->renderJson($result);
    }

    private function getCommentRepository(): CommentRepository
    {
        $database = new Database();

        return new CommentRepository($database->getConnection());
    }
}
