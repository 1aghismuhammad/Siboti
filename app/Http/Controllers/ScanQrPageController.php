<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanQrPageController extends Controller
{
    private function getMemberData(): array
    {
        return [
            'MEM-2024-0891' => [
                'name'      => 'Adrian Pratama',
                'initials'  => 'AP',
                'memberId'  => 'MEM-2024-0891',
                'package'   => 'Monthly Elite',
                'remaining' => 24,
                'status'    => 'active',
            ],
            'MEM-2024-0445' => [
                'name'      => 'Sinta Rahayu',
                'initials'  => 'SR',
                'memberId'  => 'MEM-2024-0445',
                'package'   => 'Monthly Basic',
                'remaining' => 0,
                'status'    => 'expired',
            ],
            'MEM-2024-0312' => [
                'name'      => 'Budi Santoso',
                'initials'  => 'BS',
                'memberId'  => 'MEM-2024-0312',
                'package'   => 'Quarterly Pro',
                'remaining' => 67,
                'status'    => 'active',
            ],
        ];
    }

    public function __invoke()
    {
        $todayCheckins = [];

        return view('scan-qr.index', [
            'members'       => $this->getMemberData(),
            'todayCheckins' => $todayCheckins,
        ]);
    }

    public function checkin(Request $request)
    {
        $request->validate(['member_id' => 'required|string']);

        $members  = $this->getMemberData();
        $memberId = strtoupper(trim($request->member_id));

        if (!isset($members[$memberId])) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        $member = $members[$memberId];

        if ($member['status'] !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak aktif atau sudah expired.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil dicatat.',
            'member'  => $member,
            'time'    => now()->format('H:i'),
        ]);
    }
}