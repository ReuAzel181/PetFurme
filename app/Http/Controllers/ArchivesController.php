<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Order;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchivesController extends Controller
{
    public function index()
    {
        $archivedPets = Pet::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        $archivedOrders = Order::onlyTrashed()
            ->with(['user' => function($query) {
                $query->withTrashed();
            }, 'deletedBy' => function($query) {
                $query->withTrashed();
            }])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10)
            ->through(function ($order) {
                $order->deleted_at = $order->deleted_at ? \Carbon\Carbon::parse($order->deleted_at) : null;
                return $order;
            });

        $archivedAppointments = Appointment::onlyTrashed()
            ->with(['user' => function($query) {
                $query->withTrashed();
            }, 'deletedBy' => function($query) {
                $query->withTrashed();
            }])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10)
            ->through(function ($appointment) {
                $appointment->deleted_at = $appointment->deleted_at ? \Carbon\Carbon::parse($appointment->deleted_at) : null;
                
                // Determine status based on appointment date and deletion date
                if ($appointment->appointment_date->isPast()) {
                    $appointment->status = 'completed';
                    $appointment->status_color = 'success';
                } else {
                    $appointment->status = 'cancelled';
                    $appointment->status_color = 'danger';
                }
                
                return $appointment;
            });

        return view('analytics.archives', [
            'archivedPets' => $archivedPets,
            'archivedOrders' => $archivedOrders,
            'archivedAppointments' => $archivedAppointments,
        ]);
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