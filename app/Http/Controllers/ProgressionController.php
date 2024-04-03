<?php

namespace App\Http\Controllers;

use App\Models\Progression;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProgressionResource;
use App\Http\Controllers\API\BaseController as BaseController;

class ProgressionController extends BaseController
{
    public function __invoke()
    {
        // Your controller logic here
    }

    public function show()
    {
        $usr = Auth::id();
        $progression = Progression::where('user_id', $usr)->get();

        return $this->sendResponse($progression, 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'poids' => 'required',
            'taille' => 'required',
            'performances' => 'required',
        ]);

        // Get the authenticated user's ID
        $progressionID = auth()->id();

        // Create a new Progression instance with user_id
        $progression = Progression::create([
            'user_id' => $progressionID,
            'poids' => $validateData['poids'],
            'taille' => $validateData['taille'],
            'performances' => $validateData['performances'],
            'status' => 'Non Terminé',
        ]);


        return $this->sendResponse(new ProgressionResource($progression), 'Progression created successfully.');
        // return response()->json(['msg' => 'Progression created successfully', 'data' => new ProgressionResource($progression)]);
    }

    public function edit(Request $request, Progression $Progress)
    {
        if (auth()->id()) {
            $request->validate([
                'status' => 'required|in:Terminé,Non terminé',
            ]);
            if ($request->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $request->errors()
                ], 401);
            }
            $Progress->update($request->all());

            return response()->json([
                "status" => 1,
                "data" => $Progress,
                "msg" => "Progress updated successfully"
            ], 200);
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "not yours"
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Progression $progression)
    {
        if (auth()->check() && $progression->user_id === auth()->id()) {
            $validatedData = $request->validate([
                'poids' => 'required',
                'taille' => 'required',
                'performances' => 'required',
            ]);

            $progression->update($validatedData);

            return $this->sendResponse(new ProgressionResource($progression), 'Progression updated successfully.');
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "Unauthorized: You are not allowed to update this progression."
            ], 401);
        }
    }

    public function updateStatus(Request $request, Progression $progression)
    {
        $userID = Auth::id();
        if ($userID == $progression->user_id){
            $validatedData = $request->validate([
                'status' => 'required',
            ]);

            $success = $progression->update([
                'status' => $validatedData['status'],
            ]);

            if ($success) {
                $data = [
                    'message' => 'status changed succefully!'
                ];
                return response()->json($data, 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Progression $progression): JsonResponse
    {
        if (auth()->check() && $progression->user_id === auth()->id()) {
            $progression->delete();

            return response()->json(['msg' => 'Progression deleted successfully']);
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "Unauthorized: You are not allowed to delete this progression."
            ], 401);
        }
    }
}