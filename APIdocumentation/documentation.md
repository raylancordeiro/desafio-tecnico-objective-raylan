# Documentação da API do desafio Objective

**Descrição:** Descrição da API

**Versão:** 1.0.0

**Servidor:** http://localhost:8000

## /api/conta

### `GET /api/conta`

- **Resumo:** Obter conta
- **Descrição:** Obtém informações de uma conta
- **Parâmetros:**
    - `id` (query) - ID da conta (integer, int64)
- **Exemplo de Requisição:**
    ```bash
    curl -X GET "http://localhost:8000/api/conta?id=123" -H "Accept: application/json"
    ```

### `POST /api/conta`

- **Resumo:** Criar conta
- **Descrição:** Cria uma nova conta
- **Corpo da Requisição:**
    - Tipo: `application/json`
    - Propriedades:
        - `conta_id` (integer)
        - `saldo` (number)
- **Exemplo de Requisição:**
    ```bash
    curl -X POST "http://localhost:8000/api/conta" -H "Accept: application/json" -H "Content-Type: application/json" -d '{"conta_id": 123, "saldo": 100}'
    ```

## /api/transacao

### `POST /api/transacao`

- **Resumo:** Criar transação
- **Descrição:** Cria uma nova transação
- **Corpo da Requisição:**
    - Tipo: `application/json`
    - Propriedades:
        - `conta_id` (integer)
        - `valor` (number)
- **Exemplo de Requisição:**
    ```bash
    curl -X POST "http://localhost:8000/api/transacao" -H "Accept: application/json" -H "Content-Type: application/json" -d '{"conta_id": 123, "valor": 50}'
    ```
