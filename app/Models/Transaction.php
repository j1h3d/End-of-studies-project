<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'sales_pipeline_id', 'pipeline_step_id'];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
    public function partners()
    {
        return $this->belongsTo(Partner::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function commercials()
    {
        return $this->belongsToMany(Commercial::class);
    }
    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class, 'sales_pipeline_id');
    }
    public function pipelineStep()
    {
        return $this->belongsTo(PipelineStep::class, 'pipeline_step_id');
    }
    public function count()
    {
        $count = Transaction::count();
        return response()->json(['count' => $count]);
    }
}
