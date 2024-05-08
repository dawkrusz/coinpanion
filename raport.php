<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raporty</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION["user_id"])) {
            echo '<div class="unauthorized-message">Nieautoryzowany dostęp, przenoszę na stronę główną...</div>';
            header("Refresh: 3; URL=index.html");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['start-date'], $_GET['end-date'], $_GET['category'])) {
            $user_id = $_SESSION["user_id"];
            $start_date = $_GET['start-date'];
            $end_date = $_GET['end-date'];
            $selected_category = $_GET['category'];

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
                    WHERE Id_Uzytkownik = $user_id
                    AND Data BETWEEN '$start_date' AND '$end_date'
                    AND Nazwa = '$selected_category'";

            $result = $conn->query($sql);

            echo "<main>";
            echo "<div class='div-raport1'>";
            echo "<a href='main.php'><img src='images/backtomenu.png' alt='Powrót do menu' style='padding: 20px;'></a>";
            echo "<form class='form-raport' method='get' action=''>";
            echo "<div class='input-group'>";
            echo "<label for='start-date'>Data początkowa</label>";
            echo "<input id='start-date' name='start-date' type='date' class='login-input raport-date-start' required value='$start_date'>";
            echo "<label for='end-date'>Data końcowa</label>";
            echo "<input id='end-date' name='end-date' type='date' class='login-input raport-date-end' required value='$end_date'>";
            echo "</div>";
            echo "<select name='category' class='category-select'>";
            echo "<option value='' selected disabled hidden>Wybierz kategorię</option>";
            echo "<option value='kategoria1' " . ($selected_category === 'kategoria1' ? 'selected' : '') . ">Kategoria 1</option>";
            echo "<option value='kategoria2' " . ($selected_category === 'kategoria2' ? 'selected' : '') . ">Kategoria 2</option>";
            echo "<option value='kategoria3' " . ($selected_category === 'kategoria3' ? 'selected' : '') . ">Kategoria 3</option>";
            echo "</select>";
            echo "<input type='submit' value='Generuj raport'>";
            echo "<a href='generuj_raport.php?start_date=$start_date&end_date=$end_date&category=$selected_category' target='_blank' class='download-link'>Pobierz raport</a>";
            echo "</form>";
            echo "</div>";

            // Wyświetlanie wyników
            if ($result->num_rows > 0) {
                echo "<table class='table-raport'>";
                echo "<thead>
                        <tr>
                            <th>Data</th>
                            <th>Kwota</th>
                            <th>Kategoria</th>
                            <th>Opis</th>
                        </tr>
                    </thead>";
                echo "<tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Data"] . "</td>";
                    echo "<td>" . $row["Kwota"] . "</td>";
                    echo "<td>" . $row["Kategoria"] . "</td>";
                    echo "<td>" . $row["Opis"] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<div class='no-data-message'>Brak danych spełniających kryteria</div>";
            }

            echo "</main>";
            $conn->close();
        }
    ?>
    <footer>Coinpanion©</footer>
</body>
</html>