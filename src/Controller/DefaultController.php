<?php

namespace Petr\Comments\Controller;

use Petr\Comments\Core\AbstractController;
use Petr\Comments\Core\Database;
use Petr\Comments\Entity\CommentRepository;

/**
 * @author Vehsamrak
 */
class DefaultController extends AbstractController
{

    public function indexAction(): void
    {
        $repository = $this->getCommentRepository();
        $rootComments = $repository->findRootComments();

        $this->render(
            'index',
            [
                'comments' => $rootComments,
            ]
        );
    }

    private function getCommentRepository(): CommentRepository
    {
        $database = new Database();

        return new CommentRepository($database->getConnection());
    }
}
