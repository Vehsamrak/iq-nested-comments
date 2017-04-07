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

    public function indexAction()
    {
        $database = new Database();
        $repository = new CommentRepository($database->getConnection());

        $rootComments = $repository->findRootComments();

        $this->render(
            'index',
            [
                'comments' => $rootComments,
            ]
        );
    }
}
