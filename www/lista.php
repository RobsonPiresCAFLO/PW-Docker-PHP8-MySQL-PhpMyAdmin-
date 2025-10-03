<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Diretórios</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        .folder-icon {
            width: 32px;
            height: 32px;
            vertical-align: middle;
            margin-right: 12px;
            fill: #f5b041;
        }
        .folder-link {
            display: flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 10px;
            transition: background 0.2s;
            font-size: 1.15rem;
            text-decoration: none;
            color: #2c3e50;
        }
        .folder-link:hover {
            background: #f8f9fa;
            text-decoration: none;
            color: #2874a6;
        }
        .container {
            max-width: 80%;
        }
        body {
            background: #f3f6fa;
        }
        .main-card {
            margin-top: 5px;
            box-shadow: 0 4px 16px 0 rgba(44, 62, 80, 0.07);
            border-radius: 18px;
            border: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card main-card">
        <div class="card-body">
            <h2 class="card-title mb-4 text-center">Diretórios encontrados</h2><hr>
            <ul class="list-unstyled">
            <?php
                $itens = scandir('.');
                foreach ($itens as $item) {
                    if ($item === '.' || $item === '..') continue;
                    if (is_dir($item)) {
                        // Previne problemas com espaços ou caracteres especiais
                        $url = urlencode($item);
                        echo '<li class="mb-2">';
                        echo '<a class="folder-link" href="' . $url . '">';
                        // Ícone SVG de pasta
                        echo '<svg class="folder-icon" viewBox="0 0 24 24">
                                <path d="M10.4 4l1.6 2h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6.4zm-6.4 2v2h16V8h-16zm0 4v8h16v-8h-16z"/>
                              </svg>';
                        echo htmlspecialchars($item);
                        echo '</a></li>';
                    }
                }
            ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
