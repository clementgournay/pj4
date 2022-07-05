<html>
<head>
    <meta charset="UTF-8">
    <title>Logs</title>
    <style>
        body {
            background: whitesmoke;
            padding: 2rem;
        }

        h1 {
            text-align: center;
        }
        .info {
            font-style: italic;
            color: grey;
        }
    </style>
</head>
<body>
    <h1>Logs</h1>
    <p class="info">La page est rafraichie toutes les 10 secondes.</p>
    <?php 
    date_default_timezone_set('Europe/Paris');
    $log_path = './'.date('Y').'/'.date('m').'/'.date('d').'.log';

    if (is_file($log_path)) {
        $log = file_get_contents($log_path);
        $log = explode('\r\n', $log);
        foreach($log as $line) {
            echo $line.'<br>';
        }
    } else {
        echo '<p>Pas de logs pour aujourd\'hui.</p>';
    }
    ?>
    <script>
        setTimeout(function () {
            window.location.reload();
        }, 10000);
    </script>
</body>
</html>

