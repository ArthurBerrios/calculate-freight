# Freight Calculator API - Laravel

Uma API REST robusta desenvolvida em Laravel para cálculo de frete inteligente, utilizando a orquestração de múltiplas APIs externas (BrasilAPI, Nominatim e OSRM) para determinar distâncias precisas entre CEPs.

## 🚀 Funcionalidades

- **Autenticação Segura:** Proteção de rotas via Laravel Sanctum (Bearer Token).
- **Gestão de Usuários:** Registro com definição de tarifa personalizada por KM.
- **Cálculo de Frete Multi-API:**
    1.  **BrasilAPI:** Busca o endereço (Rua/Cidade) a partir do CEP.
    2.  **Nominatim (OSRM):** Converte o endereço em coordenadas geográficas (Lat/Long).
    3.  **OSRM Engine:** Calcula a distância real de condução entre os pontos.
- **Configuração Flexível:** Endpoint para atualização da tarifa por KM do usuário logado.

## 🛠️ Tecnologias e Técnicas

- **Framework:** Laravel
- **Banco de Dados:** MySQL
- **Autenticação:** Laravel Sanctum (Tokens API)
- **Arquitetura & Design Patterns:**
    - **Service Pattern:** Lógica de negócio isolada das Controllers.
    - **Repository Pattern & Interfaces:** Abstração da camada de persistência para facilitar testes e manutenção.
    - **Controllers:** Responsáveis apenas pela resposta e entrada de dados.
    - **Middlewares:** Garantia de segurança e contexto de usuário.
- **Ferramentas de Teste:** Postman

## 🗺️ Fluxo de Integração de APIs



1. `CEP` ➔ **BrasilAPI** ➔ `Endereço`
2. `Endereço` ➔ **Nominatim** ➔ `Coordenadas (Lat, Long)`
3. `Coordenadas A/B` ➔ **OSRM** ➔ `Distância (KM)`
4. `Distância` * `User.price_per_km` ➔ **Resultado Final**

## 📌 Endpoints

| **POST** | `/api/register` | Cria novo usuário com `price_per_km` |

| **POST** | `/api/login` | Autentica e retorna o Bearer Token |

| **POST** | `/api/calculate` | Calcula o frete passando `cep1` e `cep2` no body | Autenticação necessária |

| **PATCH** | `/api/user/id` | Altera o valor de `price_per_km` do usuário autenticado | Autenticação necessária |

### Exemplo de Requisição (Cálculo de Frete)
**URL:** `POST /api/calculate`  
**Headers:** `Authorization: Bearer {token}`  
```json

Body:
{
    "cep1" : "01234-010",
    "cep2" : "01311-930"
}
Response:
{
    "distance": "2.2108km",
    "price_per_km": 5,
    "shipping_value": "R$ 11,05"
} 
