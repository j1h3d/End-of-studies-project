<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'email', 'password'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function entreprises()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }
}
