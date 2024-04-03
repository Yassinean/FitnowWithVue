<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progression extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'poids',
        'taille',
        'performances',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(Progression::class);
    }
}