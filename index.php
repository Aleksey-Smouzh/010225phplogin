<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BAZA</title>
</head>
<body>

<?php
require_once "dane.php";
?>
<?php
echo '<link rel="stylesheet" href="style.css">';
?>

<!--  polaczenie do bazy-->
<?php
$polaczenie = new mysqli($serwer, $uzytkownik, $haslo, $baza);
if ($polaczenie) {
    echo "polaczono z baza </br>";

} else {
    echo "brak polaczonia z baza </br>";
}

$polaczenie->set_charset("utf8");
?>
<form action="index.php">
    <label for="database">Wybierz tabelę</label>
    <select name="table" id="database">
        <option value="">-- Wybierz tabelę --</option>
        <?php
       
        $zapytanie = "SHOW TABLES";
        $wynik = $polaczenie->query($zapytanie);
        while ($wiersz = $wynik->fetch_array(MYSQLI_NUM)) {
            $selected = (isset($_REQUEST['table']) && $_REQUEST['table'] == $wiersz[0]) ? "selected" : "";
            echo "<option value='{$wiersz[0]}' $selected>{$wiersz[0]}</option>";
        }
        ?>
    </select>
    <button type="submit">wybrz</button>
</form>

<?php
if (!empty($_REQUEST['table'])) {
    $table = $_REQUEST['table'];
    
    // Предотвращаем SQL-инъекцию
    $table = mysqli_real_escape_string($polaczenie, $table);
    
    // Запрос данных из выбранной таблицы
    $query = "SELECT * FROM $table";
    $result = $polaczenie->query($query);

    if ($result->num_rows > 0) {
        echo "<h2>Zawartość tabeli: $table</h2>";
        echo "<table border='1'><tr>";

        // Вывод заголовков таблицы
        while ($column = $result->fetch_field()) {
            echo "<th>{$column->name}</th>";
        }
        echo "</tr>";

        // Вывод данных таблицы
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Brak danych w tabeli: $table</p>";
    }
}
?>








</body>
</html>