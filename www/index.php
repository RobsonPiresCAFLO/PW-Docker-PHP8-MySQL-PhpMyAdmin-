<?php
    // Pastas da raiz que fazem parte desta página e não são projetos
    $ignorados = ['css', 'img', 'custom', 'assets'];

    $projetos = [];
    foreach (scandir(__DIR__) as $item) {
        if ($item[0] === '.' || in_array($item, $ignorados, true)) continue;
        $caminho = __DIR__ . '/' . $item;
        if (!is_dir($caminho)) continue;
        $projetos[] = [
            'nome'       => $item,
            'url'        => rawurlencode($item) . '/',
            'modificado' => filemtime($caminho),
            'temIndex'   => is_file("$caminho/index.php") || is_file("$caminho/index.html"),
        ];
    }

    $host   = htmlspecialchars(explode(':', $_SERVER['HTTP_HOST'] ?? 'localhost')[0]);
    $raiz   = htmlspecialchars($_SERVER['DOCUMENT_ROOT']);
    $agora  = new DateTime();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Servidor Web local</title>
    <style>
    :root {
        --bg: #eef2f7;
        --card: #ffffff;
        --text: #1f2937;
        --muted: #6b7280;
        --border: #e5e7eb;
        --accent: #4f5b93;
        --hover: #f3f4f6;
        --term-bg: #0f172a;
        --term-text: #e2e8f0;
        --shadow: 0 10px 30px rgba(15, 23, 42, .08);
    }
    :root[data-theme="dark"] {
        --bg: #0f172a;
        --card: #1e293b;
        --text: #e2e8f0;
        --muted: #94a3b8;
        --border: #334155;
        --accent: #8892bf;
        --hover: #273449;
        --term-bg: #020617;
        --shadow: 0 10px 30px rgba(0, 0, 0, .35);
    }
    :root { color-scheme: light; }
    :root[data-theme="dark"] { color-scheme: dark; }

    /* Botão de tema */
    .tema {
        display: flex; margin: 0 0 16px auto; align-items: center; gap: 8px;
        padding: 8px 14px;
        border: 1px solid var(--border); border-radius: 999px;
        background: var(--card); color: var(--text);
        box-shadow: var(--shadow);
        font: inherit; font-size: .85rem; font-weight: 600;
        cursor: pointer;
    }
    .tema:hover { background: var(--hover); }
    .tema .escuro, :root[data-theme="dark"] .tema .claro { display: none; }
    :root[data-theme="dark"] .tema .escuro { display: inline; }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        background: var(--bg);
        color: var(--text);
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, Ubuntu, sans-serif;
        line-height: 1.5;
    }
    a { color: inherit; text-decoration: none; }
    code { font-family: ui-monospace, "SFMono-Regular", Menlo, Consolas, monospace; font-size: .9em; }

    .container { max-width: 1280px; margin: 0 auto; padding: 24px 16px; }

    .layout {
        display: grid;
        grid-template-columns: minmax(0, 3fr) minmax(0, 2fr);
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) { .layout { grid-template-columns: minmax(0, 1fr); } }

    .card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: var(--shadow);
        padding: 24px;
    }
    .card + .card { margin-top: 24px; }
    .card h2 {
        margin: 0 0 16px;
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--muted);
    }

    /* Cabeçalho */
    .hero { display: flex; align-items: center; gap: 20px; }
    .hero h1 { margin: 0; font-size: clamp(2rem, 5vw, 3.2rem); line-height: 1.1; }
    .hero p { margin: 6px 0 0; color: var(--muted); }
    .status {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: .85rem; font-weight: 600; color: #10b981;
    }
    .status::before {
        content: ""; width: 10px; height: 10px; border-radius: 50%;
        background: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, .2);
        animation: pulso 2s infinite;
    }
    @keyframes pulso { 50% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); } }
    .hero img { width: 120px; margin-left: auto; flex-shrink: 0; }
    @media (max-width: 560px) { .hero img { display: none; } }

    /* Logos da stack */
    .stack {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-top: 24px;
    }
    .stack div {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 12px;
        display: flex; align-items: center; justify-content: center;
        height: 90px;
    }
    .stack img { max-width: 100%; max-height: 100%; object-fit: contain; }
    @media (max-width: 560px) { .stack { grid-template-columns: repeat(2, 1fr); } }

    /* Atalhos */
    .atalhos {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 10px;
    }
    .atalho {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 14px;
        border: 1px solid var(--border);
        border-left: 4px solid var(--cor);
        border-radius: 10px;
        font-weight: 600;
        transition: transform .15s, background .15s;
    }
    .atalho:hover { background: var(--hover); transform: translateY(-2px); }
    .atalho small { display: block; font-weight: 400; color: var(--muted); font-size: .75rem; }

    /* Comandos do Docker */
    .intro { margin: 0 0 14px; color: var(--muted); }
    .comandos { list-style: none; margin: 0; padding: 0; display: grid; gap: 12px; }
    .comandos p { margin: 0 0 6px; }
    .terminal {
        display: flex; align-items: center; gap: 10px;
        background: var(--term-bg); color: var(--term-text);
        border-radius: 10px; padding: 10px 12px;
    }
    .terminal code { flex: 1; overflow-x: auto; white-space: nowrap; }
    .terminal code::before { content: "$ "; color: #10b981; }
    .copiar {
        border: 1px solid #334155; border-radius: 6px;
        background: transparent; color: var(--term-text);
        font: inherit; font-size: .75rem; padding: 4px 10px; cursor: pointer;
    }
    .copiar:hover { background: #1e293b; }

    /* Informações do servidor */
    .infos { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin: 0; }
    .infos div { border: 1px solid var(--border); border-radius: 10px; padding: 10px 12px; }
    .infos dt { font-size: .75rem; color: var(--muted); }
    .infos dd { margin: 0; font-weight: 600; }
    @media (max-width: 560px) { .infos { grid-template-columns: 1fr; } }

    /* Coluna de projetos */
    .projetos { position: sticky; top: 24px; }
    .projetos-topo { display: flex; justify-content: space-between; align-items: baseline; }
    .contador {
        background: var(--accent); color: #fff;
        border-radius: 999px; padding: 2px 10px; font-size: .8rem; font-weight: 700;
    }
    .busca {
        width: 100%; margin-bottom: 12px;
        padding: 10px 12px;
        border: 1px solid var(--border); border-radius: 10px;
        background: var(--bg); color: var(--text); font-size: .95rem;
    }
    .lista { list-style: none; margin: 0; padding: 0; max-height: 70vh; overflow-y: auto; }
    .lista a {
        display: flex; align-items: center; gap: 12px;
        padding: 10px; border-radius: 10px;
        transition: background .15s;
    }
    .lista a:hover { background: var(--hover); }
    .lista svg { width: 28px; height: 28px; fill: #f5b041; flex-shrink: 0; }
    .lista .nome { font-weight: 600; overflow-wrap: anywhere; }
    .lista small { display: block; color: var(--muted); font-size: .75rem; }
    .lista .seta { margin-left: auto; color: var(--muted); }
    .vazio { color: var(--muted); text-align: center; padding: 24px 8px; }

    /* Rodapé */
    footer {
        margin-top: 24px;
        display: flex; align-items: center; gap: 24px; flex-wrap: wrap;
    }
    footer img { width: 220px; max-width: 100%; }
    footer .texto { flex: 1; min-width: 240px; text-align: center; }
    footer p { margin: 4px 0; }
    footer .sub { color: var(--muted); font-size: .9rem; }
    .logo-escuro, :root[data-theme="dark"] .logo-claro { display: none; }
    :root[data-theme="dark"] .logo-escuro { display: block; }
    </style>
    <script>
    // Aplica o tema salvo antes de desenhar a página (padrão: claro)
    try {
        if (localStorage.getItem('tema') === 'dark') document.documentElement.dataset.theme = 'dark';
    } catch (e) {}
    </script>
</head>

<body>
    <div class="container">
        <button class="tema" id="tema" type="button" aria-label="Alternar modo claro/escuro">
            <span class="claro">🌙 Modo escuro</span>
            <span class="escuro">☀️ Modo claro</span>
        </button>
        <div class="layout">

            <!-- Coluna 1: informações do servidor local -->
            <main>
                <section class="card">
                    <div class="hero">
                        <div>
                            <span class="status">Online</span>
                            <h1>Server Running</h1>
                            <p>Servidor Web local em <code><?= $host ?></code></p>
                        </div>
                        <img src="img/8yx98C.gif" alt="">
                    </div>
                    <div class="stack">
                        <div><img src="img/Docker-Logo.png" alt="Docker"></div>
                        <div><img src="img/apache3.png" alt="Apache HTTP Server"></div>
                        <div><img src="img/php-logo.png" alt="PHP"></div>
                        <div><img src="img/maria_db.png" alt="MariaDB"></div>
                    </div>
                </section>

                <section class="card">
                    <h2>Atalhos</h2>
                    <nav class="atalhos">
                        <a class="atalho" style="--cor:#dc3545" href="http://<?= $host ?>:8080" target="_blank" title="Usuario: alunos Senha: alunos">
                            <span>PHPMyAdmin<small>Gerenciar o banco</small></span>
                        </a>
                        <a class="atalho" style="--cor:#0d6efd" href="info.php" title="Usuario: root Senha: 1fp1caflo">
                            <span>Info PHP<small>phpinfo()</small></span>
                        </a>
                        <a class="atalho" style="--cor:#0dcaf0" href="https://www.php.net/manual/pt_BR/index.php" target="_blank">
                            <span>Manual do PHP<small>php.net</small></span>
                        </a>
                        <a class="atalho" style="--cor:#198754" href="https://www.php.net/downloads.php" target="_blank">
                            <span>Download<small>Versões do PHP</small></span>
                        </a>
                        <a class="atalho" style="--cor:#6c757d" href="https://museum.php.net/" target="_blank">
                            <span>PHP Museum<small>Versões antigas</small></span>
                        </a>
                        <a class="atalho" style="--cor:#ffc107" href="lista.php">
                            <span>Projetos<small>Lista de diretórios</small></span>
                        </a>
                    </nav>
                </section>

                <section class="card">
                    <h2>Como usar o Docker</h2>
                    <p class="intro">Execute os comandos no terminal, dentro da pasta do projeto (onde está o
                        <code>docker-compose.yml</code>).</p>
                    <ul class="comandos">
                        <li>
                            <p><b>Iniciar o servidor</b> — sobe os containers em segundo plano.</p>
                            <div class="terminal"><code>docker compose up -d</code><button class="copiar" type="button">Copiar</button></div>
                        </li>
                        <li>
                            <p><b>Verificar</b> — lista os containers em execução.</p>
                            <div class="terminal"><code>docker ps</code><button class="copiar" type="button">Copiar</button></div>
                        </li>
                        <li>
                            <p><b>Parar o servidor</b> — para e remove os containers (os dados do banco são mantidos).</p>
                            <div class="terminal"><code>docker compose down</code><button class="copiar" type="button">Copiar</button></div>
                        </li>
                    </ul>
                </section>

                <section class="card">
                    <h2>Servidor</h2>
                    <dl class="infos">
                        <div><dt>Data e horário atual</dt><dd><?= $agora->format('d/m/Y H:i:s') ?></dd></div>
                        <div><dt>Time zone em uso</dt><dd><?= $agora->getTimezone()->getName() ?></dd></div>
                        <div><dt>Versão do PHP</dt><dd><?= phpversion() ?></dd></div>
                    </dl>
                </section>
            </main>

            <!-- Coluna 2: projetos hospedados em www -->
            <aside class="card projetos">
                <div class="projetos-topo">
                    <h2>Projetos hospedados</h2>
                    <span class="contador"><?= count($projetos) ?></span>
                </div>
                <?php if ($projetos): ?>
                    <input type="search" class="busca" id="busca" placeholder="Filtrar projetos..." aria-label="Filtrar projetos">
                    <ul class="lista" id="lista">
                        <?php foreach ($projetos as $p): ?>
                        <li data-nome="<?= htmlspecialchars(mb_strtolower($p['nome'])) ?>">
                            <a href="<?= $p['url'] ?>">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-8l-2-2z"/></svg>
                                <span>
                                    <span class="nome"><?= htmlspecialchars($p['nome']) ?></span>
                                    <small>
                                        Modificado em <?= date('d/m/Y H:i', $p['modificado']) ?>
                                        <?= $p['temIndex'] ? '' : ' · sem index' ?>
                                    </small>
                                </span>
                                <span class="seta">&rsaquo;</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="vazio" id="semResultado" hidden>Nenhum projeto encontrado.</p>
                <?php else: ?>
                    <p class="vazio">Nenhum projeto ainda.<br>Crie uma pasta em <code><?= $raiz ?></code> para começar.</p>
                <?php endif; ?>
            </aside>
        </div>

        <footer class="card">
            <img src="img/Logo-IFPI-Floriano-Horizontal.png" class="logo-claro" alt="logoIFPI">
            <img src="img/Logo-IFPI-Floriano-Horizontal_branco.png" class="logo-escuro" alt="logoIFPI">
            <div class="texto">
                <p><b>EasyPHP</b>: Apache HTTP Server - PHP - MariaDB - Software Livre</p>
                <p class="sub">Programação para Web Backend - <?= date('Y') ?></p>
            </div>
        </footer>
    </div>

    <script>
    document.getElementById('tema').addEventListener('click', () => {
        const raiz = document.documentElement;
        const escuro = raiz.dataset.theme !== 'dark';
        if (escuro) raiz.dataset.theme = 'dark'; else delete raiz.dataset.theme;
        try { localStorage.setItem('tema', escuro ? 'dark' : 'light'); } catch (e) {}
    });

    document.querySelectorAll('.copiar').forEach(botao => {
        botao.addEventListener('click', async () => {
            const comando = botao.previousElementSibling.textContent;
            try {
                await navigator.clipboard.writeText(comando);
                botao.textContent = 'Copiado!';
            } catch (e) {
                botao.textContent = 'Erro';
            }
            setTimeout(() => botao.textContent = 'Copiar', 1500);
        });
    });

    const busca = document.getElementById('busca');
    if (busca) {
        const itens = document.querySelectorAll('#lista li');
        busca.addEventListener('input', () => {
            const termo = busca.value.trim().toLowerCase();
            let visiveis = 0;
            itens.forEach(li => {
                const ok = li.dataset.nome.includes(termo);
                li.hidden = !ok;
                if (ok) visiveis++;
            });
            document.getElementById('semResultado').hidden = visiveis > 0;
        });
    }
    </script>
</body>

</html>
