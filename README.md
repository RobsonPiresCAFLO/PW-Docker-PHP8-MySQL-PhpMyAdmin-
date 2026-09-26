# 🚀 Ambiente PHP + MySQL + phpMyAdmin com Docker

Este projeto é uma alternativa ao XAMPP, utilizando **Docker** e **Docker Compose** para rodar PHP, Apache, MySQL e phpMyAdmin de forma simples e portátil.  
Basta clonar o repositório e executar um comando para ter o ambiente pronto em qualquer computador (Windows, Linux ou macOS).
---

## 📦 Serviços incluídos
- **Apache + PHP**: servidor web com suporte ao PHP.
- **MySQL**: banco de dados relacional.
- **phpMyAdmin**: interface gráfica para administração do MySQL.
- **Customizações**:
  - `upload_max_filesize` aumentado para 64M.
  - `post_max_size` aumentado para 128M.
  - Timezone ajustado para **America/Sao_Paulo** (ou America/Fortaleza).
  - Autoindex do Apache habilitado e estilizado (listagem de diretórios sem `index.php`).
---

## 📛 Nome fixo do projeto

O `docker-compose.yml` define na primeira linha:

```yaml
name: apache-mysql-php8-laravel
```

Sem essa linha, o Docker Compose usa o **nome da pasta** como nome do projeto. Isso significa que renomear ou mover o diretório faz o Compose entender que é um projeto novo e:

- tentar criar containers com nomes já em uso (`mysql-db`, `apache-php`, `phpmyadmin`), resultando no erro `Conflict. The container name "/mysql-db" is already in use`;
- apontar para um volume de dados **vazio**, deixando o MySQL sem nenhum dos bancos anteriores.

Com o `name:` fixo, a pasta pode ser renomeada ou movida à vontade que os containers e o volume `apache-mysql-php8-laravel_db_data` continuam sendo reconhecidos e os dados preservados.

> Se o erro de conflito aparecer mesmo assim, confira se o `name:` está presente no topo do `docker-compose.yml`.

Use localhost para acessar o apache e localhost:8080 para acessar o PhpMyAdmin.
Coloque seus projetos em www.

### 🔑 Acesso ao banco

Credenciais definidas no `docker-compose.yml` (criadas automaticamente na primeira execução):

| Usuário | Senha | Permissões |
|---|---|---|
| `root` | `root` | acesso total a todos os bancos |
| `user` | `user123` | acesso ao banco `meu_banco` |

O banco `meu_banco` também é criado automaticamente na primeira execução.

> **Atenção:** esses valores só são aplicados quando o volume de dados é criado do zero. Se o volume já existir, o MySQL mantém os usuários e bancos que já estavam lá e ignora essas variáveis.

Divirtam-se!!! 
Prof. Me. Robson Pires Borges 
IFPI - Campus Floriano
