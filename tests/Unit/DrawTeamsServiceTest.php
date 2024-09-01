<?php
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;
use App\Services\DrawTeamsService;
use App\Repositories\EventDayRepository;
use App\Exceptions\DivisionByZeroDrawException;
use App\Exceptions\InsufficientNumberOfPlayersException;
use App\Exceptions\MaximumPlayersException;
use App\Models\Player;


class DrawTeamsServiceTest extends TestCase
{
    private $eventDayRepository;
    private $drawTeamsService;
    private $players;
    private $exceptionPlayers;

    protected function setUp(): void
    {
        $this->eventDayRepository = $this->createMock(EventDayRepository::class);
        $this->drawTeamsService = new DrawTeamsService($this->eventDayRepository);
        $players = collect();
        for ($i = 1; $i < 18; $i++) {
            $players->push(
                new Player([
                    "id" => (int) $i,
                    "goalkeeper" => $i == 1 || $i == 17 || $i == 5 || $i == 9 ? true : false,
                    "email" => "jogador{$i}@futebol.com",
                    "name" => "Jogador {$i}",
                    "rating" => rand(1, 5),               
                ])
            );
        }

        $this->players = $players;
        $this->exceptionPlayers = new Collection(array_fill(0, 5, 
            [
                "id" => 24, 
                "goalkeeper" => 1, 
                "email" => "justfontaine@futebol.com", 
                "name" => "Fontaine", 
                "rating" => 2, 
                "created_at" => "2024-08-26T01:59:47.000000Z", 
                "updated_at" => "2024-08-26T01:59:47.000000Z", 
                "deleted_at" => null
            ]
        ));

    }

    public function testDrawTeamsThrowsDivisionByZeroDrawException()
    {
        $this->expectException(DivisionByZeroDrawException::class);        

        $playersByTeam = 0;
        $eventId = 1;       

        $this->eventDayRepository->method('findPlayersByEventId')
            ->with($eventId)
            ->willReturn($this->exceptionPlayers);

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

    public function testMaximumPlayerException()
    {
        $this->expectException(MaximumPlayersException::class);        

        $playersByTeam = 16;                

        $this->drawTeamsService->filteredTeams($this->players, $playersByTeam);
    }

    public function testBuildTeams()
    {        
        $playersByTeam = 6;                
        
        $teams = $this->drawTeamsService->filteredTeams($this->players, $playersByTeam);

        $this->assertEquals(3, count($teams));
    }

    public function testPlayersByTeam()
    {        
        $playersByTeam = 6;                
        
        $teams = $this->drawTeamsService->filteredTeams($this->players, $playersByTeam);

        $this->assertEquals(6, $teams[0]->count());
        $this->assertEquals(6, $teams[1]->count());
        $this->assertEquals(5, $teams[2]->count());
    }   

    public function testHasGoalkeepers()
    {        
        $playersByTeam = 6;                
        
        $teams = $this->drawTeamsService->filteredTeams($this->players, $playersByTeam);

        $goalKeeper1 = $teams[0]->where('goalkeeper', true)->count();
        $goalKeeper2 = $teams[1]->where('goalkeeper', true)->count();

        $this->assertEquals(1, $goalKeeper1);
        $this->assertEquals(1, $goalKeeper2);
    }   
}
