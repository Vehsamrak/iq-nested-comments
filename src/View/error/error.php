<?php /** @var \Exception $exception */ ?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Error occured!</title>
</head>
<body>
<h2>Error occured!</h2>
<p><?= sprintf('%s (%s)', $exception->getMessage(), $exception->getCode()) ?></p>
</body>
</html>
