<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'players';

    protected $fillable = [
        'id',
        'name',
        'email',
        'rating',
        'goalkeeper',
        'created_at',
        'deleted_at'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function events()
    {
        return $this->belongsToMany(EventDay::class, 'event_players', 'player_id', 'event_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_players', 'player_id', 'team_id');
    }
}
