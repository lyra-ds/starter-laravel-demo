@php
    $dropdownItems = [
        ['type' => 'label', 'label' => 'Workspace'],
        ['label' => 'View details'],
        ['label' => 'Duplicate'],
        ['type' => 'separator'],
        ['type' => 'label', 'label' => 'Danger zone'],
        ['label' => 'Delete project', 'danger' => true],
    ];

    $tabItems = [
        ['id' => 'overview', 'label' => 'Overview', 'panel' => 'Review the project overview.'],
        ['id' => 'activity', 'label' => 'Activity', 'count' => 4, 'panel' => 'See the latest project activity.'],
        ['id' => 'settings', 'label' => 'Settings', 'panel' => 'Manage project settings.'],
    ];

    $accordionItems = [
        ['id' => 'shipping', 'title' => 'When will my order ship?', 'content' => 'Orders usually ship within two business days.'],
        ['id' => 'returns', 'title' => 'Can I return an item?', 'content' => 'Returns are accepted within 30 days of delivery.'],
        ['id' => 'support', 'title' => 'How do I contact support?', 'content' => 'Contact our support team through the help center.'],
    ];
@endphp

@extends('layouts.app')

@section('content')
<main class="gallery-shell">
    <header class="gallery-header">
        {{-- x-data roots the Alpine tree: without it the toggle's directives are never processed. --}}
        <div class="gallery-row" x-data>
            <lyra:badge tone="brand" dot>Laravel 13 playground</lyra:badge>
            <lyra:button
                type="button"
                variant="secondary"
                size="sm"
                x-on:click="$store.theme.toggle()"
                x-bind:aria-label="$store.theme.dark ? 'Switch to light theme' : 'Switch to dark theme'"
            >
                <span x-show="! $store.theme.dark"><lyra:icon name="moon" :size="16" /></span>
                <span x-show="$store.theme.dark" x-cloak><lyra:icon name="sun" :size="16" /></span>
            </lyra:button>
        </div>
        <h1>Lyra Blade component gallery</h1>
        <p>Every component the package ships, rendered from the local Composer package with Alpine-powered interactions.</p>
    </header>

    <div class="gallery-layout">
        <div class="gallery-column">
            <section class="gallery-section" id="buttons">
                <h2>Buttons</h2>
                <div class="gallery-row">
                    <lyra:button variant="primary">Primary</lyra:button>
                    <lyra:button variant="secondary">Secondary</lyra:button>
                    <lyra:button variant="soft">Soft</lyra:button>
                    <lyra:button variant="ghost">Ghost</lyra:button>
                    <lyra:button variant="danger">Danger</lyra:button>
                </div>
            </section>

            <section class="gallery-section" id="forms">
                <h2>Forms</h2>
                <lyra:fieldset>
                    <x-slot:legend>Release details</x-slot:legend>
                    <x-slot:description>Prepare the next workspace build for review.</x-slot:description>

                    <lyra:form-row :columns="2">
                        <lyra:input
                            label="Release name"
                            hint="Visible in build history."
                            name="release_name"
                            value="August preview"
                        />
                        <lyra:select label="Target environment" name="environment">
                            <option>Preview</option>
                            <option>Staging</option>
                            <option>Production</option>
                        </lyra:select>
                    </lyra:form-row>

                    <lyra:time-input
                        label="Release window"
                        hint="Times use the workspace's local timezone."
                        name="release_time"
                        default-value="14:30"
                        min="09:00"
                        max="18:00"
                        :step="30"
                    />

                    <lyra:textarea
                        label="Release notes"
                        hint="Summarize what changed for reviewers."
                        name="release_notes"
                        rows="3"
                    >Updated workspace navigation and build status views.</lyra:textarea>

                    <lyra:stack gap="3">
                        <lyra:checkbox label="Include source maps" name="source_maps" checked />
                        <lyra:radio label="Publish as a preview" name="publish_mode" checked />
                        <lyra:switch label="Notify the release channel" name="notify_release" checked />
                    </lyra:stack>
                </lyra:fieldset>
            </section>

            <section class="gallery-section" id="segmented-control">
                <h2>Interactive Segmented Control</h2>
                <p>Use the arrow keys to switch the release activity range.</p>
                <lyra:segmented-control
                    label="Release activity range"
                    :options="[
                        ['value' => 'day', 'label' => 'Day'],
                        ['value' => 'week', 'label' => 'Week'],
                        ['value' => 'month', 'label' => 'Month'],
                    ]"
                    value="week"
                />
            </section>
        </div>

        <div class="gallery-grid">
            <section class="gallery-section" id="badges">
                <h2>Badges, tags, and icon</h2>
                <div class="gallery-row">
                    <lyra:badge tone="success" dot>Online</lyra:badge>
                    <lyra:badge tone="warning">Review</lyra:badge>
                    <lyra:tag>Design system</lyra:tag>
                    <lyra:icon name="sparkles" :size="24" title="Sparkles" />
                </div>
            </section>

            <section class="gallery-section" id="dropdown">
                <h2>Interactive Dropdown</h2>
                <p>Try mouse, keyboard, Escape, and click-away behavior.</p>
                <lyra:dropdown :items="$dropdownItems" align="end">
                    <x-slot:trigger>
                        <lyra:icon name="chevron-down" :size="16" />
                        Project actions
                    </x-slot:trigger>
                </lyra:dropdown>
            </section>

            <section class="gallery-section" id="dialog">
                <h2>Interactive Dialog</h2>
                <p>Open the dialog to preview a destructive confirmation flow.</p>
                <div x-data="{ dialogOpen: false }">
                    <lyra:button @click="dialogOpen = true">Open dialog</lyra:button>
                    <lyra:dialog x-model="dialogOpen" title="Delete project?">
                        This action cannot be undone.
                        <x-slot:footer>
                            <lyra:button variant="secondary" @click="dialogOpen = false">Cancel</lyra:button>
                            <lyra:button variant="danger" @click="dialogOpen = false">Confirm</lyra:button>
                        </x-slot:footer>
                    </lyra:dialog>
                </div>
            </section>

            <section class="gallery-section" id="drawer">
                <h2>Interactive Drawer</h2>
                <p>Open the drawer to review project details.</p>
                <div x-data="{ drawerOpen: false }">
                    <lyra:button @click="drawerOpen = true">Open drawer</lyra:button>
                    <lyra:drawer x-model="drawerOpen" title="Project details">
                        Review the project overview and current status from this drawer.
                        <x-slot:footer>
                            <lyra:button variant="secondary" @click="drawerOpen = false">Close</lyra:button>
                        </x-slot:footer>
                    </lyra:drawer>
                </div>
            </section>

            <section class="gallery-section" id="bottom-sheet">
                <h2>Interactive Bottom Sheet</h2>
                <p>Open the sheet to choose which workspace builds to include.</p>
                <div x-data="{ sheetOpen: false }">
                    <lyra:button @click="sheetOpen = true">Choose builds</lyra:button>
                    <lyra:bottom-sheet x-model="sheetOpen" title="Build selection">
                        Select the preview and staging builds for the release review.
                        <lyra:stack gap="3">
                            <lyra:checkbox label="Preview · Build #284" checked />
                            <lyra:checkbox label="Staging · Build #283" />
                            <lyra:button variant="secondary" @click="sheetOpen = false">Done</lyra:button>
                        </lyra:stack>
                    </lyra:bottom-sheet>
                </div>
            </section>

            <section class="gallery-section gallery-section--wide" id="tabs">
                <h2>Interactive Tabs</h2>
                <p>Use the arrow keys to move the roving focus between tabs.</p>
                <lyra:tabs active="overview" :items="$tabItems" />
            </section>

            <section class="gallery-section" id="accordion">
                <h2>Interactive Accordion</h2>
                <p>Open each question to reveal its answer.</p>
                <lyra:accordion default-open="shipping" :items="$accordionItems" />
            </section>

            <section class="gallery-section" id="tooltip">
                <h2>Interactive Tooltip</h2>
                <p>Hover or focus a trigger to show its tooltip, then press Escape to dismiss it.</p>
                <div class="gallery-row">
                    <lyra:tooltip tip="Copies the link to your clipboard">
                        <lyra:button>Copy link</lyra:button>
                    </lyra:tooltip>
                    <lyra:tooltip tip="Opens the settings panel" placement="bottom">
                        <lyra:button variant="secondary">Settings</lyra:button>
                    </lyra:tooltip>
                </div>
            </section>

            <section class="gallery-section" id="popover">
                <h2>Interactive Popover</h2>
                <p>Click to open the popover, then press Escape or click outside to dismiss it.</p>
                <lyra:popover aria-label="Display density" :width="280">
                    <x-slot:trigger>Display options</x-slot:trigger>
                    <p style="margin: 0 0 8px;">Choose how dense the table should feel.</p>
                    <lyra:button variant="secondary" style="margin-right: 8px;">Comfortable</lyra:button>
                    <lyra:button variant="secondary">Compact</lyra:button>
                </lyra:popover>
            </section>
        </div>

        <section class="gallery-section" id="feedback">
            <h2>Feedback</h2>
            <div class="gallery-grid">
                <lyra:alert tone="info">
                    <x-slot:icon><lyra:icon name="info" /></x-slot:icon>
                    <x-slot:title>Local package linked</x-slot:title>
                    Changes under <code>../blade</code> appear here without reinstalling Composer dependencies.
                </lyra:alert>

                <lyra:toast tone="success">
                    <x-slot:icon><lyra:icon name="circle-check" /></x-slot:icon>
                    Production assets built successfully.
                </lyra:toast>
            </div>
        </section>

        <section class="gallery-section" id="toasts">
            <h2>Interactive Toasts</h2>
            <p>Trigger live notifications for common release workflows. The info toast stays until closed.</p>
            <div class="gallery-row" x-data>
                <lyra:button x-on:click="$store.lyraToasts.success('Production assets built successfully.')">
                    Show success
                </lyra:button>
                <lyra:button variant="danger" x-on:click="$store.lyraToasts.error('Release failed its final quality check.')">
                    Show error
                </lyra:button>
                <lyra:button variant="secondary" x-on:click="$store.lyraToasts.info('Release notes are ready for review.', { duration: 0 })">
                    Show persistent info
                </lyra:button>
            </div>
        </section>

        <section class="gallery-section" id="cookie-banner">
            <h2>Interactive Cookie Banner</h2>
            <p>The notice stays hidden after a choice is saved in <code>lyra-cookie-consent</code>.</p>
            <lyra:cookie-banner
                aria-label="Cookie preferences"
                policy-href="#privacy"
                essentials-label="Use essentials"
                accept-label="Accept all cookies"
            >
                We use optional analytics cookies to improve release insights. <a href="#privacy">Read our privacy policy</a>.
            </lyra:cookie-banner>
        </section>

        <section class="gallery-section" id="choice-groups">
            <h2>Choice groups</h2>
            <div class="gallery-grid">
                <lyra:checkbox-group
                    label="Release preferences"
                    hint="Choose which updates should be included in your workspace feed."
                    :options="[
                        ['value' => 'builds', 'label' => 'Build results', 'hint' => 'Get notified when production builds finish.'],
                        ['value' => 'releases', 'label' => 'Release notes'],
                        ['value' => 'previews', 'label' => 'Preview deployments', 'disabled' => true],
                    ]"
                    :defaultValue="['builds']"
                    name="prefs"
                />

                <lyra:radio-group
                    label="Release plan"
                    direction="row"
                    :options="[
                        ['value' => 'preview', 'label' => 'Preview'],
                        ['value' => 'staged', 'label' => 'Staged'],
                        ['value' => 'production', 'label' => 'Production'],
                    ]"
                    value="staged"
                    name="plan"
                />
            </div>
        </section>

        <section class="gallery-section gallery-section--wide" id="dates-and-times">
            <h2>Dates and times</h2>
            <p>Coordinate a production deployment and its maintenance coverage from one release schedule.</p>

            <div class="gallery-grid">
                <lyra:card>
                    <x-slot:title>Production deployment</x-slot:title>
                    <p>Choose a weekday in the August release window while weekend changes are paused.</p>
                    <lyra:calendar
                        default-value="2026-08-18"
                        min="2026-08-10"
                        max="2026-08-31"
                        :disabled-dates="['2026-08-22', '2026-08-23']"
                        today-button
                    />
                </lyra:card>

                <lyra:card>
                    <x-slot:title>Observation window</x-slot:title>
                    <p>Reserve the deployment day and the following two days for release monitoring.</p>
                    <lyra:calendar
                        range
                        :default-value="['start' => '2026-08-18', 'end' => '2026-08-20']"
                        min="2026-08-10"
                        max="2026-08-31"
                    />
                </lyra:card>
            </div>

            <div class="gallery-grid">
                <lyra:card>
                    <x-slot:title>Deployment form</x-slot:title>
                    <lyra:date-picker
                        label="Production deployment date"
                        hint="Weekends are reserved for emergency changes."
                        default-value="2026-08-18"
                        min="2026-08-10"
                        max="2026-08-31"
                        name="deployment_date"
                    />
                </lyra:card>

                <lyra:card>
                    <x-slot:title>Release coverage</x-slot:title>
                    <lyra:date-range-picker
                        label="Observation period"
                        hint="Covers the deployment day and two days of monitoring."
                        :default-value="['start' => '2026-08-18', 'end' => '2026-08-20']"
                        min="2026-08-10"
                        max="2026-08-31"
                        name="observation_period"
                    />
                </lyra:card>

                <lyra:card>
                    <x-slot:title>Maintenance timing</x-slot:title>
                    <lyra:time-picker
                        label="Maintenance window start"
                        hint="August 18, in the workspace's local time."
                        default-value="22:00"
                        :step="30"
                        min="20:00"
                        max="23:30"
                    />
                </lyra:card>
            </div>

            <p>The three pickers open in a popover on desktop and switch automatically to a bottom sheet below 640px via <code>matchMedia</code>. Narrow the browser window to verify the responsive behavior.</p>
        </section>

        <section class="gallery-section gallery-section--wide" id="scheduling">
            <h2>Interactive scheduling</h2>
            <p>Plan a recurring release review, reserve a handoff slot, and keep weekly support coverage in sync.</p>

            <lyra:card>
                <x-slot:title>Release review cadence</x-slot:title>
                <p>Review the candidate every other Tuesday and Thursday through the production rollout.</p>
                <lyra:recurrence-selector
                    :value="[
                        'freq' => 'weekly',
                        'interval' => 2,
                        'byWeekday' => [2, 4],
                        'end' => ['type' => 'date', 'date' => '2026-10-01'],
                    ]"
                    start-date="2026-08-18"
                    :conflicts="[[
                        'date' => '2026-09-01',
                        'reason' => 'Production freeze',
                    ]]"
                />
            </lyra:card>

            <lyra:card>
                <x-slot:title>Deployment handoff</x-slot:title>
                <p>Reserve a 30-minute handoff with the release team in the workspace timezone.</p>
                <lyra:slot-picker
                    :slots="[
                        ['start' => '2026-08-18T12:00:00Z', 'end' => '2026-08-18T12:30:00Z'],
                        ['start' => '2026-08-18T13:30:00Z', 'end' => '2026-08-18T14:00:00Z'],
                        ['start' => '2026-08-18T15:00:00Z', 'end' => '2026-08-18T15:30:00Z'],
                        ['start' => '2026-08-19T14:00:00Z', 'end' => '2026-08-19T14:30:00Z'],
                    ]"
                    date="2026-08-18"
                    timezone="America/Sao_Paulo"
                    detected-zone="America/Sao_Paulo"
                    min="2026-08-18"
                    max="2026-08-31"
                />
            </lyra:card>

            <lyra:card>
                <x-slot:title>Release support coverage</x-slot:title>
                <p>Keep the workspace staffed during build review, deployment, and the post-release observation window.</p>
                <lyra:weekly-schedule-editor
                    :value="[
                        1 => [['start' => '09:00', 'end' => '17:00']],
                        2 => [
                            ['start' => '09:00', 'end' => '12:00'],
                            ['start' => '13:00', 'end' => '17:00'],
                        ],
                        3 => [['start' => '09:00', 'end' => '17:00']],
                        4 => [
                            ['start' => '09:00', 'end' => '12:00'],
                            ['start' => '13:00', 'end' => '17:00'],
                        ],
                        5 => [['start' => '09:00', 'end' => '15:00']],
                    ]"
                    :exceptions="[
                        ['date' => '2026-09-07', 'ranges' => []],
                        ['date' => '2026-09-08', 'ranges' => [['start' => '10:00', 'end' => '16:00']]],
                    ]"
                    :default-range="['start' => '09:00', 'end' => '17:00']"
                    name="release_support"
                />
            </lyra:card>
        </section>

        <section class="gallery-section gallery-section--wide" id="search-and-commands">
            <h2>Search and commands</h2>
            <p>Open the command palette with Cmd/Ctrl+K from anywhere in the workspace, or use inline mode to embed the same searchable panel directly in a page.</p>

            <div class="gallery-grid">
                <lyra:card>
                    <x-slot:title>Release destination</x-slot:title>
                    <lyra:combobox
                        label="Deployment target"
                        hint="Choose the workspace that will receive the August release."
                        value="production-south-america"
                        placeholder="Select a deployment target"
                        search-placeholder="Search workspaces…"
                        empty-message="No deployment targets found."
                        :options="[
                            ['value' => 'production-south-america', 'label' => 'Production · South America', 'hint' => 'Primary customer traffic', 'group' => 'Production'],
                            ['value' => 'production-north-america', 'label' => 'Production · North America', 'group' => 'Production'],
                            ['value' => 'staging-global', 'label' => 'Staging · Global', 'hint' => 'Final release candidate', 'group' => 'Pre-release'],
                            ['value' => 'preview-team', 'label' => 'Preview · Product team', 'group' => 'Pre-release'],
                        ]"
                    />
                </lyra:card>

                <lyra:card>
                    <x-slot:title>Maintenance time zone</x-slot:title>
                    <lyra:time-zone-picker
                        label="Release coordination zone"
                        hint="Offsets and local times stay current for every collaborator."
                        value="America/Sao_Paulo"
                        detected-zone="America/Sao_Paulo"
                        :recent-zones="['America/New_York', 'Europe/London']"
                    />
                </lyra:card>
            </div>

            <div class="gallery-grid">
                <lyra:card>
                    <x-slot:title>Workspace command palette</x-slot:title>
                    <div x-data="{ commandPaletteOpen: false }">
                        <lyra:button type="button" x-on:click="commandPaletteOpen = true">
                            Open command palette
                        </lyra:button>
                        <lyra:command-palette
                            x-model="commandPaletteOpen"
                            label="Workspace commands"
                            placeholder="Search workspace commands…"
                            search-label="Search workspace commands"
                            empty-message="No workspace commands match"
                            :groups="[
                                [
                                    'label' => 'Create',
                                    'items' => [
                                        ['id' => 'new-release', 'label' => 'Create release', 'hint' => 'Start a new release candidate', 'shortcut' => '⌘ N'],
                                        ['id' => 'new-build', 'label' => 'Run production build', 'hint' => 'Build from the approved commit', 'shortcut' => '⌘ B'],
                                    ],
                                ],
                                [
                                    'label' => 'Navigate',
                                    'items' => [
                                        ['id' => 'release-dashboard', 'label' => 'Go to release dashboard', 'shortcut' => 'G D'],
                                        ['id' => 'build-history', 'label' => 'Open build history', 'shortcut' => 'G B'],
                                    ],
                                ],
                            ]"
                        />
                    </div>
                </lyra:card>

                <lyra:card>
                    <x-slot:title>Embedded release actions</x-slot:title>
                    <lyra:command-palette
                        inline
                        label="Release actions"
                        placeholder="Filter release actions…"
                        search-label="Filter release actions"
                        empty-message="No release actions match"
                        :groups="[
                            [
                                'label' => 'Release workflow',
                                'items' => [
                                    ['id' => 'review-checks', 'label' => 'Review quality checks', 'hint' => '12 checks ready for review', 'shortcut' => 'R C'],
                                    ['id' => 'publish-notes', 'label' => 'Publish release notes', 'shortcut' => 'P N'],
                                    ['id' => 'schedule-window', 'label' => 'Schedule maintenance window', 'shortcut' => 'S W'],
                                ],
                            ],
                        ]"
                    />
                </lyra:card>
            </div>
        </section>

        <section class="gallery-section gallery-section--wide" id="navigation">
            <h2>Navigation</h2>
            <lyra:table-of-contents
                label="Gallery sections"
                active-id="navigation"
                :items="[
                    ['id' => 'forms', 'label' => 'Forms'],
                    ['id' => 'navigation', 'label' => 'Navigation'],
                    ['id' => 'page-structure', 'label' => 'Page structure'],
                    ['id' => 'data-display', 'label' => 'Data display'],
                    ['id' => 'files', 'label' => 'Files'],
                ]"
            />
            <lyra:navbar :sticky="false" nav-label="Workspace navigation">
                <x-slot:brand>Lyra releases</x-slot:brand>
                <x-slot:nav>
                    <lyra:nav-link href="#" active>Overview</lyra:nav-link>
                    <lyra:nav-link href="#">Builds</lyra:nav-link>
                    <lyra:nav-link href="#">Settings</lyra:nav-link>
                </x-slot:nav>
                <x-slot:actions>
                    <lyra:button size="sm">New build</lyra:button>
                </x-slot:actions>
            </lyra:navbar>

            <lyra:stack gap="5">
                <lyra:breadcrumb :items="[
                    ['label' => 'Workspaces', 'href' => '#'],
                    ['label' => 'Lyra DS', 'href' => '#'],
                    ['label' => 'August release'],
                ]" />
                <lyra:stepper
                    :steps="['Draft', 'Review', 'Build', 'Release']"
                    :active="1"
                />
                <lyra:pagination :page="3" :total="8" url="?page={page}" />
                <lyra:bottom-nav :items="[
                    ['icon' => '⌂', 'label' => 'Overview', 'active' => true],
                    ['icon' => '✓', 'label' => 'Builds'],
                    ['icon' => '⚙', 'label' => 'Settings'],
                ]" />
            </lyra:stack>
        </section>

        <section class="gallery-section gallery-section--wide" id="workspace-navigation">
            <h2>Interactive Workspace Navigation</h2>
            <p>Open the workspace menu or collapse the release navigation group.</p>
            <div class="gallery-grid">
                <lyra:workspace-switcher
                    id="gallery-workspace-switcher"
                    :workspaces="[
                        ['id' => 'lyra', 'name' => 'Lyra DS', 'plan' => 'Pro', 'members' => 8],
                        ['id' => 'storefront', 'name' => 'Storefront', 'plan' => 'Team', 'members' => 14],
                        ['id' => 'labs', 'name' => 'Product Labs', 'plan' => 'Free', 'members' => 3],
                    ]"
                    current="lyra"
                    create
                    create-label="Create workspace"
                />

                <lyra:sidebar-group
                    label="Release workspace"
                    :items="[
                        ['id' => 'overview', 'label' => 'Overview', 'icon' => '⌂', 'active' => true],
                        ['id' => 'builds', 'label' => 'Builds', 'icon' => '✓', 'badge' => 3],
                        ['id' => 'settings', 'label' => 'Settings', 'icon' => '⚙'],
                    ]"
                    collapsible
                />
            </div>
        </section>

        <section class="gallery-section gallery-section--wide" id="app-sidebar">
            <h2>Interactive app sidebar</h2>
            <p>Collapse the workspace navigation into a rail while keeping every destination available to assistive technology.</p>
            @php
                $appSidebarIcon = static fn (string $name): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString(
                    \Illuminate\Support\Facades\Blade::render('<lyra:icon name="'.$name.'" :size="18" />'),
                );
            @endphp
            <lyra:app-sidebar
                brand="Lyra releases"
                :width="280"
                :groups="[
                    [
                        'heading' => 'Release workspace',
                        'items' => [
                            ['id' => 'release-overview', 'label' => 'Overview', 'icon' => $appSidebarIcon('layout-dashboard'), 'active' => true],
                            ['id' => 'release-builds', 'label' => 'Builds', 'icon' => $appSidebarIcon('package'), 'badge' => 3],
                            ['id' => 'release-deployments', 'label' => 'Deployments', 'icon' => $appSidebarIcon('rocket')],
                        ],
                    ],
                    [
                        'heading' => 'Manage',
                        'items' => [
                            ['id' => 'release-team', 'label' => 'Team', 'icon' => $appSidebarIcon('users')],
                            ['id' => 'release-settings', 'label' => 'Settings', 'icon' => $appSidebarIcon('settings')],
                        ],
                    ],
                ]"
                collapsible
            >
                <x-slot:footer>
                    <div class="lyra-appsidebar__user">
                        <lyra:icon name="user" :size="20" />
                        <div>
                            <div class="lyra-appsidebar__user-name">Maya Chen</div>
                            <div class="lyra-appsidebar__user-role">Maintainer</div>
                        </div>
                    </div>
                </x-slot:footer>
            </lyra:app-sidebar>
        </section>

        <section class="gallery-section gallery-section--wide" id="page-structure">
            <h2>Page structure</h2>
            <lyra:shell
                main-as="div"
                scroll="content"
                sidebar-label="Release workspace"
                aside-label="Build summary"
                :sidebar-width="180"
                :aside-width="200"
            >
                <x-slot:sidebar>
                    <lyra:stack gap="2">
                        <strong>Lyra DS</strong>
                        <span>Overview</span>
                        <span>Builds</span>
                        <span>Releases</span>
                    </lyra:stack>
                </x-slot:sidebar>
                <x-slot:topbar>Preview workspace · Build #284</x-slot:topbar>

                <lyra:page-header title="August release" title-as="h3">
                    <x-slot:eyebrow>Workspace / Lyra DS</x-slot:eyebrow>
                    <x-slot:description>Review the candidate build before promoting it to production.</x-slot:description>
                    <x-slot:actions>
                        <lyra:button size="sm">Run build</lyra:button>
                    </x-slot:actions>
                </lyra:page-header>

                <lyra:action-bar :count="3" label="checks selected">
                    Ready for the release review.
                    <x-slot:actions>
                        <lyra:button variant="secondary" size="sm">Approve checks</lyra:button>
                    </x-slot:actions>
                </lyra:action-bar>

                <x-slot:aside>
                    <lyra:stack gap="2">
                        <strong>Build #284</strong>
                        <span>12 checks passed</span>
                        <span>Updated 4 minutes ago</span>
                    </lyra:stack>
                </x-slot:aside>
            </lyra:shell>

            <lyra:footer links-label="Release resources">
                <x-slot:brand>Lyra workspace</x-slot:brand>
                <x-slot:note>Build previews are retained for 30 days.</x-slot:note>
                <x-slot:links>
                    <a href="#">Release notes</a>
                    <a href="#">Build history</a>
                    <a href="#">Support</a>
                </x-slot:links>
            </lyra:footer>
        </section>

        <section class="gallery-section gallery-section--wide" id="data-display">
            <h2>Data display</h2>
            <lyra:table
                :columns="[
                    ['key' => 'release', 'label' => 'Release'],
                    ['key' => 'environment', 'label' => 'Environment'],
                    ['key' => 'status', 'label' => 'Status'],
                    ['key' => 'checks', 'label' => 'Checks', 'align' => 'right'],
                ]"
                :rows="[
                    ['release' => 'Build #284', 'environment' => 'Preview', 'status' => 'Ready', 'checks' => '12 / 12'],
                    ['release' => 'Build #283', 'environment' => 'Staging', 'status' => 'Reviewing', 'checks' => '10 / 12'],
                    ['release' => 'Build #282', 'environment' => 'Production', 'status' => 'Released', 'checks' => '12 / 12'],
                ]"
                hover
            />

            <div class="gallery-grid">
                <lyra:card>
                    <x-slot:title>Release owner</x-slot:title>
                    <lyra:stack gap="4">
                        <lyra:person-cell name="Maya Chen" detail="Workspace maintainer" />
                        <lyra:separator />
                        <lyra:stack direction="row" gap="3" align="center">
                            <lyra:avatar name="Noah Williams" status="online" status-label="Available" />
                            <span>Reviewer available</span>
                        </lyra:stack>
                    </lyra:stack>
                </lyra:card>

                <lyra:segmented-ring
                    :segments="[
                        ['label' => 'Passed', 'value' => 12, 'tone' => 'success'],
                        ['label' => 'Pending', 'value' => 3, 'tone' => 'warning'],
                        ['label' => 'Blocked', 'value' => 1, 'tone' => 'danger'],
                    ]"
                    :total="16"
                    center-value="16"
                    center-label="checks"
                    size="md"
                />

                <lyra:empty-state>
                    <x-slot:icon><lyra:icon name="circle-check" :size="28" /></x-slot:icon>
                    <x-slot:title>No blocked deployments</x-slot:title>
                    <x-slot:description>Every workspace is clear for the next release window.</x-slot:description>
                    <x-slot:action><lyra:button variant="secondary" size="sm">View history</lyra:button></x-slot:action>
                </lyra:empty-state>
            </div>
        </section>

        <section class="gallery-section gallery-section--wide" id="build-table">
            <h2>Interactive build table</h2>
            <p>Select release candidates and sort the served rows by build, environment, status, or duration.</p>
            <lyra:data-table
                :columns="[
                    ['key' => 'build', 'label' => 'Build', 'sortable' => true, 'sortValueKey' => 'buildNumber'],
                    ['key' => 'environment', 'label' => 'Environment', 'sortable' => true],
                    ['key' => 'status', 'label' => 'Status', 'sortable' => true],
                    ['key' => 'duration', 'label' => 'Duration', 'align' => 'right', 'sortable' => true, 'sortValueKey' => 'durationSeconds'],
                ]"
                :rows="[
                    ['id' => 'build-282', 'build' => 'Build #282', 'buildNumber' => 282, 'environment' => 'Production', 'status' => 'Released', 'duration' => '7m 18s', 'durationSeconds' => 438],
                    ['id' => 'build-284', 'build' => 'Build #284', 'buildNumber' => 284, 'environment' => 'Preview', 'status' => 'Ready', 'duration' => '6m 42s', 'durationSeconds' => 402],
                    ['id' => 'build-281', 'build' => 'Build #281', 'buildNumber' => 281, 'environment' => 'Production', 'status' => 'Released', 'duration' => '8m 05s', 'durationSeconds' => 485],
                    ['id' => 'build-283', 'build' => 'Build #283', 'buildNumber' => 283, 'environment' => 'Staging', 'status' => 'Reviewing', 'duration' => '7m 03s', 'durationSeconds' => 423],
                ]"
                :sorting="['key' => 'build', 'dir' => 'desc']"
                :selected="['build-284']"
                :labels="[
                    'selectAll' => 'Select every build',
                    'selectRow' => 'Select {build}',
                ]"
                selectable
                client-sort
                sticky-header
                :max-height="280"
                hover
            />
        </section>

        <section class="gallery-section gallery-section--wide" id="files">
            <h2>Files</h2>
            <p>Upload release artifacts, then browse the files attached to this workspace.</p>
            <lyra:file-upload
                label="Upload release artifacts"
                hint="PDF, ZIP, or JSON · Up to 10 MB per file"
                accept=".pdf,.zip,.json"
                :max-size-m-b="10"
                :default-items="[[
                    'id' => 'release-notes',
                    'name' => 'release-notes.pdf',
                    'size' => 184320,
                    'progress' => 100,
                    'status' => 'done',
                ]]"
            />

            <lyra:file-manager
                :path="['Workspaces', 'Lyra DS', 'August release']"
                :files="[
                    ['id' => 'builds', 'name' => 'Build artifacts', 'type' => 'folder', 'items' => 3, 'updated' => 'Today', 'shared' => true],
                    ['id' => 'notes', 'name' => 'release-notes.pdf', 'size' => 184320, 'updated' => '10 minutes ago'],
                    ['id' => 'manifest', 'name' => 'build-manifest.json', 'size' => 12840, 'updated' => '24 minutes ago'],
                    ['id' => 'bundle', 'name' => 'workspace-preview.zip', 'size' => 5242880, 'updated' => '1 hour ago'],
                ]"
                search-placeholder="Search release files…"
            />
        </section>

        <section class="gallery-section gallery-section--wide" id="code-block">
            <h2>Interactive Code Block</h2>
            <p>Copy the release configuration or scroll through it with line numbers.</p>
            <lyra:code-block
                language="PHP"
                line-numbers
                copy-label="Copy code"
                copied-label="Copied"
                copy-text="$release = ['environment' => 'production', 'checks' => 12];"
            >$release = [
    'environment' => 'production',
    'checks' => 12,
];</lyra:code-block>
        </section>

        <section class="gallery-section" id="feedback-status">
            <h2>Feedback and status</h2>
            <div class="gallery-grid">
                <lyra:card>
                    <x-slot:title>Build progress</x-slot:title>
                    <lyra:stack gap="3">
                        <span>Compiling production assets · 72%</span>
                        <lyra:progress :value="72" aria-label="Production build progress" />
                        <lyra:stack direction="row" gap="2" align="center">
                            <lyra:spinner size="sm" />
                            <span>Running final checks</span>
                        </lyra:stack>
                    </lyra:stack>
                </lyra:card>

                <lyra:card>
                    <x-slot:title>Loading release activity</x-slot:title>
                    <lyra:stack gap="3">
                        <lyra:skeleton width="45%" :height="18" />
                        <lyra:skeleton width="100%" :height="12" />
                        <lyra:skeleton width="78%" :height="12" />
                    </lyra:stack>
                </lyra:card>
            </div>
        </section>

        <section class="gallery-section" id="layout-primitives">
            <h2>Layout primitives</h2>
            <lyra:container :max="720">
                <lyra:stack gap="4">
                    <span>Release workspaces</span>
                    <lyra:separator>
                        <x-slot:label>Active builds</x-slot:label>
                    </lyra:separator>
                    <lyra:grid :columns="3" gap="3">
                        <lyra:card>Preview · Build #284</lyra:card>
                        <lyra:card>Staging · Build #283</lyra:card>
                        <lyra:card>Production · Build #282</lyra:card>
                    </lyra:grid>
                </lyra:stack>
            </lyra:container>
        </section>

        <section class="gallery-section" id="identity">
            <h2>Identity</h2>
            <div class="gallery-row">
                <lyra:brand mark="/img/lyra-mark.svg" href="#" :size="32">Lyra workspace</lyra:brand>
                <lyra:icon-button label="Open workspace settings" variant="soft">
                    <lyra:icon name="settings" :size="18" />
                </lyra:icon-button>
            </div>
        </section>

        <section class="gallery-section" id="cards-stats">
            <h2>Cards and stats</h2>
            <div class="gallery-grid">
                <lyra:card>
                    <x-slot:title>Release snapshot</x-slot:title>
                    This card uses the package's structured title and body slots.
                    <x-slot:footer>
                        <lyra:tag>Blade</lyra:tag>
                    </x-slot:footer>
                </lyra:card>

                <lyra:card>
                    <lyra:stat direction="up">
                        <x-slot:label>Components rendered</x-slot:label>
                        <x-slot:value>10</x-slot:value>
                        <x-slot:delta>All systems go</x-slot:delta>
                    </lyra:stat>
                </lyra:card>
            </div>
        </section>

        <lyra:toast-stack />
    </div>
</main>
@endsection
