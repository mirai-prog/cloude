#1. 
```sql
-- Tworzymy bazy
CREATE DATABASE IF NOT EXISTS hurtownia;
CREATE DATABASE IF NOT EXISTS firma;

-- Tworzymy przykładowe tabele
USE hurtownia;

CREATE TABLE IF NOT EXISTS towary (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nazwa VARCHAR(100),
    cena DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS zamowienia (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_towaru INT,
    ilosc INT
);

-- Przykładowe dane (opcjonalnie)
INSERT INTO towary (nazwa, cena) VALUES 
('Młotek', 25.50),
('Śrubokręt', 12.00),
('Piła', 45.90);

USE firma;

CREATE TABLE IF NOT EXISTS pracownicy (
    id INT PRIMARY KEY AUTO_INCREMENT,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);
```

#2. 
## 1. Tworzenie użytkowników

```sql
-- 1. Użytkownik bez hosta
CREATE USER sosna;

-- 2. Użytkownik tylko z localhost
CREATE USER brzoza@localhost;

-- 3. Użytkownik z hasłem
CREATE USER wierzba@localhost IDENTIFIED BY 'drzewa';

-- 4. Kolejny użytkownik z hasłem
CREATE USER modrzew@localhost IDENTIFIED BY 'las';
```

### Sprawdzenie utworzonych użytkowników

```sql
SELECT user, host, authentication_string 
FROM mysql.user 
WHERE user IN ('sosna', 'brzoza', 'wierzba', 'modrzew');
```

---

## 2. Nadawanie uprawnień

```sql
-- Wszystkie uprawnienia dla brzoza
GRANT ALL ON *.* TO brzoza@localhost;

-- Wszystkie uprawnienia dla wierzba (z hasłem)
GRANT ALL ON *.* TO wierzba@localhost IDENTIFIED BY 'drzewa';

-- Tylko baza firma dla modrzew
GRANT ALL ON firma.* TO modrzew@localhost IDENTIFIED BY 'las';

-- Tylko tabela towary w bazie hurtownia dla sosna
GRANT ALL ON hurtownia.towary TO sosna@localhost;
```

---

## 3. Uprawnienia z możliwością nadawania innym (GRANT OPTION)

```sql
GRANT ALL ON *.* TO wierzba@localhost 
IDENTIFIED BY 'drzewa' 
WITH GRANT OPTION;
```

### Jako użytkownik `wierzba` (w drugim oknie):

```sql
GRANT SELECT ON hurtownia.towary TO modrzew@localhost;
```

---

## 4. Odbieranie uprawnień

```sql
-- Odebranie SELECT z tabeli towary użytkownikowi modrzew
REVOKE SELECT ON hurtownia.towary FROM modrzew@localhost;

-- Odebranie wszystkich uprawnień + GRANT OPTION użytkownikowi wierzba
REVOKE ALL, GRANT OPTION FROM wierzba@localhost;
```

### Sprawdzenie uprawnień

```sql
SHOW GRANTS FOR wierzba@localhost;
SHOW GRANTS FOR brzoza@localhost;
SHOW GRANTS FOR modrzew@localhost;
SHOW GRANTS FOR sosna@localhost;
```

---

## 5. Usuwanie użytkowników

```sql
-- Usunięcie użytkownika bez hosta
DROP USER sosna;

-- Usunięcie użytkownika z hostem
DROP USER brzoza@localhost;
```

---

## 6. Zmiana nazwy użytkownika

```sql
-- Tworzymy nowego użytkownika
CREATE USER grab;

-- Nadajemy mu uprawnienia
GRANT ALL ON firma.* TO grab;

-- Zmieniamy nazwę
RENAME USER grab TO klon;

-- Zmiana nazwy użytkownika z hostem
RENAME USER modrzew@localhost TO cis@localhost;
```

---

## 7. (Opcjonalnie) Tymczasowe zablokowanie użytkownika

```sql
-- Usunięcie z tabeli user (uprawnienia zostają)
DELETE FROM mysql.user WHERE user = 'nazwa_użytkownika';
FLUSH PRIVILEGES;
```

---

## Ściągawka składni

| Polecenie | Znaczenie |
|-----------|---------|
| `CREATE USER user[@host] [IDENTIFIED BY 'hasło']` | Tworzenie użytkownika |
| `DROP USER user[@host]` | Usuwanie użytkownika |
| `GRANT przywilej ON obiekt TO user[@host] [IDENTIFIED BY 'hasło'] [WITH GRANT OPTION]` | Nadawanie uprawnień |
| `REVOKE przywilej ON obiekt FROM user[@host]` | Odbieranie uprawnień |
| `REVOKE ALL, GRANT OPTION FROM user[@host]` | Odebranie wszystkiego |
| `RENAME USER stary TO nowy` | Zmiana nazwy |
| `SHOW GRANTS FOR user[@host]` | Sprawdzenie uprawnień |

---

## Najważniejsze przywileje

| Przywilej | Znaczenie |
|-----------|---------|
| `ALL` | Wszystkie uprawnienia (oprócz nadawania innym) |
| `SELECT` | Odczyt danych |
| `INSERT` | Wstawianie danych |
| `UPDATE` | Modyfikacja danych |
| `DELETE` | Usuwanie danych |
| `CREATE` | Tworzenie baz i tabel |
| `DROP` | Usuwanie baz, tabel i widoków |
| `ALTER` | Modyfikacja struktury tabel |
| `GRANT OPTION` | Możliwość nadawania uprawnień innym |
| `USAGE` | Brak uprawnień |

---

*Plik przygotowany na podstawie ćwiczeń: Administrowanie użytkownikami bazy danych*






