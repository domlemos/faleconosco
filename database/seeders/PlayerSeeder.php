<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = [   
            [
               "goalkeeper" => 0, 
               "email" => "araken@patuska", 
               "name" => "Araken Patuska", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "leonidas@futebol.com", 
               "name" => "Leônidas da Silva", 
               "rating" => 4 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "friedenreich@futebol.com", 
               "name" => "Arthur Friedenreich", 
               "rating" => 3 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "domingosdaguia@futebol.com", 
               "name" => "Domingos da Guia", 
               "rating" => 5 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "oberdan@futebol.com", 
               "name" => "Oberdan", 
               "rating" => 3 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "barbosa@futebol.com", 
               "name" => "Barbosa", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "niltonsantos@futebol.com", 
               "name" => "Nílton Santos", 
               "rating" => 4 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "didi@futebol.com", 
               "name" => "Didi", 
               "rating" => 4 
            ], 
            [
               "goalkeeper" => 1, 
               "email" => "emersonleao@futebol.com", 
               "name" => "Emerson Leão", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 1, 
               "email" => "gilmarsantos@futebol.com", 
               "name" => "Gilmar dos Santos Neves", 
               "rating" => 1 
            ], 
            [
               "goalkeeper" => 1, 
               "email" => "rodolforodriguez@futebol.com", 
               "name" => "Rodolfo Rofriguez e Rodriguez", 
               "rating" => 4 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "felix@futebol.com", 
               "name" => "Felix", 
               "rating" => 1 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "josemacia@futebol.com", 
               "name" => "Pepe", 
               "rating" => 3 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "zoca@futebol.com", 
               "name" => "Zoca", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "mauriciocupertino@futebol.com", 
               "name" => "Mauricio Cupertino", 
               "rating" => 4 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "ramiromartinez@futebol.com", 
               "name" => "Ramiro Martinez", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "eualalio@futebol.com", 
               "name" => "Eulalio Ribamar", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "salustiano@futebol.com", 
               "name" => "Salustiano Armenio", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "manoelfranciscodossantos@futebol.com", 
               "name" => "Garrincha", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "distefano@futebol.com", 
               "name" => "Di Stefano", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "obduliovarela@futebol.com", 
               "name" => "Varela", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 0, 
               "email" => "ferencpuskas@futebol.com", 
               "name" => "Puskas", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 1, 
               "email" => "levyashin@futebol.com", 
               "name" => "Yashin", 
               "rating" => 2 
            ], 
            [
               "goalkeeper" => 1, 
               "email" => "justfontaine@futebol.com", 
               "name" => "Fontaine", 
               "rating" => 2 
            ] 
        ];

        foreach($players as $player) {
            DB::table('players')->insert($player);
        }
    
    }
}
