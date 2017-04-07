<?php

namespace Petr\Comments\Controller;

use Petr\Comments\Core\AbstractController;
use Petr\Comments\Core\Database;
use Petr\Comments\Core\Exception\ValidationError;
use Petr\Comments\Entity\Comment;
use Petr\Comments\Entity\CommentRepository;

/**
 * @author Vehsamrak
 */
class CommentController extends AbstractController
{

    public function addAction(): void
    {
        $commentText = filter_var($this->getParameter('text'), FILTER_SANITIZE_STRING);
        $parentCommentId = filter_var($this->getParameter('parentCommentId'), FILTER_VALIDATE_INT);

        if (!$commentText) {
        	throw new ValidationError('text');
        }

        $repository = $this->getCommentRepository();

        $result = null;
        if ($parentCommentId) {
            $result = $repository->saveReplyComment($commentText, $parentCommentId);
        } else {
            $result = $repository->saveRootComment($commentText);
        }

        $this->renderJson($result);
    }

    public function listAction(): void
    {
        $parentCommentId = $this->getParameter('parentCommentId');

        if (!$parentCommentId) {
            throw new ValidationError('parentCommentId');
        }

        $repository = $this->getCommentRepository();

        $comments = $repository->findChildComments($parentCommentId);

        $commentsData = array_map(
            function (Comment $comment) {
                return $comment->hydrate();
            },
            $comments
        );

        $this->renderJson($commentsData);
    }

    private function getCommentRepository(): CommentRepository
    {
        $database = new Database();

        return new CommentRepository($database->getConnection());
    }
}
