

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje Wydatki</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body id="spending-page">
    <?php
        session_start();
        if (!isset($_SESSION["user_id"])) {
            echo '<div class="unauthorized-message">Nieautoryzowany dostęp, przenoszę na stronę główną...</div>';
            header("Refresh: 3; URL=index.html");
            exit();
        } 
        
        $user_id = $_SESSION["user_id"];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "coinpanion";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Połączenie nieudane: " . $conn->connect_error);
        }

        $sql = "SELECT Data, Kwota, Nazwa AS Kategoria, Opis FROM wydatek 
                JOIN kategoria ON wydatek.Id_Kategoria = kategoria.Id
                WHERE Id_Uzytkownik = $user_id";

        $result = $conn->query($sql);
    ?>

    <header>
        <a href="main.php"><img src="images/backtomenu.png" alt="Powrót do menu"></a>
        <input type="text" class="filtr-input" placeholder="Wyszukaj wg kategorii">
        <button class="button-primary button-spending">NOWY WYDATEK</button>
    </header>
    
    <main id="main-content">
        <table class="table-spending">
            <thead>
                <tr>
                    <th style="width: 15%">Data</th>
                    <th style="width: 20%">Kwota</th>
                    <th style="width: 20%">Kategoria</th>
                    <th style="width: 30%">Opis</th>
                    <th style="width: 15%">Dodaj/Usuń</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Sprawdzenie, czy zapytanie zwróciło wyniki
                    if ($result->num_rows > 0) {
                        // Wyświetlanie danych w tabeli HTML
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["Data"] . "</td>";
                            echo "<td>" . $row["Kwota"] . "</td>";
                            echo "<td>" . $row["Kategoria"] . "</td>";
                            echo "<td>" . $row["Opis"] . "</td>";
                            echo "<td>
                            <a href='update.php?id=" . $row["Id"] . "'><img src='images/edit.png' alt='Edytuj'></a>
                            <a href='edit_delete.php?id=" . $row["Id"] . "'><img src='images/delete.png' alt='Usuń'></a>
                             </td>";
                    echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Brak danych</td></tr>";
                    }

                    $conn->close();
                ?>
            </tbody>
        </table>

        <aside>
            <table class="table-categories">
                <tr>
                    <th>KATEGORIE</th>
                    <th><a href=""><img src="images/plus.png" alt="Dodaj kategorie"></a></th>
                </tr>
                <tr>
                    <td>kategoria</td>
                    <td>
                        <a href="edit_delete.php?action=edit&id=<?php echo $row['Id']; ?>&category_id=<?php echo $row['Id_Kategoria']; ?>"><img src="images/edit.png" alt="Edytuj"></a>
                        <a href="edit_delete.php?action=delete&id=<?php echo $row['Id']; ?>"><img src="images/delete.png" alt="Usuń"></a>
                    </td>
                </tr>
            </table>
        </aside>
    </main>

    <footer>Coinpanion©</footer>
</body>
</html>
