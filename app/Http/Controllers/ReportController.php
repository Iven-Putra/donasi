<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Organization;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function receiptPdf($id)
    {
        $donation = Donation::with(['donor', 'donationType', 'user'])
            ->findOrFail($id);
            
        $organization = Organization::first() ?? new Organization([
            'name' => 'Yayasan Amal Peduli Sesama',
            'address' => 'Jl. Merdeka No. 45',
            'city' => 'Jakarta Selatan',
            'phone' => '021-7279898',
            'email' => 'info@amalpeduli.org',
            'logo' => null,
        ]);

        $pdf = Pdf::loadView('reports.receipt', compact('donation', 'organization'));
        return $pdf->stream('kuitansi-' . $donation->transaction_number . '.pdf');
    }

    public function rekapPdf(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $typeFilter = $request->query('typeFilter');
        $donorFilter = $request->query('donorFilter');
        $statusFilter = $request->query('statusFilter');

        $donations = Donation::query()
            ->with(['donor', 'donationType'])
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('donation_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('donation_date', '<=', $endDate);
            })
            ->when($typeFilter, function ($query) use ($typeFilter) {
                $query->where('donation_type_id', $typeFilter);
            })
            ->when($donorFilter, function ($query) use ($donorFilter) {
                $query->where('donor_id', $donorFilter);
            })
            ->when($statusFilter, function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->orderBy('donation_date', 'desc')
            ->get();

        $organization = Organization::first() ?? new Organization([
            'name' => 'Yayasan Amal Peduli Sesama',
            'address' => 'Jl. Merdeka No. 45',
            'city' => 'Jakarta Selatan',
            'phone' => '021-7279898',
            'email' => 'info@amalpeduli.org',
            'logo' => null,
        ]);

        $donationType = null;
        if ($typeFilter) {
            $donationType = \App\Models\DonationType::find($typeFilter);
        }

        $pdf = Pdf::loadView('reports.rekap', compact('donations', 'organization', 'startDate', 'endDate', 'donationType'));
        return $pdf->stream('laporan-rekap-donasi.pdf');
    }
}
