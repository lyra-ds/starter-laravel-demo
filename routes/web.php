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
                ['key' => 'actor', 'label' => 'Member'],
                ['key' => 'action', 'label' => 'Action'],
                ['key' => 'target', 'label' => 'Item'],
                ['key' => 'when', 'label' => 'When', 'align' => 'right'],
            ],
            'activityRows' => [
                ['id' => 1, 'actor' => 'Maya Chen', 'action' => 'updated', 'target' => 'Q3 roadmap', 'when' => '5 minutes ago'],
                ['id' => 2, 'actor' => 'Diego Ramirez', 'action' => 'uploaded', 'target' => 'Brand assets.zip', 'when' => '1 hour ago'],
                ['id' => 3, 'actor' => 'Priya Nair', 'action' => 'commented on', 'target' => 'Onboarding flow', 'when' => 'Yesterday'],
                ['id' => 4, 'actor' => 'Owen Blake', 'action' => 'archived', 'target' => 'Legacy pricing page', 'when' => '2 days ago'],
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
        return view('app.team', [
            'members' => [
                ['id' => 'maya', 'name' => 'Maya Chen', 'email' => 'maya@lyra-ds.dev', 'role' => 'Maintainer', 'status' => 'Active'],
                ['id' => 'diego', 'name' => 'Diego Ramirez', 'email' => 'diego@lyra-ds.dev', 'role' => 'Designer', 'status' => 'Active'],
                ['id' => 'priya', 'name' => 'Priya Nair', 'email' => 'priya@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Active'],
                ['id' => 'owen', 'name' => 'Owen Blake', 'email' => 'owen@lyra-ds.dev', 'role' => 'Engineer', 'status' => 'Invited'],
            ],
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
