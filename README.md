# Gestor de vendas

O <b>Gestor de Vendas</b> é um aplicativo Laravel para gerenciar vendas e clientes. Ele utiliza o Laravel Sail para executar os contêineres Docker em um ambiente de desenvolvimento local.

## Requisitos

Antes de começar, certifique-se de ter o Docker instalado em sua máquina. Além disso, verifique se as portas especificadas no arquivo ``docker-compose.yml`` estão desocupadas.

## Instalação

Siga os passos abaixo para configurar e executar o projeto:

1. Clonando repositório:

```bash
git clone https://github.com/Guilherme-Silva0/GestorDeVendas.git
cd GestorDeVendas/
```

2. Copiando o arquivo de ambiente:

```bash
cp .env.example .env
```

3. Instalando as dependências com Composer (Se você tiver o php 8.3 e o composer 2.7.7 instalado você pode rodar diretamente o ``composer install``, mas recomendo que utilize o comando abaixo):

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install
```

4. Iniciando os contêineres com Laravel Sail:

```bash
./vendor/bin/sail up -d
```

5. Gerando a chave de aplicação:

```bash
./vendor/bin/sail artisan key:generate
```

6. Executando as migrações do banco de dados:

```bash
./vendor/bin/sail artisan migrate:fresh
```

7. Instalando as dependências do Node.js:

```bash
./vendor/bin/sail npm install
```

8. Compilando os assets (caso deseje rodar em modo de desenvolvimento use o comando `./vendor/bin/sail npm run dev`):

```bash
./vendor/bin/sail npm run build
```

## Encerrando o ambiente

Para encerrar o ambiente e para os contêineres, execute o seguinte comando:

```bash
./vendor/bin/sail down
```	