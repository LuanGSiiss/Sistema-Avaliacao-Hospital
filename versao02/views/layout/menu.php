<header class="menu">
    <nav>
        <ul class="menu-lista">
            <li><a href="<?= BASE_URL ?>consultaAvaliacoes">Avaliações</a></li>
            <li><a href="<?= BASE_URL ?>consultaPerguntas">Perguntas</a></li>
        </ul>
    </nav>
</header>

<style>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html {
    font-size: 62.5%;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 1.6rem;
    background-color: #f3f4f6;
    color: #333;
}

/* Menu */
.menu {
    width: 100%;
    background-color: #1f2937; /* cinza escuro */
    color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.menu-lista {
    display: flex;
    list-style: none;
    justify-content: space-around;
    align-items: center;
    padding: 1.5rem 0;
}

.menu-lista li a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    font-size: 1.6rem;
    transition: color 0.3s;
}

.menu-lista li a:hover {
    color: #fbbf24;
}
</style>