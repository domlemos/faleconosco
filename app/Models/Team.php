<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'teams';

    protected $fillable = [
        'name',
        'rating',
        'event_id'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'team_players', 'team_id', 'player_id');
    }

    public function event()
    {
        return $this->belongsTo(EventDay::class);
    }
}
