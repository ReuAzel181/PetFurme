<?php

namespace App\Http\Controllers;

use App\Models\ChargeSlip;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Schema;

class ChargeSlipController extends Controller
{
    public function index()
    {
        $chargeSlips = ChargeSlip::with('appointment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('settings.invoice', compact('chargeSlips'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            // Log the incoming request data
            Log::info('Charge slip request data:', $request->all());

            // Check if tables exist
            if (!Schema::hasTable('appointment')) {
                throw new \Exception('Appointment table does not exist');
            }
            if (!Schema::hasTable('charge_slips')) {
                throw new \Exception('Charge slips table does not exist');
            }

            // Find and verify appointment first
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            if ($appointment->status === 'completed') {
                throw new \Exception('Appointment is already completed');
            }

            // Validate request data
            $validated = $request->validate([
                'appointment_id' => 'required|exists:appointment,id',
                'invoice_number' => 'required|string',
                'patient_name' => 'required|string',
                'attending_physician' => 'nullable|string',
                'services' => 'required|array|min:1', // At least one service required
                'services.*.description' => 'required|string',
                'services.*.amount' => 'required|numeric|min:0',
                'products' => 'nullable|array',
                'products.*.item' => 'required_with:products|string',
                'products.*.quantity' => 'required_with:products|integer|min:1',
                'products.*.amount' => 'required_with:products|numeric|min:0',
                'discount_amount' => 'required|numeric|min:0',
                'discount_type' => 'required|in:fixed,percentage',
                'notes' => 'nullable|string',
            ]);

            // Calculate totals
            $servicesTotal = collect($request->services)->sum('amount');
            $productsTotal = collect($request->products)->sum('amount');
            
            $subtotal = $servicesTotal + $productsTotal;
            $discountValue = $request->discount_type === 'percentage' 
                ? ($subtotal * ($request->discount_amount / 100))
                : $request->discount_amount;
            $grandTotal = $subtotal - $discountValue;

            // Create charge slip
            $chargeSlip = ChargeSlip::create([
                'invoice_number' => $validated['invoice_number'],
                'appointment_id' => $appointment->id,
                'patient_name' => $validated['patient_name'],
                'attending_physician' => $validated['attending_physician'],
                'services' => $request->services,
                'products' => $request->products,
                'services_total' => $servicesTotal,
                'products_total' => $productsTotal,
                'discount_amount' => $validated['discount_amount'],
                'discount_type' => $validated['discount_type'],
                'grand_total' => $grandTotal,
                'notes' => $validated['notes'],
            ]);

            // Update appointment status
            $appointment->update(['status' => 'completed']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Charge slip created successfully',
                'data' => $chargeSlip
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::error('Appointment not found: ' . $request->appointment_id);
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found'
            ], 404);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error details: ', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating charge slip: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating charge slip: ' . $e->getMessage(),
                'debug_info' => [
                    'tables' => [
                        'appointment_exists' => Schema::hasTable('appointment'),
                        'charge_slips_exists' => Schema::hasTable('charge_slips')
                    ]
                ]
            ], 500);
        }
    }
} 