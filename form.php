<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
    <title>Document</title>
</head>

<body class="container">
    <main>
        <h1>Uploader la photo de Homer</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            // Securité en php
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . uniqid() . '_' . basename($_FILES['avatar']['name']);
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $authorizedExtensions = ['jpg', 'jpeg', 'png'];
            $maxFileSize = 1000000;
            $errors = array();

            // Vérifie si l'extension est autorisée
            if (!in_array($extension, $authorizedExtensions)) {
                $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
            }

            // Vérifie si l'image existe et si le poids est autorisé en octets
            if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
                $errors[] = "Votre fichier doit faire moins de 1 Mo !";
            }

            // Si je n'ai pas d'erreur alors j'upload
            if (empty($errors)) {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
                echo "<p>Photo uploadée avec succès.</p>";
            }

            // Affiche les messages d'erreur s'il y en a
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
            }
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="avatar">Choisir une photo :</label>
            <input type="file" name="avatar" id="avatar" required>
            <br>
            <input type="submit" name="submit" value="Envoyer">
        </form>
    </main>
</body>

</html>
