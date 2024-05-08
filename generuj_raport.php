<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

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
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_SESSION["user_id"];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $category = $_GET['category'];

    // Tutaj możesz wykonać odpowiednie zapytanie do bazy danych i wygenerować raport
    $sql = "SELECT * FROM wydatek WHERE Id_Uzytkownik = $user_id AND Data BETWEEN '$start_date' AND '$end_date' AND Kategoria = '$category'";
    $result = $conn->query($sql);

    // Dalsza obsługa generowania raportu...
    if ($result->num_rows > 0) {
        // Generowanie pliku CSV
        $file = fopen("raport.csv", "w");

        // Nagłówki pliku CSV
        fputcsv($file, array('Data', 'Kwota', 'Kategoria', 'Opis'));

        while ($row = $result->fetch_assoc()) {
            // Dodanie danych do pliku CSV
            fputcsv($file, array($row["Data"], $row["Kwota"], $row["Kategoria"], $row["Opis"]));
        }

        fclose($file);

        // Przekierowanie do pobranego pliku CSV
        header('Location: raport.csv');
        exit();
    } else {
        echo "<div class='no-data-message'>Brak danych spełniających kryteria</div>";
    }
} else {
    // Przekieruj użytkownika z powrotem na stronę raportu w razie próby dostępu bez przesłania formularza
    header("Location: raport.php");
    exit();
}

$conn->close();
?>
