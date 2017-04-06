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
        $connection = $database->getConnection();
        $repository = new CommentRepository($connection);

        $allComments = $repository->findAll();

        $this->render(
            'index',
            [
                'comments' => $allComments,
            ]
        );
    }
}
