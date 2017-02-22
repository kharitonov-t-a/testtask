<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Загрузка файла</title>
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <form id="post-form" enctype="multipart/form-data" method="post" action="ajax.php">
        <p>Загрузите ваши фотографии на сервер</p>
        <p><input type="file" name="file" id="file-txt" accept=".txt">
            <input type="submit" value="Start"></p>
    </form>

    <div id="box-images"></div>
</body>
</html>