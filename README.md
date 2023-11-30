# Desafio Técnico - Projeto "desafio-tecnico-objective-raylan"

Este projeto foi criado para atender aos requisitos do Desafio Técnico conforme descrito no arquivo [desafio_tcnico_obj.pdf](desafio_tcnico_obj.pdf).

## Descrição

Este repositório contém os arquivos necessários para configurar um ambiente Docker com PHP 8.2 e Composer para fins de desenvolvimento do projeto. O Dockerfile e o docker-compose.yml foram preparados para criar um contêiner capaz de executar projetos Laravel versão 10.

## Configuração do Ambiente

Certifique-se de ter o Docker instalado em seu sistema para criar e executar o ambiente.

### Instruções de Uso

1. Clone este repositório:

   ```bash
   git clone https://github.com/seu-usuario/desafio-tecnico-objective-raylan.git
   ```
2. Navegue até o diretório do projeto:

    ```bash
    cd desafio-tecnico-objective-raylan
    ```

3. Para construir e iniciar o contêiner, execute:
    ```bash
    docker-compose up --build
    ```

Após o contêiner ser iniciado, você pode acessar o ambiente de desenvolvimento para instalar um projeto Laravel ou realizar outras operações necessárias.