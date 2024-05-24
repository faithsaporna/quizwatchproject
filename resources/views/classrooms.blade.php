@extends('layouts.app')
@section('title', 'Classrooms')

@section('content')
{{-- Class Function Buttons --}}
<div class="flex flex-row justify-between md:justify-end md:space-x-6 lg:space-x-12">
    <button type="button" id="joinClass"
        class="flex flex-row items-center px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-blue-600 hover:bg-blue-700 active:bg-blue-600">
        Join a class
        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 inline stroke-white stroke-1">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.36364 13.5C6.36364 13.7761 6.58749 14 6.86364 14H13.5C14.3284 14 15 13.3284 15 12.5V2.5C15 1.67157 14.3284 1 13.5 1H3.5C2.67157 1 2 1.67157 2 2.5V9.13636C2 9.41251 2.22386 9.63636 2.5 9.63636C2.77614 9.63636 3 9.41251 3 9.13636V2.5C3 2.22386 3.22386 2 3.5 2H13.5C13.7761 2 14 2.22386 14 2.5V12.5C14 12.7761 13.7761 13 13.5 13H6.86364C6.58749 13 6.36364 13.2239 6.36364 13.5Z"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 5.5C11 5.22386 10.7761 5 10.5 5H5.5C5.22386 5 5 5.22386 5 5.5C5 5.77614 5.22386 6 5.5 6H9.29289L1.14645 14.1464C0.951184 14.3417 0.951184 14.6583 1.14645 14.8536C1.34171 15.0488 1.65829 15.0488 1.85355 14.8536L10 6.70711V10.5C10 10.7761 10.2239 11 10.5 11C10.7761 11 11 10.7761 11 10.5V5.5Z"/>
        </svg>            
    </button>
    <button type="button" id="createClass"
        class="flex flex-row items-center px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-green-600 hover:bg-green-700 active:bg-green-600">
        Create a class
        <svg viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-2 inline stroke-white stroke-1">
            <path d="M4 0C4.27614 0 4.5 0.223858 4.5 0.5V3.5H7.5C7.77614 3.5 8 3.72386 8 4C8 4.27614 7.77614 4.5 7.5 4.5H4.5V7.5C4.5 7.77614 4.27614 8 4 8C3.72386 8 3.5 7.77614 3.5 7.5V4.5H0.5C0.223858 4.5 0 4.27614 0 4C0 3.72386 0.223858 3.5 0.5 3.5H3.5V0.5C3.5 0.223858 3.72386 0 4 0Z"/>
        </svg>
    </button>
</div>

{{-- Created Classrooms --}}
<p class="mt-6 font-sans text-lg font-semibold md:text-xl lg:text-2xl">Created Classrooms</p>
<div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 lg:grid-cols-3">
    @if(count($owned_classrooms) == 0)
        <p class="mt-8 mb-16 font-sans text-xl font-semibold text-gray-700 text-center md:col-span-2 md:text-2xl lg:col-span-3 lg:text-4xl">
            You haven't created any class yet
        </p>
    @endif
    @foreach($owned_classrooms as $classroom)
        <x-cards.classroom 
            backgroundColor="{{$classroom->color}}" 
            name="{{$classroom->name}}" 
            code="{{$classroom->code}}" 
            users="{{count($classroom->users)}}" 
            description="{{$classroom->description}}"
        />
    @endforeach
</div>

{{-- Joined Classrooms --}}
<p class="mt-6 font-sans text-lg font-semibold md:text-xl lg:text-2xl">Joined Classrooms</p>
<div class="grid grid-cols-1 md:grid-cols-2 md:gap-4 lg:grid-cols-3 items-center justify-center">
    @if(count($joined_classrooms) == 0)
        <p class="mt-8 font-sans text-xl font-semibold text-gray-700 text-center md:col-span-2 md:text-2xl lg:col-span-3 lg:text-4xl">
            You haven't joined any class yet
        </p>
    @endif
    @foreach($joined_classrooms as $classroom)
        <x-cards.classroom 
            backgroundColor="{{$classroom->color}}" 
            name="{{$classroom->name}}" 
            code="{{$classroom->code}}" 
            users="{{count($classroom->users)}}"
            section="{{$classroom->section->name}}"
            description="{{$classroom->description}}"
        />
    @endforeach
</div>

{{-- Modals --}}
<x-modals.createclass/>
<x-modals.joinclass/>

@endsection