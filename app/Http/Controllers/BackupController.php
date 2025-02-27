<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Pet;
use App\Models\Order;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function downloadArchiveBackup($type)
    {
        switch ($type) {
            case 'users':
                return $this->generateUsersBackup();
            case 'pets':
                return $this->generatePetsBackup();
            case 'orders':
                return $this->generateOrdersBackup();
            case 'appointments':
                return $this->generateAppointmentsBackup();
            case 'all':
                return $this->generateFullBackup();
            default:
                return response()->json(['error' => 'Invalid backup type'], 400);
        }
    }

    private function generateUsersBackup()
    {
        $users = User::onlyTrashed()->get();
        $filename = 'archived_users_' . Carbon::now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Archived Date', 'Deleted By']);

        foreach ($users as $user) {
            fputcsv($handle, [
                $user->id,
                $user->name,
                $user->email,
                $user->role,
                $user->deleted_at,
                $user->deletedBy ? $user->deletedBy->name : 'System'
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, $headers);
    }

    private function generatePetsBackup()
    {
        $pets = Pet::onlyTrashed()->get();
        $filename = 'archived_pets_' . Carbon::now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Name', 'Owner', 'Category', 'Breed', 'Archived Date', 'Deleted By']);

        foreach ($pets as $pet) {
            fputcsv($handle, [
                $pet->id,
                $pet->name,
                $pet->user ? $pet->user->name : 'Unknown Owner',
                $pet->category,
                $pet->breed,
                $pet->deleted_at,
                $pet->deletedBy ? $pet->deletedBy->name : 'System'
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, $headers);
    }

    private function generateOrdersBackup()
    {
        $orders = Order::onlyTrashed()->get();
        $filename = 'archived_orders_' . Carbon::now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['Order #', 'Customer', 'Total Amount', 'Status', 'Archived Date', 'Deleted By']);

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->invoice_no,
                $order->user ? $order->user->name : 'Walk-in Customer',
                $order->total,
                $order->status,
                $order->deleted_at,
                $order->deletedBy ? $order->deletedBy->name : 'System'
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, $headers);
    }

    private function generateAppointmentsBackup()
    {
        $appointments = Appointment::onlyTrashed()->get();
        $filename = 'archived_appointments_' . Carbon::now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Pet Owner', 'Pet Name', 'Appointment Date', 'Reason', 'Status', 'Archived Date', 'Deleted By']);

        foreach ($appointments as $appointment) {
            fputcsv($handle, [
                $appointment->id,
                $appointment->user ? $appointment->user->name : $appointment->owner_name,
                $appointment->pet_name,
                $appointment->appointment_date,
                is_array($appointment->reason_for_visit) ? implode(', ', $appointment->reason_for_visit) : $appointment->reason_for_visit,
                $appointment->status,
                $appointment->deleted_at,
                $appointment->deletedBy ? $appointment->deletedBy->name : 'System'
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, $headers);
    }

    private function generateFullBackup()
    {
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $filename = 'full_archive_backup_' . $timestamp . '.zip';
        
        $zip = new \ZipArchive();
        $zipPath = storage_path('app/temp/' . $filename);
        
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }
        
        $zip->open($zipPath, \ZipArchive::CREATE);

        // Add each backup file to the zip
        $types = ['users', 'pets', 'orders', 'appointments'];
        foreach ($types as $type) {
            $method = 'generate' . ucfirst($type) . 'Backup';
            $response = $this->$method();
            $content = $response->getContent();
            $zip->addFromString($type . '_' . $timestamp . '.csv', $content);
        }
        
        $zip->close();

        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $response = response()->download($zipPath, $filename, $headers);
        
        // Delete the temporary zip file after download
        register_shutdown_function(function() use ($zipPath) {
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }
        });

        return $response;
    }

    // Add these new methods for automatic backup
    public function autoBackup()
    {
        try {
            $timestamp = Carbon::now()->format('Y-m-d_His');
            $filename = 'automatic_backup_' . $timestamp . '.zip';
            $zipPath = storage_path('app/backups/' . $filename);
            
            // Create backups directory if it doesn't exist
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }
            
            $zip = new \ZipArchive();
            $zip->open($zipPath, \ZipArchive::CREATE);

            // Add each type of data to the zip
            $types = ['users', 'pets', 'orders', 'appointments'];
            foreach ($types as $type) {
                $method = 'generate' . ucfirst($type) . 'Backup';
                $response = $this->$method();
                $content = $response->getContent();
                $zip->addFromString($type . '_' . $timestamp . '.csv', $content);
            }
            
            $zip->close();

            // Store in storage/app/backups
            Storage::put('backups/' . $filename, file_get_contents($zipPath));

            // Clean up old backups (keep last 5)
            $this->cleanOldBackups();

            // Delete the temporary zip file
            unlink($zipPath);

            return response()->json([
                'success' => true,
                'message' => 'Automatic backup created successfully',
                'filename' => $filename
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function cleanOldBackups()
    {
        $backups = Storage::files('backups');
        if (count($backups) > 5) {
            // Sort by date, oldest first
            usort($backups, function($a, $b) {
                return Storage::lastModified($a) - Storage::lastModified($b);
            });
            
            // Delete all but the last 5 backups
            $toDelete = array_slice($backups, 0, count($backups) - 5);
            foreach ($toDelete as $file) {
                Storage::delete($file);
            }
        }
    }

    // Add this method to schedule automatic backups
    public function scheduleBackup()
    {
        // This will be called by the task scheduler
        $this->autoBackup();
    }

    public function listBackups()
    {
        $backups = Storage::files('backups');
        $backupsList = [];
        
        foreach ($backups as $backup) {
            $backupsList[] = [
                'filename' => basename($backup),
                'size' => Storage::size($backup),
                'last_modified' => Carbon::createFromTimestamp(Storage::lastModified($backup)),
                'download_url' => route('backup.download-file', ['filename' => basename($backup)])
            ];
        }

        return view('backups.list', compact('backupsList'));
    }

    public function downloadBackupFile($filename)
    {
        $path = 'backups/' . $filename;
        
        if (!Storage::exists($path)) {
            abort(404, 'Backup file not found');
        }

        return Storage::download($path);
    }
} 