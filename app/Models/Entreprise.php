<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'admin_id',
        'cp_registration',
        'social_reason',
        'adress',
        'city',
        'pays',

    ];
    public function commercials()
    {
        return $this->hasMany(Commercial::class, 'entreprise_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'service_id');
    }
    public function salesPipelines()
    {
        return $this->hasMany(SalesPipeline::class);
    }
}
