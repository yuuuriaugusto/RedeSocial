<?php // views/home.php ?>

// ... (código HTML inicial)

<h1>Página Inicial</h1>

<?php if (isset($_SESSION['usuario_id'])): ?>
    <form method="POST" action="/criar-post"> 
        <textarea name="texto" placeholder="Digite seu post aqui..."></textarea>
        <button type="submit">Postar</button>
    </form>
<?php endif; ?>

<h2>Posts Recentes</h2>

<?php foreach ($posts as $post): ?>
    <div class="post">
        <h3><a href="/perfil/<?php echo $post['usuario_id']; ?>">
                <?php echo $post['nome_usuario']; ?>
            </a></h3>
        <p><?php echo $post['texto']; ?></p>
        <span><?php echo $post['criado_em']; ?></span>
    </div>
<?php endforeach; ?>

<?php // views/home.php ?>

// ... (código anterior)

<?php foreach ($posts as $post): ?>
    <div class="post">
        <p><?php echo $post['texto']; ?></p>
        <form method="POST" action="/curtir"> 
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            <button type="submit">Curtir</button> 
        </form>
    </div>
<?php endforeach; ?>

// ... (restante do código HTML)