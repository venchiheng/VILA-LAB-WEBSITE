<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Http\Resources\EquipmentResource;
use App\Services\EquipmentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EquipmentController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->authorize('viewAny', Equipment::class);

        $equipment = $this->service->all();

        return EquipmentResource::collection($equipment);
    }

    public function show($id)
    {
        $equipment = $this->service->findById($id); // <-- fixed
        $this->authorize('view', $equipment);

        return new EquipmentResource($equipment);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Equipment::class);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|string|max:255',
            'availability' => 'required|in:available,booked',
            'condition'    => 'nullable|string',
            'stock'        => 'required|integer|min:1',
        ]);

        $equipment = $this->service->create($validated);

        return response()->json([
            'message' => 'Equipment created successfully',
            'data' => new EquipmentResource($equipment)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $equipment = $this->service->findById($id); // <-- fixed
        $this->authorize('update', $equipment);

        $validated = $request->validate([
            'name'         => 'sometimes|required|string|max:255',
            'description'  => 'nullable|string',
            'image'        => 'nullable|string|max:255',
            'availability' => 'sometimes|required|in:available,booked',
            'condition'    => 'nullable|string',
            'stock'        => 'sometimes|required|integer|min:1',
        ]);

        $equipment = $this->service->update($equipment, $validated);

        return response()->json([
            'message' => 'Equipment updated successfully',
            'data' => new EquipmentResource($equipment)
        ]);
    }

    public function destroy($id)
    {
        $equipment = $this->service->findById($id); // <-- fixed
        $this->authorize('delete', $equipment);

        $this->service->delete($equipment);

        return response()->json([
            'message' => 'Equipment deleted successfully'
        ]);
    }
}
