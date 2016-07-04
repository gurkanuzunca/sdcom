<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>SDcom</title>

    <base href="<?php echo Request::baseUrl(); ?>/">

    <?php foreach (Assets::concat('css') as $css): ?>
        <link rel="stylesheet" href="<?php echo $css; ?>">
    <?php endforeach; ?>

    <?php foreach (Assets::js() as $js): ?>
        <script type="text/javascript" src="<?php echo $js; ?>"></script>
    <?php endforeach; ?>



</head>
<body>

    <main>
        <?php include($view) ?>

    </main>
</body>
</html>