<!DOCTYPE html>

<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIEKARNIA</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<img src="wypieki.png" alt="Produkty naszej piekarni">

<nav>
    <a href="kw1.png">KWERENDA1</a>
    <a href="kw2.png">KWERENDA2</a>
    <a href="kw3.png">KWERENDA3</a>
    <a href="kw4.png">KWERENDA4</a>
</nav>

<header>
    <h1>WITAMY</h1>
    <h4>NA STRONIE PIEKARNI</h4>
    <p>Od 31 lat oferujemy najwyższej jakości pieczywo. Naturalnie świeże, naturalnie smaczne. Pieczemy wyłącznie wypieki na naturalnym zakwasie bez polepszaczy i zagęstników. Korzystamy wyłącznie z najlepszych ziaren pochodzących z ekologicznych upraw położonych w rejonach zgierskim i ozorkowskim.</p>
</header>

<main>
    <h4>Wybierz rodzaj wypieków:</h4>

```
<form method="post" action="piekarnia.php">
    <select name="rodzaj">
        <?php
        $polaczenie = mysqli_connect("localhost", "root", "", "piekarnia");

        $wynik = mysqli_query($polaczenie, "SELECT DISTINCT Rodzaj FROM wyroby ORDER BY Rodzaj DESC");

        while ($wiersz = mysqli_fetch_array($wynik)) {
            $rodzaj = $wiersz['Rodzaj'];
            $wybrany = (isset($_POST['rodzaj']) && $_POST['rodzaj'] == $rodzaj) ? 'selected' : '';
            echo "<option value=\"$rodzaj\" $wybrany>$rodzaj</option>";
        }
        ?>
    </select>
    <button type="submit">Wybierz</button>
</form>

<table>
    <tr>
        <th>Rodzaj</th>
        <th>Nazwa</th>
        <th>Gramatura</th>
        <th>Cena</th>
    </tr>
    <?php
    if (isset($_POST['rodzaj'])) {
        $rodzaj = $_POST['rodzaj'];

        $zapytanie = "SELECT Rodzaj, Nazwa, Gramatura, Cena FROM wyroby WHERE Rodzaj = '$rodzaj'";
        $wynik2 = mysqli_query($polaczenie, $zapytanie);

        while ($wiersz = mysqli_fetch_array($wynik2)) {
            echo "<tr>";
            echo "<td>" . $wiersz['Rodzaj'] . "</td>";
            echo "<td>" . $wiersz['Nazwa'] . "</td>";
            echo "<td>" . $wiersz['Gramatura'] . "</td>";
            echo "<td>" . $wiersz['Cena'] . "</td>";
            echo "</tr>";
        }
    }

    mysqli_close($polaczenie);
    ?>
</table>
```

</main>

<footer>
    <p>AUTOR: 1234567890</p>
    <p>Data: 30.03.2023</p>
</footer>

</body>
</html>