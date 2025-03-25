<nav>
    <a href="index.php">Startseite</a><br>
    <a href="produkte.php">Produkte</a><br>
    <?php if (isset($_SESSION['eingeloggt'])) { ?>
    <a href="warenkorb.php">Warenkorb</a><br>
    <?php } ?>
    <a href="ueber-uns.php">Über uns</a><br>
    <a href="kontakt.php">Kontakt</a><br>
</nav>
