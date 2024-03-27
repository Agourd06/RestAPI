<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evenement extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type',
        'date',
        'description',
        'localisation',
        'competence',
        'userId'
    ];
    public function reservation()
    {
        return $this->hasMany(reservation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
