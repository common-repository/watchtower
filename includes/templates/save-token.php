<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php esc_html_e( 'Saving token...', 'watchtower' ); ?></title>
    <meta name="description" content="Saving token...">
</head>

<body>
    <h3><?php esc_html_e( 'Saving token, please wait...', 'watchtower' ); ?></h3>
    <script>
        var tokenWindow = window.self;
        tokenWindow.opener = window.self;
        tokenWindow.close();
    </script>
</body>
</html>