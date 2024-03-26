<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PipelineStep extends Model
{
    use HasFactory;
    protected $fillable = ['step_name', 'step_order', 'step_percentage'];
    protected $table = 'pipeline_steps';

    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class, 'sales_pipeline_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'pipeline_step_id');
    }
}
