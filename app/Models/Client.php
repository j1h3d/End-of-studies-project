<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'email', 'address'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function entreprise()
    {
        return $this->belongsToMany(Entreprise::class);
    }
    public function count()
    {
        $count = Client::count();
        return response()->json(['count' => $count]);
    }
}
