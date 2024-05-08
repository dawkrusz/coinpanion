<?php
// Inicjalizacja połączenia z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coinpanion";

$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}

// Sprawdzenie, czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $category_id = $_POST['category_id'];
    $data = $_POST['data'];
    $kwota = $_POST['kwota'];
    $opis = $_POST['opis'];

    // Zaktualizuj dane wydatku
    $updateSql = "UPDATE wydatek SET Data = '$data', Kwota = '$kwota', Opis = '$opis' WHERE Id = $id";

    if ($conn->query($updateSql) === TRUE) {
        echo "Dane wydatku zostały zaktualizowane.";
    } else {
        echo "Błąd podczas aktualizacji danych: " . $conn->error;
    }

    // Przekieruj użytkownika z powrotem na stronę z wydatkami (main.php lub inna)
    header("Location: table.php");
    exit();
}

$conn->close();
?>
