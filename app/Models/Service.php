<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'category'];
    public function entreprises()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }
    public function commercials()
    {
        return $this->belongsToMany(Commercial::class);
    }
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }
}
