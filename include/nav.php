    <!-- Überschrift/Titel der Seite -->

<nav class = 'navbar'>
    <div class = 'navbar-links'>
        <a href='index.php'><img class = "navbar-icon-backarrow" src="Images/Navbar/back-pfeil.png"></a>
    </div>

    <div class = 'navbar-mitte' onclick='launchFullscreen(document.documentElement);'>
        <div class = 'navbar-title'><?php echo $nameOfStation ?></div>
    </div>

    <div class = 'navbar-rechts' onclick='exitFullscreen();'>
        <img class = "navbar-logo" src="Images/Navbar/Logo.png">
    </div>
</nav>
