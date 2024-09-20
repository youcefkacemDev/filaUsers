@extends('layout.app')
@section('content')
    <div>
        <livewire:nav-bar />
    </div>
    <div>
        <flux:dropdown>
            <button type="button"
                class="shadow-lg m-10 px-6 py-3 bg-sky-400 border hover:bg-sky-500 active:bg-sky-700 rounded-lg font-bold transition-all text-white">options</button>
            <nav popover class="rounded-lg text-white font-bold">
                <div class="bg-sky-300 p-3 text-left w-52 hover:bg-sky-500 transition-all">
                    <a href="#">try</a>
                </div>
                <div class="bg-sky-300 p-3 text-left w-52 hover:bg-sky-500 transition-all">
                    <a href="#">next</a>
                </div>
                <div class="bg-sky-300 p-3 text-left w-52 hover:bg-sky-500 transition-all">
                    <a href="#">here</a>
                </div>
            </nav>
        </flux:dropdown>
    </div>
@endsection
