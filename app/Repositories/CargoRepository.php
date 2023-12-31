<?php

namespace App\Repositories;

use App\Enums\BidStatusEnum;
use App\Enums\StatusEnum;
use App\Http\Requests\Carrgo\CreateBidRequest;
use App\Http\Requests\Carrgo\ResponseBidRequest;
use App\Models\Bid;
use App\Models\Cargo;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\ContactInfo;
use App\Models\DangerStatus;
use Carbon\Carbon;
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

    public function getMyCargos(Request $request): JsonResponse{
        $cargos = Cargo::query()->with(['package', 'package.type', 'package.contacts', 'bids', 'bid'])->where('user_id', $request->user()->id)->orderByDesc('id');

        $cargos = $this->filterCargos($request, $cargos);

        return response()->json(['data' => $cargos->get()]);
    }


    public function index(Request $request): JsonResponse{
        $cargos = Cargo::query()->with(['package', 'package.type', 'package.contacts'])->orderByDesc('id');


        $cargos = $this->filterCargos($request, $cargos);

        return response()->json(['data' => $cargos->get()]);
    }

    public function filterCargos(Request $request , $cargos){
        if ($request->has('pick_up_date')) {
            $pickUp = $request->input('pick_up_date');
            $cargos->where(function ($query) use ($pickUp) {
                $query->whereDate('pick_up_date', '<=', $pickUp);
            });
        }
        if ($request->has('delivery_date')) {
            $delivery = $request->input('delivery_date');
            $cargos->where(function ($query) use ($delivery) {
                $query->whereDate('delivery_date', '<=', $delivery);
            });
        }
        if ($request->has('bidding_end_date')) {
            $biddingEnd = $request->input('bidding_end_date');
            $cargos->where(function ($query) use ($biddingEnd) {
                $query->whereDate('bidding_end_date', '<=', $biddingEnd);
            });
        }

        if($request->has('package_type_id')){
            $cargos->whereHas('package', function($query) use ($request){
                $query->where('package_type_id', $request->input('package_type_id'));
            });
        }

        if($request->has('traffic_area')){
            $cargos->whereJsonContains('to->country', $request->input('traffic_area'));
        }

        return $cargos;
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
            dd($e->getMessage());
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

    public function createBid(CreateBidRequest $request): JsonResponse{
        $bid = new Bid($request->all());
        $bid['user_id'] = $request->user()->id;
        $bid->save();
        return response()->json(['data' => $bid], 200);
    }

    public function responseBid(ResponseBidRequest $request): JsonResponse{
        $bid = Bid::findOrFail($request['bid_id']);

        $cargo = Cargo::query()->where('id', $bid?->cargo_id)->first();

        if(!$bid || !$cargo) return response()->json(['error' => 'Cannot find data'], 404);

        $bid['status'] = BidStatusEnum::ACTIVE;
        $bid->save();


        $cargo['bid_id'] = $bid['id'];
        $cargo['status'] = StatusEnum::ACTIVE;
        $cargo->save();

        return response()->json(['$cargo' => $cargo], 200);
    }

}
