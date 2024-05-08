<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja i Usuwanie Wydatków</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;


    // Obsługa edycji
    if (isset($_GET['action']) && $_GET['action'] === 'edit') {
        $id = $_GET['id'];
        $category_id = $_GET['category_id'];

        // Pobierz dane wydatku do edycji
        $sql = "SELECT Data, Kwota, Opis FROM wydatek WHERE Id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = $row["Data"];
            $kwota = $row["Kwota"];
            $opis = $row["Opis"];

            // Formularz do edycji
            echo "<form action='update.php' method='post'>";
            echo "Data: <input type='date' name='data' value='$data'><br>";
            echo "Kwota: <input type='text' name='kwota' value='$kwota'><br>";
            echo "Opis: <textarea name='opis'>$opis</textarea><br>";
            echo "<input type='hidden' name='id' value='$id'>";
            echo "<input type='hidden' name='category_id' value='$category_id'>";
            echo "<input type='submit' value='Zapisz zmiany'>";
            echo "</form>";
        } else {
            echo "Nie znaleziono danych do edycji.";
        }
    }

    // Obsługa usuwania
    elseif (isset($_GET['action']) && $_GET['action'] === 'delete') {
        $id = $_GET['id'];

        // Usuń wydatek
        $deleteSql = "DELETE FROM wydatek WHERE Id = $id";
        if ($conn->query($deleteSql) === TRUE) {
            echo "Wydatek został usunięty.";
        } else {
            echo "Błąd podczas usuwania wydatku: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>
