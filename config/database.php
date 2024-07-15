<?php

try {
    // Define o caminho para o arquivo SQLite
    $dbPath = __DIR__ . '/../database/social_network.sqlite';

    // Cria a conexão PDO (criará o arquivo se não existir)
    $pdo = new PDO("sqlite:{$dbPath}");

    // Habilita exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Script SQL para criar as tabelas (se já não existirem)
    $createTableSql = "
        -- Cria a tabela de Usuários
        CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL, 
            biografia TEXT,
            criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
            visitas INTEGER DEFAULT 0
        );

        -- Cria a tabela de Posts
        CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            texto TEXT NOT NULL,
            imagem VARCHAR(255),
            criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE 
        );

        -- Cria a tabela de Curtidas
        CREATE TABLE IF NOT EXISTS curtidas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            post_id INTEGER NOT NULL,
            criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
            UNIQUE (usuario_id, post_id) 
        );

        -- Cria a tabela de Seguidores
        CREATE TABLE IF NOT EXISTS seguidores (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            seguidor_id INTEGER NOT NULL,
            usuario_id INTEGER NOT NULL,
            FOREIGN KEY (seguidor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            UNIQUE (seguidor_id, usuario_id)
        );
    ";

    // Executa o script SQL
    $pdo->exec($createTableSql);

    // Exibe mensagem de sucesso (opcional)
    // echo "Tabelas criadas com sucesso (ou já existentes)!";

} catch (PDOException $e) {
    die("Erro na conexão/criação do banco de dados: " . $e->getMessage());
}

// Retorna a conexão para ser usada em outros arquivos
return $pdo; 