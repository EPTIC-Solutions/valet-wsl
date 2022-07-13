<?php
if (!empty($_GET['q'])) {
    switch ($_GET['q']) {
        case 'info':
            phpinfo();
            exit;
            break;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Valet WSL</title>

    <link href="https://fonts.googleapis.com/css?family=Inter:400" rel="stylesheet" type="text/css">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            line-height: 1.5;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
            font-weight: 400;
        }

        .opt {
            margin-top: 30px;
        }

        .opt a {
            text-decoration: none;
            font-size: 150%;
        }

        a:hover {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="title" title="Valet">Valet WSL</div>

            <div class="info"><br />
                <?php print($_SERVER['SERVER_SOFTWARE']); ?><br />
                PHP version: <?php print phpversion(); ?> <span><a title="Write out the phpinfo() output" href="/?q=info">phpinfo()</a></span><br />
                Current domain: <code>.<?= $valetConfig['domain'] ?></code><br />
                Current port: <?= $valetConfig['port'] ?><br />
                Sites root: <?= $valetConfig['paths'][0] ?><br />
            </div>
            <div class="opt">
                <div><a title="Getting Started" href="https://github.com/EPTIC-Solutions/valet-wsl/blob/master/readme.md">Getting Started</a></div>
            </div>
        </div>

    </div>
</body>

</html>
