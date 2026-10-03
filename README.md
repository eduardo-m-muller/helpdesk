# Helpdesk

Sistema simples de chamados de suporte técnico (PHP + MySQL).

## Estrutura

```
helpdesk/
├── frontend/              # tudo que aparece na tela
│   ├── index.html         # formulário para abrir chamado
│   ├── listar.html        # painel do técnico
│   ├── css/style.css      # estilos
│   └── js/
│       ├── index.js       # mensagem de sucesso do formulário
│       └── listar.js      # busca os chamados e monta a tabela
└── backend/               # tudo que roda no servidor
    ├── api/
    │   ├── criar_chamado.php     # salva um chamado (recebe o POST)
    │   └── listar_chamados.php   # devolve os chamados em JSON
    ├── config/
    │   └── conexao.php           # conexão com o banco
    └── database/
        └── banco.sql             # criação do banco e da tabela
```

## Como rodar

1. Rodar o `backend/database/banco.sql` no MySQL.
2. Conferir usuário e senha em `backend/config/conexao.php`.
3. Dentro da pasta `helpdesk`, subir o servidor do PHP:

```
php -S localhost:8000
```

4. Abrir `http://localhost:8000/frontend/index.html`.
