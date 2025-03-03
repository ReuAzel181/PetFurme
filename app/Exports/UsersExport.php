<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Address',
            'Role',
            'Pets Count',
            'Pet Names',
            'Appointments Count',
            'Last Appointment',
            'Appointment Status',
            'Orders Count',
            'Total Orders Amount',
            'Last Order Date',
            'Member Since',
            'Last Updated'
        ];
    }

    public function map($user): array
    {
        $latestAppointment = $user->appointments->sortByDesc('appointment_date')->first();
        $latestOrder = $user->orders->sortByDesc('created_at')->first();
        $petNames = $user->pets->pluck('name')->implode(', ');

        return [
            $user->id,
            $user->name,
            $user->email,
            $user->phone ?? 'Not provided',
            $user->address ?? 'Not provided',
            ucfirst($user->role),
            $user->pets->count(),
            $petNames ?: 'No pets',
            $user->appointments->count(),
            $latestAppointment ? Carbon::parse($latestAppointment->appointment_date)->format('Y-m-d') : 'No appointments',
            $latestAppointment ? ucfirst($latestAppointment->status) : 'N/A',
            $user->orders->count(),
            '₱' . number_format($user->orders->sum('total'), 2),
            $latestOrder ? $latestOrder->created_at->format('Y-m-d') : 'No orders',
            $user->created_at->format('Y-m-d'),
            $user->updated_at->format('Y-m-d')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:P1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F0F0F0']
                ]
            ]
        ];
    }
} 