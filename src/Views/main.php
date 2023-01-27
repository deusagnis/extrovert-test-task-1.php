<?php

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Extrovert test task 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="container text-center">
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col">
            <h2>Welcome!</h2>
            <p><?php echo('You are logged in as: ' . $this->username) ?></p>
        </div>
        <div class="col-2">
        </div>
    </div>
    <div class="row">

        <div class="col">
            <form class="text-left">
                <a href="?export" target="_blank" type="submit" class="btn btn-primary">Экспортировать сводные данные смарт-процесса</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>