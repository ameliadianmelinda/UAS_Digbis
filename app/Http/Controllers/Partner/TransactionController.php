<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = collect([
            [
                'order_id' => 'ORD-20260724-001',
                'event_name' => 'Tech Conference 2026',
                'customer' => 'Raka Pratama',
                'email' => 'raka@mail.com',
                'phone' => '081234567890',
                'total' => 'Rp 450.000',
                'status' => 'Settlement',
                'date' => '24 Jul 2026',
            ],
            [
                'order_id' => 'ORD-20260724-002',
                'event_name' => 'Workshop UI/UX',
                'customer' => 'Dina Lestari',
                'email' => 'dina@mail.com',
                'phone' => '082345678901',
                'total' => 'Rp 320.000',
                'status' => 'Pending',
                'date' => '24 Jul 2026',
            ],
            [
                'order_id' => 'ORD-20260724-003',
                'event_name' => 'Startup Summit',
                'customer' => 'Fahri Zulkarnaen',
                'email' => 'fahri@mail.com',
                'phone' => '083456789012',
                'total' => 'Rp 780.000',
                'status' => 'Success',
                'date' => '23 Jul 2026',
            ],
            [
                'order_id' => 'ORD-20260724-004',
                'event_name' => 'Laravel Bootcamp',
                'customer' => 'Sinta Putri',
                'email' => 'sinta@mail.com',
                'phone' => '084567890123',
                'total' => 'Rp 250.000',
                'status' => 'Failed',
                'date' => '23 Jul 2026',
            ],
            [
                'order_id' => 'ORD-20260724-005',
                'event_name' => 'Design Sprint Masterclass',
                'customer' => 'Budi Santoso',
                'email' => 'budi@mail.com',
                'phone' => '085678901234',
                'total' => 'Rp 560.000',
                'status' => 'Expired',
                'date' => '22 Jul 2026',
            ],
            [
                'order_id' => 'ORD-20260724-006',
                'event_name' => 'Product Launch Festival',
                'customer' => 'Maya Ardianti',
                'email' => 'maya@mail.com',
                'phone' => '086789012345',
                'total' => 'Rp 610.000',
                'status' => 'Cancel',
                'date' => '22 Jul 2026',
            ],
            [
                'order_id' => 'ORD-20260724-007',
                'event_name' => 'Digital Marketing Day',
                'customer' => 'Arif Hidayat',
                'email' => 'arif@mail.com',
                'phone' => '087890123456',
                'total' => 'Rp 410.000',
                'status' => 'Settlement',
                'date' => '21 Jul 2026',
            ],
            [
                'order_id' => 'ORD-20260724-008',
                'event_name' => 'Data Analytics Meetup',
                'customer' => 'Ika Wulandari',
                'email' => 'ika@mail.com',
                'phone' => '088901234567',
                'total' => 'Rp 390.000',
                'status' => 'Success',
                'date' => '21 Jul 2026',
            ],
        ]);

        return view('partner.transaksi', compact('transactions'));
    }
}
