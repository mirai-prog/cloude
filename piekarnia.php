<?php
$conn = mysqli_connect("localhost", "root", "", "biblioteka");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['imie'])) {
    $imie     = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $rok      = $_POST['rok_urodzenia'];

    $kod = strtolower(substr($imie, 0, 2) . substr($rok, -2) . substr($nazwisko, 0, 2));

    mysqli_query($conn, "INSERT INTO czytelnicy (imie, nazwisko, kod) VALUES ('$imie', '$nazwisko', '$kod')");

    echo "<p>Czytelnik: $nazwisko został dodany do bazy danych</p>";
}
?>

<!DOCTYPE html>

<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Biblioteka publiczna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section id="baner">
    <h2>Miejska Biblioteka Publiczna w Książkowicach</h2>
</section>

<section id="srodek">

```
<section id="lewy">
    <h2>Dodaj czytelnika</h2>
    <form method="post" action="biblioteka.php">
        imię: <input type="text" name="imie"><br>
        nazwisko: <input type="text" name="nazwisko"><br>
        rok urodzenia: <input type="number" name="rok_urodzenia"><br>
        <input type="submit" value="DODAJ">
    </form>
</section>

<section id="srodkowy">
    <img src="biblioteka.png" alt="biblioteka">
    <h4>ul. Czytelnicza 25<br>
        12-120 Książkowice<br>
        tel.: 123123123<br>
        e-mail: <a href="mailto:biuro@bib.pl">biuro@bib.pl</a>
    </h4>
</section>

<section id="prawy">
    <h3>Nasi czytelnicy:</h3>
    <ul>
    <?php
    $wynik = mysqli_query($conn, "SELECT imie, nazwisko FROM czytelnicy");
    while ($row = mysqli_fetch_array($wynik)) {
        echo "<li>" . $row['imie'] . " " . $row['nazwisko'] . "</li>";
    }
    ?>
    </ul>
</section>
```

</section>

<section id="stopka">
    <p>Projekt witryny: 11223344555</p>
</section>

</body>
</html>
<?php
mysqli_close($conn);
?>