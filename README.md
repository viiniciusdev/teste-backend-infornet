
# Teste Técnico – Desenvolvedor Backend Laravel – Infornet

Este projeto foi desenvolvido como parte do processo seletivo para a vaga de Desenvolvedor Backend na empresa Infornet. O sistema simula uma plataforma utilizada por assistências 24 horas veicular (seguradoras), com foco na busca do melhor prestador de serviço considerando custo-benefício e distância.

## Tecnologias Utilizadas

- PHP 8.1
- Laravel 10
- MySQL
- JWT Auth
- Tailwind CSS (Frontend AJAX)
- Postman (documentação da API)

---

## Funcionalidades Entregues

### Autenticação com JWT
- Endpoint: `POST /api/login`
- Sistema de autenticação JWT com middleware protegendo todas as rotas privadas.
- Endpoints adicionais: `/me`, `/logout`, `/refresh`.

### Cadastro de Prestadores
- Endpoint: `POST /api/prestadores`
- Campos: nome, email, telefone, CPF, endereço completo, coordenadas geográficas, situação (ativo).
- População automática de 25 prestadores com dados de cidades reais de MG (como Contagem, BH, Betim, etc.).
- Script de inserção incluso.

### Cadastro de Serviços
- Endpoint: `POST /api/servicos`
- Cada prestador possui no mínimo 3 serviços associados por meio da tabela `servico_prestadores`.

### Associação Prestador x Serviço
- Endpoint: `POST /api/servico-prestadores`
- Campos: km de saída, valor de saída, valor por km excedente.
- Modelagem de relacionamento Many-to-Many com dados adicionais na tabela pivô.

### Cálculo de custo de atendimento
- Endpoint: `POST /api/servicos/calcular-custo`
- Baseado na distância total em linha reta entre: prestador → origem, origem → destino, destino → prestador.
- Lógica implementada conforme solicitado no enunciado.

### Cálculo de valor real
- Endpoint: `POST /api/servicos/calcular-valor-real`
- Com base na fórmula do teste: valor de saída + (km excedente * valor por km excedente).

### Consulta de prestadores
- Endpoint: `POST /api/prestadores/consulta`
- Recebe filtros e ordenação: cidade, UF, status, valor total, distância, status online.
- Consome a API externa de status de prestadores via Basic Auth, conforme requisitado.

### Busca de coordenadas (geolocalização)
- Endpoint: `POST /enderecos/geolocalizar`
- Integração com a API externa `endereco/geocode/{endereco}` via Basic Auth.

---

## Frontend (Interface)

- Tela pública criada em HTML + Tailwind CSS + JavaScript.
- Consumo dos endpoints protegidos via `auth.js`, utilizando token JWT .
- Tela de consulta interativa sem recarregamento de página (AJAX).
- Listagem dos prestadores e serviços prestados.
- Filtros de cidade, serviço e ordenação.

---

## Organização do Código

- Separação em controllers, models, factories, seeders.
- Uso de princípios do SOLID e boas práticas Laravel.
- Repositórios organizados por responsabilidade.
- `.gitignore` respeitado para não subir arquivos desnecessários (como `.env`, `vendor`, `node_modules`, etc.).

---

## Como Executar o Projeto

1. Clone o repositório:
   ```bash
   git clone https://github.com/viiniciusdev/teste-backend-infornet.git
   ```

2. Acesse o diretório:
   ```bash
   cd teste-backend-infornet
   ```

3. Instale as dependências:
   ```bash
   composer install
   npm install && npm run build
   ```

4. Configure o `.env`:
   - Copie o `.env.example` para `.env`
   - Ajuste as credenciais do banco de dados

5. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

6. Execute as migrations e seeders:
   ```bash
   php artisan migrate --seed
   ```

7. Inicie o servidor local:
   ```bash
   php artisan serve
   ```

---

## Testes e Documentação

- A documentação da API está disponível no Postman, no arquivo:
  ```
  postman_collection_infornet.json
- Contém chamadas para:
  - Login
  - Consulta de perfil
  - Logout

---

## Pontos Pendentes

Apesar da maioria das funcionalidades exigidas já terem sido desenvolvidas, seguem alguns pontos que ainda não foram completamente finalizados:

- Integração visual completa entre os resultados da consulta e a renderização detalhada dos serviços por prestador.
- Implementação de testes automatizados (unitários e de integração).
- Containerização via Docker.
- Tela com exibição via Blade (foi utilizada abordagem independente via HTML + JS).

---

## Considerações Finais

O projeto está funcional, cumpre os principais requisitos e pode ser executado localmente conforme o passo a passo descrito. As funcionalidades principais de autenticação, busca de prestadores, cálculos de valores e integração externa estão implementadas, com foco em desempenho, clareza e arquitetura limpa.

Em caso de dúvidas, estou à disposição para esclarecimentos.

