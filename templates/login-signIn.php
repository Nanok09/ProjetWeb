
<div id="container">
    <!-- Connexion -->
    <h1>Connexion</h1>
    <form id="connexion" action="controleur.php">
        <input type="text" name="pseudo" placeholder="username"/>
        <input type="password" name="password" placeholder="password"/>
        <input type="checkbox" name="ResterCo" />
        <label for="ResterCo">Rester connecté</label>
        <input type="submit" name="action" value="Se connecter"/>
    </form>

    <!-- Inscription -->
    <h1>Inscription</h1>
    <form id="inscription" action="controleur.php">
        <input type="email" placeholder="email"/>
        <input type="text" placeholder="username"/>
        <input type="password" placeholder="password"/>
        <input type="submit" name="action" value="S'inscrire"/>
    </form>
</div>


