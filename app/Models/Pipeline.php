<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'pipeline_n'];
    protected $table = 'sales_pipelines';

    public function steps()
    {
        return $this->hasMany(PipelineStep::class, 'sales_pipeline_id');
    }
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
