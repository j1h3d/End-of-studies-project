<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Partner;
use App\Models\Commercial;
use App\Models\Pipeline;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pipeline $pipeline)
    {
        $pipelineSteps = $pipeline->steps;
        foreach ($pipelineSteps as $step) {
            $transactions = Transaction::where('sales_pipeline_id', $pipeline->id)->where('pipeline_step_id', $step->id)->with('services', 'client', 'partners', 'commercials', 'pipeline')->get();
            $step->setAttribute('transactions', $transactions);
        }
        return response()->json($pipelineSteps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'partner_id' => 'required|exists:partners,id',
            'client_id' => 'required|exists:clients,id',
            'commercial_id' => 'required|exists:commercials,id',
            'pipeline_id' => 'required|exists:sales_pipelines,id',
        ]);

        $transaction = Transaction::create([
            'client_id' => $validatedData['client_id'],
            'sales_pipeline_id' => $validatedData['pipeline_id'],
            'pipeline_step_id' => 1,
        ]);

        $service = Service::find($validatedData['service_id']);
        $transaction->services()->save($service);

        $partner = Partner::find($validatedData['partner_id']);
        $transaction->partners()->save($partner);

        $commercial = Commercial::find($validatedData['commercial_id']);
        $transaction->commercials()->save($commercial);

        return response()->json(['message' => 'Transaction created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transactions = Transaction::findOrFail($id);

        $transactions->delete();
        return response()->json(['message' => 'Transaction deleted successfully!']);
    }
    public function count()
    {
        $count = Transaction::query()->count();
        return response()->json(['count' => $count]);
    }
}
