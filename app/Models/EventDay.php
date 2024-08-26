<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventDay extends Model
{    
    use HasFactory;
    use SoftDeletes;

    protected $table = 'event_days';

    protected $fillable = [
        'name'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'event_players', 'event_id',  'player_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
