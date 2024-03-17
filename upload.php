<?php
$target_dir = "images/";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$nazevSouboru = '';

// Check if file is uploaded
if (!empty($_FILES["fileToUpload"]["name"])) {
    // Check if file is an image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Attempt to upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            $nazevSouboru = basename($_FILES["fileToUpload"]["name"]);
            echo '<script>alert("Soubor byl úspěšně nahrán.");</script>';
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Funkce pro smazání obsahu souboru a napsání nového textu
function smazat_a_napsat($file_path, $text) {
    file_put_contents($file_path, ''); // Vymazání obsahu souboru
    file_put_contents($file_path, $text); // Napsání nového textu do souboru
}

// Funkce pro přidání textu na konec existujícího obsahu souboru
function pridat_text($file_path, $text) {
    file_put_contents($file_path, $text, FILE_APPEND); // Přidání textu na konec souboru
}

// Zpracování formuláře
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vyber = $_POST["vyber"] ?? '';
    $nazev = $_POST["nazev"] ?? '';
    $text = $_POST["text"] ?? '';
    $file_path = $vyber . "/main.txt";
    $vyber_psani = $_POST["psani"] ?? '';
    if ($vyber_psani == 'w') {
        smazat_a_napsat($file_path, "<h1>" . htmlspecialchars($nazev) . "</h1>\n" . htmlspecialchars($text));
    } elseif ($vyber_psani == 'a') {
        pridat_text($file_path, "<h1>" . htmlspecialchars($nazev) . "</h1>\n" . htmlspecialchars($text));
    }
    header("Location: /images");
    exit();
}
?>
