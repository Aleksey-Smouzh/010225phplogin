<?php
$serwer = "localhost";
$uzytkownik = "user";
$haslo = "1234567890";
$baza = "infprog21";

function wyswietl_tabele($tabela, $plik){

    echo "<h3>6</h3>";

    $wynik = $polaczenie->query($zapytanie);
    
    echo "<table border = '15'>";
    $wiersz = $wynik->fetch_array(MYSQLI_ASSOC);
    // nazwa kolumny
    echo "<tr>";
    $kolumny = array_keys($wiersz);
    echo "<th>LP</th>";
    $licznik = 1;
    for ($i = 0; $i < count($kolumny); $i++) {
        echo "<th>$kolumny[$i]</th>";
    
    }
    echo "</tr>";
    // wartosti
    do {
        echo "<tr>";
        echo "<td>$licznik</td>";
        foreach ($wiersz as $wartosc) {
            echo "<td>" . $wartosc . "</td>";
        }
    
        echo "</tr>";
    
        $licznik++;
    } while ($wiersz = $wynik->fetch_array(MYSQLI_ASSOC));
    
    echo "</table>";
}

?>