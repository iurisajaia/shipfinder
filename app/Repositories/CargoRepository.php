<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\ContactInfo;
use App\Models\DangerStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Carrgo\CreateCarrgoRequest;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Repositories\Interfaces\MediaRepositoryInterface;


class CargoRepository implements CargoRepositoryInterface
{

    protected MediaRepositoryInterface $mediaRepository;

    public function __construct(MediaRepositoryInterface $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }


    public function index(): JsonResponse{
        $cargos = Cargo::query()->with(['package', 'package.type', 'package.contacts'])->orderByDesc('id')->get();
        return response()->json(['data' => $cargos]);
    }

    public function getPackageTypes(): JsonResponse{
        $packageTypes = PackageType::query()->orderByDesc('id')->get();
        return response()->json(['data' => $packageTypes]);
    }

    public function getDangerStatuses(): JsonResponse{
        $dangerStatuses = DangerStatus::query()->orderByDesc('id')->get();
        return response()->json(['data' => $dangerStatuses]);
    }

    public function createPackage(Request $request): Package{
        $package = new Package([...$request->get('package')]);
        $package->save();
        return $package;
    }

    public function getUserContacts(Request $request): JsonResponse{
        $contacts = ContactInfo::query()
            ->where('user_id', $request->user()->id)
            ->with('package')
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['data' => $contacts]);
    }

    public function create(CreateCarrgoRequest $request): JsonResponse
    {
        try {
            $package = $this->createPackage($request);
            $cargo = $this->createCargo($request, $package);

            $contactInfos = $request->get('contact_info');

            if(isset($contactInfos['sender']) && count($contactInfos['sender'])){
                $this->saveContacts($contactInfos['sender'], true, $package, $request);
            }

            if(isset($contactInfos['receiver']) && count($contactInfos['receiver'])){
                $this->saveContacts($contactInfos['receiver'], false, $package, $request);
            }

            if(isset($request->images)){
                $this->mediaRepository->addImagesToModel($request->images, $cargo);
            }

            $response = Cargo::with(['package', 'package.type', 'package.contacts'])->findOrFail($cargo->id);

            return response()->json([
                'message' => 'Cargo created successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function saveContacts($contacts, $isSender, $package, $request){
        foreach($contacts as $contact){
            $info = new ContactInfo([
                ...$contact,
                'is_sender' => $isSender,
                'package_id' => $package->id,
                'user_id' => $request->user()->id
            ]);
            $info->save();
        }
    }

    public function createCargo(Request $request, Package $package): Cargo{
        $cargo = new Cargo([...$request->except(['package', 'contact_info'])]);
        $cargo['package_id'] = $package->id;
        $cargo['user_id'] = $request->user()->id;
        $cargo->save();
        return $cargo;
    }

}
