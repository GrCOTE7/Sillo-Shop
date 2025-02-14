<?php

use Barryvdh\Debugbar\Facades\Debugbar;
include_once 'test.php'; ?>

@section('title', __('Test'))
<div class="container mx-auto">

    <x-header title="{{ __('Tests') }}" separator progress-indicator>
        <x-slot:actions>
            {{-- <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce.300ms="search" clearable
                icon="o-magnifying-glass" /> --}}
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    {{-- <img src="{{ asset('storage/imgs/test-tube-icon.svg') }}" alt="Description de l'image"> --}}
    {{-- <img src="{{ asset('storage/photos/test-icon.svg') }}" alt="Description de l'image"> --}}

    <x-card separator class="mb-6 border-4 border-zinc-900">

        @foreach ($subjects as $subject)

            <x-list-item :item="$subject" value="title" sub-value="description" actual="actual" proposed="proposeds">
                <x-slot:avatar>
                    {{ Debugbar::info($subject) }}
                    <x-badge value="{{ ucfirst(strtolower($subject['state'])) }}"
                        class="text-black badge-{{ $subject['stateColor'] }}" />
                </x-slot:avatar>
                <x-slot:actions class="space-y-2 w-50% !text-left !justify-start">
                    <div class="space-y-2 w-50% !text-left !justify-start">
                        <ul class="space-y-2 w-50% !text-left !justify-start">Situation actuelle :</ul>

                        <li class="space-y-2 w-50% !text-left !justify-start">{{ $subject['actual'] }}</li>

                        <hr class='my-3'>
                        <ul class="space-y-2 w-50% !text-left !justify-start">Situation proposée :</ul>

                        <li class="space-y-2 w-50% !text-left !justify-start">
                            {{ $subject['proposeds'][0][0] }}
                        </li>

                    </div>
                </x-slot:actions>
            </x-list-item>

        @endforeach

    </x-card>

</div>
