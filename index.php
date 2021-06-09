<?php

@mkdir('./upload', 0644);

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = $_POST['filename'];
    $uploadedFile = $_FILES['uploaded_file'];
    $authorizedMimeTypes = explode(',', $_POST['authorized_mime_types']);

    if (!in_array($uploadedFile['type'], $authorizedMimeTypes)) {
        $message = 'Type de fichier non supporté';
    } else {
        move_uploaded_file(
            $uploadedFile['tmp_name'],
            sprintf('./upload/%s', $filename)
        );

        $message = 'Upload réussi';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Upload de fichier</title>
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
            <?= $message ? sprintf('<p>%s</p>', $message) : '' ?>
            <label>
                Nom de l'image
                <input type="text" name="filename">
            </label>
            <label>
                Fichier à télécharger
                <input type="file" name="uploaded_file">
            </label>
            <label>
                <input type="hidden" name="authorized_mime_types" value="image/png,image/jpeg,image/gif">
            </label>
            <input type="submit" value="Envoyer">
        </form>
    </body>
</html>
