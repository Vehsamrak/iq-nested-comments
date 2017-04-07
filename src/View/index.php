<?php /** @var \Petr\Comments\Entity\Comment[] $comments */ ?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nested Comments</title>
</head>
<body>
    <h1>Comments list</h1>
    <?php foreach ($comments as $comment) { ?>
        <?php for ($i = 0; $i < $comment->getLevel();$i++) { echo '<span style="display: inline-block;width: 30px;background-color: red;height: 10px"></span>'; } ?>
        [<?= $comment->getId() ?>] <?= $comment->getText() ?>
        <br>
    <?php } ?>
</body>
</html>
