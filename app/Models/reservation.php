<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    use HasFactory;
    protected $fillable = [
  
        'eventId',
        'statut',
        
    ];
    public function evenement()
    {
        return $this->belongsTo(evenement::class);
    }
}
