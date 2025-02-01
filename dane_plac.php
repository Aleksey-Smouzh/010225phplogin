<?php
require_once "dane.php";

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

// $zapytanie = "SELECT * FROM `imiona` ";
// "SELECT * FROM `imiona`, `w_pracownicy` WHERE 1 ORDER BY `w_pracownicy`.`NAZWISKO` DESC;";

$zapytanie =  "SELECT `ID`, `NAZWISKO`, `ID_STANOWISKA`, `PREMIA`, `DODATEK` FROM `pracownicy` WHERE 1;";


$wynik = $polaczenie->query($zapytanie);

$ile = mysqli_num_rows($wynik);
echo "pobrano $ile werszy <br>";
// wyswietl_tabele($wynik);


$polaczenie->close();
?>