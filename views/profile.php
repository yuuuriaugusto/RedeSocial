<?php // views/profile.php ?>
 
// ... (código anterior)

<?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] != $usuario['id']): ?>
    <form method="POST" action="/seguir">
        <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
        <button type="submit">
            <?php echo $this->follower->estaSeguindo($_SESSION['usuario_id'], $usuario['id']) ? "Deixar de Seguir" : "Seguir"; ?> 
        </button>
    </form>
<?php endif; ?>

// ... (restante do código HTML)

<?php // views/profile.php ?>

// ... (código HTML inicial)

<h1>Perfil de <?php echo $usuario['nome']; ?></h1>

<?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $usuario['id']): ?> 
    <a href="/editar-perfil">Editar Perfil</a>
<?php endif; ?>

<h2>Posts:</h2>

<?php foreach ($posts as $post): ?>
    <div class="post">
        <p><?php echo $post['texto']; ?></p>
        <span><?php echo $post['criado_em']; ?></span>
    </div>
<?php endforeach; ?>

// ... (restante do código HTML)