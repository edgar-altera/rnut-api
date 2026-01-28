<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexVehiclesByRutRequest;
use App\Http\Requests\ShowVehicleRequest;
use App\Http\Resources\OwnerVehiclesResource;
use App\Http\Resources\VehicleWithOwnerResource;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Owner;
use App\Models\Vehicle;
use App\Support\ApiResponse;

class VehicleController extends Controller
{
    public function show(ShowVehicleRequest $request, string $licensePlate)
    {
        $vehicle = Vehicle::with(['owner.address', 'owner.contacts.type', 'urbanCategory', 'interurbanCategory'])
                        ->where('patente', $licensePlate)
                        ->firstOrFail();

        return ApiResponse::success(data: new VehicleWithOwnerResource($vehicle));
    }

    public function byRut(IndexVehiclesByRutRequest $request, string $rut)
    {
        $owner = Owner::where('rut', $request->rut)->firstOrFail();

        $entitytIds = Owner::where('rut', $request->rut)->pluck('id');

        $contractIds = Owner::where('rut', $request->rut)->pluck('id_contrato');

        $contacts = Contact::whereIn('id_entidad', $entitytIds)
            ->select('tipo', 'dato')
            ->distinct()
            ->with('type')
            ->get();

        $addresses = Address::whereIn('id_contrato', $contractIds)
            ->select('comuna', 'calle', 'numero', 'departamento', 'codigo_postal', 'comentario')
            ->distinct()
            ->get();

        $vehicles = Vehicle::with(['urbanCategory', 'interurbanCategory'])
                    ->whereHas('owner', function ($q) use ($request) {
                        $q->where('rut', $request->rut);
                    })->simplePaginate(10);

        return ApiResponse::success(data: new OwnerVehiclesResource(
            vehicles: $vehicles,
            owner: $owner,
            contacts: $contacts,
            addresses: $addresses
        ));
    }
}
