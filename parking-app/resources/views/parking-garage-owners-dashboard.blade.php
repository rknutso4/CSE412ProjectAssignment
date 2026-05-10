<x-parking-garage-owners-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Parking Garage') }}
    </h2>
    <form method="POST" action="{{ route('parking-garages-store') }}">
        @csrf
        <!-- Latitude -->
        <div>
            <x-input-label for="latitude" :value="__('Latitude')" />
            <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude" :value="old('latitude')" required autofocus autocomplete="latitude" />
            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
        </div>
        <!-- Latitude -->
        <div>
            <x-input-label for="longitude" :value="__('Longitude')" />
            <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude" :value="old('longitude')" required autofocus autocomplete="longitude" />
            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
        </div>
        <!-- Total_floors -->
        <div>
            <x-input-label for="total_floors" :value="__('Total floors')" />
            <x-text-input id="total_floors" class="block mt-1 w-full" type="text" name="total_floors" :value="old('total_floors')" required autofocus autocomplete="total_floors" />
            <x-input-error :messages="$errors->get('total_floors')" class="mt-2" />
        </div>
        <!-- Total_parking_spaces_per_floor -->
        <div>
            <x-input-label for="total_parking_spaces_per_floor" :value="__('Total parking spaces per floor')" />
            <x-text-input id="total_parking_spaces_per_floor" class="block mt-1 w-full" type="text" name="total_parking_spaces_per_floor" :value="old('total_parking_spaces_per_floor')" required autofocus autocomplete="total_parking_spaces_per_floor" />
            <x-input-error :messages="$errors->get('total_parking_spaces_per_floor')" class="mt-2" />
        </div>
        <!-- Day_start_time -->
        <div>
            <x-input-label for="day_start_time" :value="__('Day start time')" />
            <x-text-input id="day_start_time" class="block mt-1 w-full" type="text" name="day_start_time" :value="old('day_start_time')" required autofocus autocomplete="day_start_time" />
            <x-input-error :messages="$errors->get('day_start_time')" class="mt-2" />
        </div>
        <!-- Day_end_time -->
        <div>
            <x-input-label for="day_end_time" :value="__('Day end time')" />
            <x-text-input id="day_end_time" class="block mt-1 w-full" type="text" name="day_end_time" :value="old('day_end_time')" required autofocus autocomplete="day_end_time" />
            <x-input-error :messages="$errors->get('day_end_time')" class="mt-2" />
        </div>
        <!-- Cost_per_hour -->
        <div>
            <x-input-label for="cost_per_hour" :value="__('Cost per hour')" />
            <x-text-input id="cost_per_hour" class="block mt-1 w-full" type="text" name="cost_per_hour" :value="old('cost_per_hour')" required autofocus autocomplete="cost_per_hour" />
            <x-input-error :messages="$errors->get('cost_per_hour')" class="mt-2" />
        </div>
        <!-- Minimum_cost_per_hour -->
        <div>
            <x-input-label for="minimum_cost_per_hour" :value="__('Minimum cost per hour')" />
            <x-text-input id="minimum_cost_per_hour" class="block mt-1 w-full" type="text" name="minimum_cost_per_hour" :value="old('minimum_cost_per_hour')" required autofocus autocomplete="minimum_cost_per_hour" />
            <x-input-error :messages="$errors->get('minimum_cost_per_hour')" class="mt-2" />
        </div>
        
        

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Register Parking Garage') }}
            </x-primary-button>
        </div>
    </form>
    
</x-parking-garage-owners-app-layout>
