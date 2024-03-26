<?php

namespace App\Http\Controllers;

use App\Models\Pipeline;
use App\Models\PipelineStep;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class PipelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pipelines = Pipeline::with('steps')->get();
        return response()->json($pipelines);
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
            'pipeline_name' => 'required|string|max:255',
            'steps_number' => 'required|integer|min:1',
            'steps.*.step_name' => 'required|string|max:255',
            'steps.*.step_order' => 'required|integer|min:1',
            'steps.*.step_percentage' => 'required|integer|min:1|max:100',
        ]);

        $pipeline = new Pipeline();
        $pipeline->pipeline_name = $validatedData['pipeline_name'];
        $pipeline->steps_number = $validatedData['steps_number'];
        $pipeline->save();

        $stepsData = array_map(function ($step) use ($pipeline) {
            $step['sales_pipeline_id'] = $pipeline->id;
            return $step;
        }, $validatedData['steps']);

        PipelineStep::insert($stepsData);

        return redirect()->back();
    }

    public function addStep(Request $request)
    {
        $validatedData = $request->validate([
            'step_name' => 'required|string|max:255',
            'step_percentage' => 'required|integer|min:0|max:100',
            'sales_pipeline_id' => 'required|exists:sales_pipelines,id',
        ]);

        $pipeline = Pipeline::findOrFail($validatedData['sales_pipeline_id']);

        $step = new PipelineStep();
        $step->step_name = $validatedData['step_name'];
        $step->step_percentage = $validatedData['step_percentage'];
        $step->step_order = $pipeline->steps()->count() + 1;

        $pipeline->steps()->save($step);

        $pipeline->steps_number = $pipeline->steps()->count();
        $pipeline->save();

        return response()->json([
            'message' => 'Step added successfully',
            'step' => $step,
        ]);
    }


    public function saveStepOrder(Request $request, $pipelineId)
    {
        $steps = $request->input('steps');


        try {
            foreach ($steps as $step) {
                PipelineStep::find($step['id'])->updateOrfail([
                    'step_order' => $step['step_order']
                ]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to update step order.'], 500);
        }

        return response()->json(['message' => 'Step order saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pipeline = Pipeline::with(['steps' => function ($query) {
            $query->orderBy('step_order');
        }])->findOrFail($id);
        return response()->json($pipeline);
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
        $pipeline = Pipeline::find($id);

        $pipeline->delete();
        return response()->json(['message' => 'Pipeline deleted successfully']);
    }

    public function destroyStep($id)
    {
        $step = PipelineStep::findOrFail($id);
        $pipeline = $step->pipeline;
        $step->delete();

        $pipeline->steps_number = $pipeline->steps()->count();
        $pipeline->save();

        return response()->json(['message' => 'Step deleted successfully']);
    }
}
