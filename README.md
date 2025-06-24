# Teste Técnico – Desenvolvedor Backend Laravel – Infornet

Este projeto foi desenvolvido como parte do processo seletivo. O sistema simula uma plataforma utilizada por assistências 24 horas veicular, com foco na escolha do melhor prestador de serviço com base em custo-benefício e distância percorrida.

---

##  Tecnologias Utilizadas

- PHP 8.1
- Laravel 12
- MySQL
- JWT Auth
- Tailwind CSS (frontend)
- JavaScript com AJAX
- Postman

---

##  Funcionalidades Entregues

### Autenticação com JWT
- `POST /api/login`: Gera token JWT com login e senha.
- Rotas protegidas por `auth:api`:
  - `/me`: Dados do usuário autenticado
  - `/logout`: Encerra sessão
  - `/refresh`: Atualiza token

---

### Cadastro de Prestadores
- Endpoint: `POST /api/prestadores`
- Prestadores têm dados como nome, CPF, e-mail, telefone, endereço completo (com latitude/longitude reais), cidade e UF.
- Inseridos 29 registros com dados reais da Região Metropolitana de Belo Horizonte (Contagem, BH, Betim, Vespasiano, etc.)
- Todos possuem situação ativa (1).

---

### Cadastro de Serviços
- Endpoint: `POST /api/servicos`
- Exemplo: "Reboque", "Chaveiro", "Socorro Mecânico"

---

### Associação Prestador x Serviço
- Endpoint: `POST /api/servico-prestadores`
- Relacionamento Many-to-Many com campos extras:
  - `km_saida`
  - `valor_saida`
  - `valor_km_excedente`

---

### Cálculo de Custo de Atendimento
- Endpoint: `POST /api/servicos/calcular-custo`
- Baseado na distância total (ida + volta), considerando:
  - Prestador → Origem
  - Origem → Destino
  - Destino → Prestador

---

### Cálculo de Valor Real
- Endpoint: `POST /api/servicos/calcular-valor-real`
- Fórmula: `valor_saida + (km_excedente * valor_por_km)`

---

### Busca de Coordenadas
- Endpoint interno: `POST /enderecos/geolocalizar`
- Integração com API externa `geocode/{endereco}` (Basic Auth)

---

### Consulta de Prestadores com Filtros e Ordenações
- Endpoint: `POST /api/prestadores/consulta`
- Entrada:
  - Origem e destino (cidade, estado, latitude, longitude)
  - ID do serviço
  - Ordenação: valor total, distância, status
  - Filtros: cidade, estado, status
- Saída:
  - Lista de prestadores + valor estimado do atendimento
  - Status online via API externa: `https://nhen90f0j3.execute-api.us-east-1.amazonaws.com/v1/api/prestadores/online` (Basic Auth)

---

## Frontend (Interface AJAX)

- Local: `public/consulta_prestadores.html`
- Estilo: Tailwind CSS
- Comunicação assíncrona via `fetch()`

### Inserção manual do token JWT:
> Abra o arquivo `public/auth.js` e cole seu token na linha:
```js
const token = "COLE_SEU_TOKEN_JWT_AQUI";
Sem isso, a API não autoriza a requisição. Token é obtido ao fazer login via Postman em /api/login.

## Documentação Postman
Arquivo incluído: postman_collection_infornet.json

Contém os métodos prontos para testes:

Autenticação

loguin com token gerado jwt

Organização do Código
Separação por:

Controllers

Models

Seeders

Factories

Middlewares

Utilização de princípios do SOLID

Padrão de repositórios

.gitignore configurado para ignorar:

.env

vendor/

node_modules/

Chaves e logs

 Como Executar o Projeto
Clone o repositório

bash
Copiar
Editar
git clone https://github.com/viiniciusdev/teste-backend-infornet.git
cd teste-backend-infornet
Instale as dependências

bash
Copiar
Editar
composer install
npm install && npm run build
Copie o .env.example

bash
Copiar
Editar
cp .env.example .env
Configure o banco de dados MySQL no .env

Gere a chave

bash
Copiar
Editar
php artisan key:generate
Execute as migrations e seeders

bash
Copiar
Editar
php artisan migrate --seed
Inicie o servidor

bash
Copiar
Editar
php artisan serve
 O Que Ainda Pode Ser Melhorado
 Testes unitários e de integração (não implementados)

 Containerização com Docker

 Versão alternativa com Blade em vez de HTML puro

 Autenticação automatizada no frontend sem precisar colar o token

✅ Status Final
O projeto está funcional e pode ser testado facilmente. Todos os endpoints principais estão implementados, e o fluxo de cálculo e consulta atende os requisitos do teste técnico. A interface foi construída com AJAX puro e está apta para retornar dados reais com base nas regras definidas.
