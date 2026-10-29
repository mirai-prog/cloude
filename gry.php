<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Gry komputerowe</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <?php
    // Połączenie z bazą danych - wspólne dla wszystkich skryptów
    $polaczenie = mysqli_connect("localhost", "root", "", "gry");
    if (!$polaczenie) {
        die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
    }
    mysqli_set_charset($polaczenie, "utf8");
    ?>

    <header>
        <h1>Ranking gier komputerowych</h1>
    </header>

    <div class="container">
        <!-- Sekcja lewa (aside) -->
        <aside class="lewa">
            <h3>Top 5 gier w tym miesiącu</h3>
            <ul>
                <?php
                // Skrypt 1 - zapytanie 3
                $zapytanie1 = "SELECT nazwa, punkty FROM gry ORDER BY punkty DESC LIMIT 5";
                $wynik1 = mysqli_query($polaczenie, $zapytanie1);
                if ($wynik1) {
                    while ($wiersz = mysqli_fetch_array($wynik1)) {
                        echo "<li>" . htmlspecialchars($wiersz['nazwa']) . " <span class=\"punkty\">" . $wiersz['punkty'] . "</span></li>";
                    }
                }
                ?>
            </ul>

            <h3>Nasz sklep</h3>
            <a href="http://sklep.gry.pl">Tu kupisz gry</a>

            <h3>Stronę wykonałem</h3>
            <p>12345678901</p> <!-- ZAMIEŃ NA SWÓJ NUMER PESEL / NUMER ZDAJĄCEGO -->
        </aside>

        <!-- Sekcja środkowa (main) -->
        <main>
            <?php
            // Skrypt 2 - zapytanie 1
            $zapytanie2 = "SELECT id, nazwa, zdjecie FROM gry";
            $wynik2 = mysqli_query($polaczenie, $zapytanie2);
            if ($wynik2) {
                while ($wiersz = mysqli_fetch_array($wynik2)) {
                    echo '<div class="gra">';
                    echo '<img src="' . htmlspecialchars($wiersz['zdjecie']) . '" alt="' . htmlspecialchars($wiersz['nazwa']) . '" title="' . $wiersz['id'] . '">';
                    echo '<p>' . htmlspecialchars($wiersz['nazwa']) . '</p>';
                    echo '</div>';
                }
            }
            ?>
        </main>

        <!-- Sekcja prawa (aside) -->
        <aside class="prawa">
            <h3>Dodaj nową grę</h3>
            <form method="post" action="">
                <label for="nazwa">nazwa</label>
                <input type="text" id="nazwa" name="nazwa"><br>
                <label for="opis">opis</label>
                <textarea id="opis" name="opis" rows="3" cols="20"></textarea><br>
                <label for="cena">cena</label>
                <input type="text" id="cena" name="cena"><br>
                <label for="zdjecie">zdjęcie</label>
                <input type="text" id="zdjecie" name="zdjecie"><br>
                <input type="submit" name="dodaj" value="DODAJ">
            </form>

            <?php
            // Skrypt 4 - związany z formularzem z sekcji prawej
            if (isset($_POST['dodaj']) && !empty($_POST['nazwa'])) {
                $nazwa = mysqli_real_escape_string($polaczenie, $_POST['nazwa']);
                $opis = mysqli_real_escape_string($polaczenie, isset($_POST['opis']) ? $_POST['opis'] : '');
                $cena = isset($_POST['cena']) ? floatval(str_replace(',', '.', $_POST['cena'])) : 0;
                $zdjecie = mysqli_real_escape_string($polaczenie, isset($_POST['zdjecie']) ? $_POST['zdjecie'] : '');
                $punkty = 0;

                $zapytanie4 = "INSERT INTO gry (nazwa, opis, punkty, cena, zdjecie) VALUES ('$nazwa', '$opis', $punkty, $cena, '$zdjecie')";
                if (mysqli_query($polaczenie, $zapytanie4)) {
                    echo "<p style='color: lime;'>Dodano nową grę pomyślnie!</p>";
                    echo "<meta http-equiv='refresh' content='1'>";
                } else {
                    echo "<p>Błąd dodawania: " . mysqli_error($polaczenie) . "</p>";
                }
            }
            ?>
        </aside>
    </div>

    <footer>
        <form method="post" action="">
            <input type="text" name="id_gry" placeholder="Wpisz id gry">
            <input type="submit" name="pokaz" value="Pokaż opis">
        </form>

        <?php
        // Skrypt 3 - związany z formularzem w stopce
        if (isset($_POST['pokaz']) && !empty($_POST['id_gry'])) {
            $id = intval($_POST['id_gry']);
            // Zmodyfikowane zapytanie 2 - wybiera wiersz o podanym id
            $zapytanie3 = "SELECT nazwa, LEFT(opis, 100) AS opis_skrot, punkty, cena FROM gry WHERE id = $id";
            $wynik3 = mysqli_query($polaczenie, $zapytanie3);
            if ($wynik3 && $wiersz = mysqli_fetch_array($wynik3)) {
                echo "<h2>" . htmlspecialchars($wiersz['nazwa']) . ", " . $wiersz['punkty'] . " punktów, " . $wiersz['cena'] . " zł</h2>";
                echo "<p>" . htmlspecialchars($wiersz['opis_skrot']) . "</p>";
            } else {
                echo "<p>Nie znaleziono gry o id = $id</p>";
            }
        }

        // Zamknięcie połączenia na końcu (wymóg zadania)
        mysqli_close($polaczenie);
        ?>
    </footer>
</body>
</html>