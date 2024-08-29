<?php
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;
use App\Services\DrawTeamsService;
use App\Repositories\EventDayRepository;
use App\Exceptions\DivisionByZeroDrawException;
use App\Exceptions\InsufficientNumberOfPlayersException;


class DrawTeamsServiceTest extends TestCase
{
    private $eventDayRepository;
    private $drawTeamsService;

    protected function setUp(): void
    {
        $this->eventDayRepository = $this->createMock(EventDayRepository::class);
        $this->drawTeamsService = new DrawTeamsService($this->eventDayRepository);
    }
    
    public function testDrawTeamsThrowsDivisionByZeroDrawException()
    {
        $this->expectException(DivisionByZeroDrawException::class);

        $playersByTeam = 0;
        $eventId = 1;
        $matchPlayers = new Collection(array_fill(0, 10, 
        ["id" => 24, 
         "goalkeeper" => 1, 
         "email" => "justfontaine@futebol.com", 
         "name" => "Fontaine", 
         "rating" => 2, 
         "created_at" => "2024-08-26T01:59:47.000000Z", 
         "updated_at" => "2024-08-26T01:59:47.000000Z", 
         "deleted_at" => null]
        ));

        $this->eventDayRepository->method('findPlayersByEventId')
            ->with($eventId)
            ->willReturn($matchPlayers);

        $this->drawTeamsService->drawTeams($playersByTeam, $eventId);
    }

    public function testDrawTeamsThrowsInsufficientNumberOfPlayersException()
    {
        $this->expectException(InsufficientNumberOfPlayersException::class);

        $playersByTeam = 5;
        $eventId = 1;
        $matchPlayers = new Collection(array_fill(0, 5, 
        [ 
            "id" => 24, 
            "goalkeeper" => 1, 
            "email" => "justfontaine@futebol.com", 
            "name" => "Fontaine", 
            "rating" => 2, 
            "created_at" => "2024-08-26T01:59:47.000000Z", 
            "updated_at" => "2024-08-26T01:59:47.000000Z", 
            "deleted_at" => null
        ]));

        $this->eventDayRepository->method('findPlayersByEventId')
            ->with($eventId)
            ->willReturn($matchPlayers);

        $this->drawTeamsService->drawTeams($playersByTeam, $eventId);
    }
}