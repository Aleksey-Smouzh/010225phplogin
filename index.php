<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>BAZA</title>
</head>
<body>

<?php
//Используется два раза require_once для подключения файлов PHP
    require_once "dane.php";
    //это dane.php, где, вероятно, хранятся данные для подключения к базе данных
?>
<?php
    echo '<link rel="stylesheet" href="style.css">';
?>

<!--  polaczenie do bazy-->
<?php
//Создается подключение к базе данных с использованием класса mysqli. Переменные $serwer, $uzytkownik, $haslo и $baza берутся из файла dane.php, где они определяются.
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
        <!-- Для каждой таблицы создается <option> элемент в выпадающем списке. -->
        <option value="">Wybierz tabelę</option>
        <?php
// В PHP-запросе SHOW TABLES выполняется запрос к базе данных, чтобы получить все её таблицы.
            $zapytanie = "SHOW TABLES";
            $wynik     = $polaczenie->query($zapytanie);
            while ($wiersz = $wynik->fetch_array(MYSQLI_NUM)) {
                $selected = (isset($_REQUEST['table']) && $_REQUEST['table'] == $wiersz[0]) ? "selected" : "";
                echo "<option value='{$wiersz[0]}' $selected>{$wiersz[0]}</option>";
            }
            // Если пользователь уже выбрал таблицу, она будет отображаться как выбранная (опция будет помечена атрибутом selected).
        ?>
    </select>
    <button class="btn" type="submit">Wybierz</button>
</form>

<?php
    if (! empty($_REQUEST['table'])) {
        $table = $_REQUEST['table'];

        // Предотвращаем SQL-инъекцию
        $table = mysqli_real_escape_string($polaczenie, $table);
// Эта функция экранирует специальные символы в названии таблицы.
        // Запрос данных из выбранной таблицы
        $query  = "SELECT * FROM $table";
        // Далее выполняется SQL-запрос для получения всех данных из выбранной таблицы с помощью SELECT * FROM $table.
        $result = $polaczenie->query($query);

        if ($result->num_rows > 0) {
            echo "<h2>Nazwa tabeli: $table</h2>";
            echo "<table border='1'><tr>";

            // Вывод заголовков таблицы
            //Отображаются заголовки колонок таблицы (имена столбцов) с помощью fetch_field(). 
            while ($column = $result->fetch_field()) {
                echo "<th>{$column->name}</th>";
            }
            echo "</tr>";

            // Вывод данных таблицы
            //Отображаются  таблица  с помощью fetch_assoc(). 
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