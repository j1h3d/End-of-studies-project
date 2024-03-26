<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'email', 'occupation'];


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function entreprises()
    {
        return $this->belongsToMany(Entreprise::class);
    }
}
