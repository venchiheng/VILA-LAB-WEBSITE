<?php

namespace App\Services;

use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class EquipmentService
{
    public function listAll()
    {
        return Equipment::all();
    }

    public function findById($id)
    {
        return Equipment::findOrFail($id);
    }

    public function create(array $data)
    {
        return Equipment::create($data);
    }

    public function update(Equipment $equipment, array $data)
    {
        $equipment->update($data);
        return $equipment;
    }

    public function delete(Equipment $equipment)
    {
        return $equipment->delete();
    }
}
