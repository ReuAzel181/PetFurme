<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\ArchivedOrder;

class AnalyticsController extends Controller
{
    public function archives()
    {
        $archivedPets = Pet::onlyTrashed()
            ->with(['user', 'deletedBy'])
            ->latest('deleted_at')
            ->paginate(10);

        $archivedOrders = ArchivedOrder::with('archivedDetails')
            ->latest('archived_at')
            ->paginate(10);

        return view('analytics.archives', compact('archivedPets', 'archivedOrders'));
    }
} 