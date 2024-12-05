<?php

/// In DonutChart.php (Livewire component)

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\WorshipSession;

class DonutChart extends Component
{
    public function render()
    {
        // Retrieve the latest worship session
        $latestWorshipSession = WorshipSession::latest()->first();

        // Check if a worship session exists
        if (!$latestWorshipSession) {
            // If no worship session is found, include all users with zero scans, excluding the specified email
            $users = User::where('email', '!=', 'yekhapmandindi@gmail.com')->get()->map(function($user) {
                return [
                    'name' => $user->name,
                    'scans' => 0
                ];
            });
        } else {
            // Fetch users and their scan counts for the latest worship session, excluding the specified email
            $users = User::where('email', '!=', 'yekhapmandindi@gmail.com')
                ->withCount(['scans' => function($query) use ($latestWorshipSession) {
                    $query->where('worship_session_id', $latestWorshipSession->id);
                }])
                ->get()
                ->map(function($user) {
                    return [
                        'name' => $user->name,
                        'scans' => $user->scans_count
                    ];
                });

            // Ensure all users are included with zero scans if not already counted, excluding the specified email
            if ($users->isEmpty()) {
                $users = User::where('email', '!=', 'yekhapmandindi@gmail.com')->get()->map(function($user) {
                    return [
                        'name' => $user->name,
                        'scans' => 0
                    ];
                });
            }
        }

        return view('livewire.donut-chart', [
            'users' => $users,
        ]);
    }
}
