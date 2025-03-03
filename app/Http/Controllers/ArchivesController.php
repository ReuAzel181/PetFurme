<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Order;
use App\Models\Appointment;
use App\Models\ArchivedOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchivesController extends Controller
{
    public function index()
    {
        $archivedUsers = User::onlyTrashed()
            ->with(['deletedBy'])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'users_page');

        $archivedPets = Pet::onlyTrashed()
            ->with(['user', 'deletedBy'])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'pets_page');

        $archivedOrders = Order::onlyTrashed()
            ->with(['user', 'deletedBy'])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'orders_page');

        $archivedAppointments = Appointment::onlyTrashed()
            ->with(['user', 'deletedBy'])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'appointments_page');

        return view('analytics.archives', compact(
            'archivedUsers',
            'archivedPets',
            'archivedOrders',
            'archivedAppointments'
        ));
    }

    public function restoreAppointment($id)
    {
        try {
            $appointment = Appointment::onlyTrashed()->findOrFail($id);
            $appointment->restore();
            
            return redirect()->back()->with('success', 'Appointment restored successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore appointment.');
        }
    }

    public function viewAppointment($id)
    {
        try {
            $appointment = Appointment::onlyTrashed()
                ->with(['user' => function($query) {
                    $query->withTrashed();
                }, 'deletedBy' => function($query) {
                    $query->withTrashed();
                }])
                ->findOrFail($id);
            
            return view('appointment.show', compact('appointment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }
    }
} 