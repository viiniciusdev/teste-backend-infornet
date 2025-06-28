# Teste Técnico Backend Laravel – Infornet

Este projeto foi desenvolvido como parte do processo seletivo. O sistema simula uma plataforma utilizada por assistências 24 horas veicular, com foco na escolha do melhor prestador de serviço com base em custo-benefício e distância percorrida.

---

## Tecnologias Utilizadas

- PHP 8.1
- Laravel 12
- xampp 
- MySQL (via xampp)
- JWT Auth
- Tailwind CSS (frontend)
- JavaScript com AJAX
- Postman

---

## Funcionalidades Entregues

### Autenticação com JWT

- `POST /api/login`: Gera token JWT com login e senha.
- Rotas protegidas por `auth:api`:
  - `GET /api/me`: Dados do usuário autenticado
  - `POST /api/logout`: Encerra sessão

### Cadastro de Prestadores

- Endpoint: `POST /api/prestadores`
- Campos: nome, CPF, e-mail, telefone, endereço completo (com latitude/longitude reais), cidade e UF.
- Inseridos 29 registros com dados reais da Região Metropolitana de BH (Contagem, BH, Betim, Vespasiano etc.)
- Todos possuem situação ativa (1).

### Cadastro de Serviços

- Endpoint: `POST /api/servicos`
- Exemplos: "Reboque", "Chaveiro", "Socorro Mecânico"

### Associação Prestador x Serviço

- Endpoint: `POST /api/servico-prestadores`
- Relacionamento Many-to-Many com os campos adicionais:
  - `km_saida`
  - `valor_saida`
  - `valor_km_excedente`

### Cálculo de Custo de Atendimento

- Endpoint: `POST /api/servicos/calcular-custo`
- Considera:
  - Prestador → Origem
  - Origem → Destino
  - Destino → Prestador

### Cálculo de Valor Real

- Endpoint: `POST /api/servicos/calcular-valor-real`
- Fórmula: `valor_saida + (km_excedente * valor_por_km)`

### Busca de Coordenadas (Geocoding)

- Endpoint interno: `POST /enderecos/geolocalizar`
- Integração com API externa `geocode/{endereco}` (Basic Auth)

### Consulta de Prestadores

- Endpoint: `POST /api/prestadores/consulta`
- Parâmetros de entrada:
  - Origem e destino (cidade, estado, latitude, longitude)
  - ID do serviço
  - Ordenação: valor total, distância, status
  - Filtros: cidade, estado, status
- Saída:
  - Lista de prestadores + valor estimado
  - Status online dos prestadores via API externa:
    `https://nhen90f0j3.execute-api.us-east-1.amazonaws.com/v1/api/prestadores/online` (Basic Auth)

---

## Frontend (Interface AJAX)

- Local: `public/consulta_prestadores.html`
- Estilo: Tailwind CSS
- Requisições via `fetch()` com AJAX

### Inserção Manual do Token JWT

Edite o arquivo `public/auth.js` e cole o token na seguinte linha:

```js
const token = "Bearer COLE_SEU_TOKEN_JWT_AQUI";
```

O token é obtido ao fazer login via Postman em `/api/login`. Sem isso, as requisições ao backend falham.
OBS: o token expira em torno de 10 a 15 min tendo que colar manualmente novamente no const token = "Bearer COLE_SEU_TOKEN_JWT_AQUI"

---

## Documentação Postman

Arquivo incluído: `postman_collection_infornet.json`

Inclui exemplos para:

- Login com JWT
- Autenticaçao

---

## Organização do Código

- Estrutura separada por:
  - Controllers
  - Models
  - Seeders
  - Factories
  - Middlewares
- Princípios do SOLID aplicados
- Padrão de repositórios
- Arquivo `.gitignore` configurado para ignorar:
  - `.env`
  - `vendor/`
  - `node_modules/`
  - Arquivos de log e chaves

---

## Como Executar o Projeto

1. Clone o repositório

```bash
git clone https://github.com/viiniciusdev/teste-backend-infornet.git
cd teste-backend-infornet
```

2. Instale as dependências

```bash
composer install
npm install && npm run build
```

3. Copie o `.env`

```bash
cp .env.example .env
```

4. Configure o banco de dados no arquivo `.env`

5. Gere a chave da aplicação

```bash
php artisan key:generate
```

6. Rode as migrations e seeders

```bash
php artisan migrate --seed
```

7. Inicie o servidor local

```bash
php artisan serve
```

---

## O que ainda pode ser melhorado

- [ ] Implementação de testes automatizados (unitários e de integração com PHPUnit)
- [ ] Containerização com Docker (Dockerfile e docker-compose.yml)
- [ ] Versão alternativa usando Blade em vez de HTML puro
- [ ] Autenticação automática no frontend (tela de login + armazenamento de token)
- [ ] Validações mais robustas com FormRequest e mensagens padronizadas
- [ ] Documentação automatizada da API (ex: Swagger ou Scribe)

---

## Status Final

O projeto está funcional e pronto para testes. Todos os endpoints principais estão implementados conforme solicitado. A interface web usa AJAX puro e exibe corretamente os dados retornados da API. Qualquer dúvida, estou à disposição.
