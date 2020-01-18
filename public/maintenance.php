<?php
header('HTTP/1.1 503 Service Unavailable');
header('Retry-After: 3600');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Maintenance</title>
</head>
<body>
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center">
    <div>
        <img src="/img/logo.png" height="80"/>
    </div>
    <h1>Le site est en cours de maintenance</h1>
</div>
</body>
</html>
