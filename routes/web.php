<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/components', 'components-gallery')->name('components');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', function () {
        return view('app.dashboard', [
            'stats' => [
                ['label' => 'Active projects', 'value' => '12', 'delta' => '2 this month', 'direction' => 'up'],
                ['label' => 'Open tasks', 'value' => '38', 'delta' => '5 since yesterday', 'direction' => 'down'],
                ['label' => 'Team members', 'value' => '9', 'delta' => 'unchanged', 'direction' => 'flat'],
                ['label' => 'Storage used', 'value' => '64%', 'delta' => '3% this week', 'direction' => 'up'],
            ],
            'activityColumns' => [
                ['key' => 'actor', 'label' => 'Member', 'sortable' => true],
                ['key' => 'action', 'label' => 'Action', 'sortable' => true],
                ['key' => 'target', 'label' => 'Item'],
                // The visible value is prose; sorting reads the numeric key below.
                ['key' => 'when', 'label' => 'When', 'align' => 'right', 'sortable' => true, 'sortValueKey' => 'when_order'],
            ],
            'activityRows' => [
                ['id' => 1, 'actor' => 'Maya Chen', 'action' => 'updated', 'target' => 'Q3 roadmap', 'when' => '5 minutes ago', 'when_order' => 1],
                ['id' => 2, 'actor' => 'Diego Ramirez', 'action' => 'uploaded', 'target' => 'Brand assets.zip', 'when' => '1 hour ago', 'when_order' => 2],
                ['id' => 3, 'actor' => 'Sofia Almeida', 'action' => 'booked', 'target' => 'Design review — Friday 10:00', 'when' => '3 hours ago', 'when_order' => 3],
                ['id' => 4, 'actor' => 'Priya Nair', 'action' => 'commented on', 'target' => 'Onboarding flow', 'when' => 'Yesterday', 'when_order' => 4],
                ['id' => 5, 'actor' => 'Jonas Weber', 'action' => 'invited', 'target' => 'ana@lyra-ds.dev', 'when' => 'Yesterday', 'when_order' => 5],
                ['id' => 6, 'actor' => 'Maya Chen', 'action' => 'shared', 'target' => 'Onboarding flow.fig', 'when' => '2 days ago', 'when_order' => 6],
                ['id' => 7, 'actor' => 'Owen Blake', 'action' => 'archived', 'target' => 'Legacy pricing page', 'when' => '2 days ago', 'when_order' => 7],
                ['id' => 8, 'actor' => 'Diego Ramirez', 'action' => 'updated', 'target' => 'Brand guidelines', 'when' => '3 days ago', 'when_order' => 8],
            ],
        ]);
    })->name('dashboard');

    Route::get('/schedule', function () {
        $tomorrow = now()->addDay()->startOfDay();

        return view('app.schedule', [
            'scheduleSlots' => collect([9, 10, 11, 14, 15])
                ->map(fn (int $hour) => [
                    'start' => $tomorrow->copy()->setTime($hour, 0)->toIso8601String(),
                    'end' => $tomorrow->copy()->setTime($hour, 30)->toIso8601String(),
                ])
                ->all(),
        ]);
    })->name('schedule');

    Route::get('/files', function () {
        return view('app.files', [
            'projectFiles' => [
                ['id' => 'design', 'name' => 'Design & UI', 'type' => 'folder', 'items' => 6, 'updated' => '2026-08-10'],
                ['id' => 'contracts', 'name' => 'Contracts', 'type' => 'folder', 'items' => 3, 'updated' => '2026-08-05'],
                ['id' => 'brand-assets', 'name' => 'Brand assets.zip', 'size' => 18_874_368, 'updated' => '2026-08-09'],
                ['id' => 'roadmap', 'name' => 'Q3 roadmap.pdf', 'size' => 425_984, 'updated' => '2026-08-08'],
                ['id' => 'onboarding', 'name' => 'Onboarding flow.fig', 'size' => 2_202_009, 'updated' => '2026-08-06', 'shared' => true],
            ],
            'filesPath' => ['Workspace', 'Q3 release'],
        ]);
    })->name('files');

    Route::get('/team', function () {
        $allMembers = [
            ['id' => 'maya', 'name' => 'Maya Chen', 'email' => 'maya@lyra-ds.dev', 'role' => 'Maintainer', 'status' => 'Active'],
            ['id' => 'diego', 'name' => 'Diego Ramirez', 'email' => 'diego@lyra-ds.dev', 'role' => 'Designer', 'status' => 'Active'],
            ['id' => 'priya', 'name' => 'Priya Nair', 'email' => 'priya@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Active'],
            ['id' => 'owen', 'name' => 'Owen Blake', 'email' => 'owen@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Invited'],
            ['id' => 'sofia', 'name' => 'Sofia Almeida', 'email' => 'sofia@lyra-ds.dev', 'role' => 'Product', 'status' => 'Active'],
            ['id' => 'jonas', 'name' => 'Jonas Weber', 'email' => 'jonas@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Active'],
            ['id' => 'lin', 'name' => 'Lin Zhou', 'email' => 'lin@lyra-ds.dev', 'role' => 'Designer', 'status' => 'Active'],
            ['id' => 'amara', 'name' => 'Amara Okafor', 'email' => 'amara@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Suspended'],
            ['id' => 'lucas', 'name' => 'Lucas Ferreira', 'email' => 'lucas@lyra-ds.dev', 'role' => 'Support', 'status' => 'Active'],
            ['id' => 'emma', 'name' => 'Emma Lindqvist', 'email' => 'emma@lyra-ds.dev', 'role' => 'Product', 'status' => 'Active'],
            ['id' => 'ravi', 'name' => 'Ravi Patel', 'email' => 'ravi@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Invited'],
            ['id' => 'nina', 'name' => 'Nina Petrova', 'email' => 'nina@lyra-ds.dev', 'role' => 'Designer', 'status' => 'Active'],
            ['id' => 'theo', 'name' => 'Theo Dubois', 'email' => 'theo@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Active'],
            ['id' => 'grace', 'name' => 'Grace Kim', 'email' => 'grace@lyra-ds.dev', 'role' => 'Maintainer', 'status' => 'Active'],
            ['id' => 'omar', 'name' => 'Omar Haddad', 'email' => 'omar@lyra-ds.dev', 'role' => 'Support', 'status' => 'Active'],
            ['id' => 'julia', 'name' => 'Julia Santos', 'email' => 'julia@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Invited'],
            ['id' => 'kenji', 'name' => 'Kenji Tanaka', 'email' => 'kenji@lyra-ds.dev', 'role' => 'Designer', 'status' => 'Active'],
            ['id' => 'sara', 'name' => 'Sara Johansson', 'email' => 'sara@lyra-ds.dev', 'role' => 'Product', 'status' => 'Active'],
        ];

        $perPage = 8;
        $totalPages = (int) ceil(count($allMembers) / $perPage);
        $page = min(max(1, (int) request()->query('page', '1')), $totalPages);

        return view('app.team', [
            'members' => array_slice($allMembers, ($page - 1) * $perPage, $perPage),
            'page' => $page,
            'totalPages' => $totalPages,
            'totalMembers' => count($allMembers),
            'memberActions' => [
                ['type' => 'label', 'label' => 'Member'],
                ['label' => 'View profile'],
                ['label' => 'Change role'],
                ['type' => 'separator'],
                ['label' => 'Remove from team', 'danger' => true],
            ],
        ]);
    })->name('team');

    Route::view('/settings', 'app.settings')->name('settings');
});
