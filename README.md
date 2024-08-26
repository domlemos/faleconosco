
# Projeto desafio code Group

Para execução local,
Na pasta raiz do projeto, tendo o docker compose instalado 

```shell
docker compose build
docker compose up -d
docker compose run php composer install
docker compose run php php artisan migrate
docker compose run php php artisan db:seed
```


## Lista de endpoints: 

## Jogadores:

- GET http://localhost/api/player/all
- GET http://localhost/api/player/{id}

- POST http://localhost/api/player/

```json
{
    "name": "Aguinaga",
    "email": "aguinaga@futebol.com",
    "rating": "3",
    "goalkeeper": false
}
```


PUT http://localhost/api/player/{id}
DELETE http://localhost/api/player/{id}

## Times:

- GET http://localhost/api/team/all
- GET http://localhost/api/team/{id}
- POST http://localhost/api/team/
- PUT http://localhost/api/team/{id}
- DELETE http://localhost/api/team/{id}

Persistir dados do sorteio de um jogo no banco de dados
http://localhost/api/team/players

```json
{
	"players_by_team": "6",
	"event_id": "1"
}
```

Obter jogadores por Id do time
- GET http://localhost/api/team/{id}/players

## Evento (Jogo):

- GET http://localhost/api/event/all
- GET http://localhost/api/event/{id}

- POST http://localhost/api/event/
```json
{
	"name": "Rachão de natal"
}
```

- PUT http://localhost/api/event/{id}
- DELETE http://localhost/api/event/{id}

**Persistir dados do sorteio de um jogo no banco de dados**
- POST http://localhost/api/team/players

```json
{
	"players_by_team": "6",
	"event_id": "1"
}
```

Obter jogadores por Id do time
- GET http://localhost/api/team/{id}/players


**Sorteio e distribuição de jogadores em três times sendo que o terceiro time são de jogadores que restaram após escolha (sem persistir no banco)**
- GET http://localhost/api/event/drawteams/teamplayers/{playersByTeam}/event/{eventId}

Listar jogadores com presença confirmada no evento (jogo):
- GET http://localhost/api/event/{eventId}/players

Confirmar presença de jogador: (Um ou mais ids de jogadores no array)
- POST http://localhost/api/event/{eventId}/presence/confirm
```json
[1]
```

Cancelar presença de jogador: (Um ou mais ids de jogadores no array)
- POST http://localhost/api/event/{eventId}/presence/cancel
```json
[1]
```

## Observações

- A lógica do sorteio está na classe DrawTeamsService 


