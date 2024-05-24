@extends('layouts.app')
@section('title', 'Assessment')

@section('header')
@vite('resources/js/section_average_chart.js')
@endsection

@section('content')

<h3 class="text-xl font-bold text-black">{{$assessment->classroom->name}}</h3>
<p class="text-md font-semibold text-gray-700">{{$assessment->classroom->code}}</p>

{{-- Cards --}}
<div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
    <x-cards.dashboard iconBackgroundColor="bg-blue-700" title="Total Responses" value="{{count($assessment->answers)}}" defaultIcon="false">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"  class="h-12 w-12 fill-white">
            <path d="M320-280q17 0 28.5-11.5T360-320q0-17-11.5-28.5T320-360q-17 0-28.5 11.5T280-320q0 17 11.5 28.5T320-280Zm0-160q17 0 28.5-11.5T360-480q0-17-11.5-28.5T320-520q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0-160q17 0 28.5-11.5T360-640q0-17-11.5-28.5T320-680q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm120 320h240v-80H440v80Zm0-160h240v-80H440v80Zm0-160h240v-80H440v80ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/>
        </svg>
    </x-card.dashboard>
    <x-cards.dashboard iconBackgroundColor="bg-green-600" title="Highest Score" value="{{count($assessment->answers) >= 1 ? $assessment->answers[0]->score.' / '.$assessment->total : 'None'}}" defaultIcon="false">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"  class="h-12 w-12 fill-white">
            <path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/>
        </svg>
    </x-card.dashboard>
    <x-cards.dashboard iconBackgroundColor="bg-orange-600" title="Assessment Average" value="{{($assessment->answers->avg('score') / $assessment->total) * 100}} %" defaultIcon="false">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"  class="h-12 w-12 fill-white">
            <path d="M240-160v-80l260-240-260-240v-80h480v120H431l215 200-215 200h289v120H240Z"/>
        </svg>
    </x-card.dashboard>
</div>

<div class="mt-6 flex flex-col space-y-3">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <p class="font-sans text-xl font-semibold text-gray-800">{{$assessment->title}}</p>
        <div class="flex flex-row space-x-4 mt-2 md:mt-0">
            <button type="button" id="viewAssessment" onclick="previewForm()"
                class="flex flex-row items-center px-2.5 lg:px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-blue-600 hover:bg-blue-700 active:bg-blue-600">
                View assessment
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="h-6 w-6 ml-2 inline fill-white">
                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                </svg>
            </button>
            <button type="button" id="deleteAssessment"
                class="flex flex-row items-center px-2.5 lg:px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-red-600 hover:bg-red-700 active:bg-red-600">
                Delete assessment
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="h-6 w-6 ml-2 inline fill-white">
                    <path d="M600-240v-80h160v80H600Zm0-320v-80h280v80H600Zm0 160v-80h240v80H600ZM120-640H80v-80h160v-60h160v60h160v80h-40v360q0 33-23.5 56.5T440-200H200q-33 0-56.5-23.5T120-280v-360Zm80 0v360h240v-360H200Zm0 0v360-360Z"/>
                </svg>
            </button>
        </div>
    </div>
    <p class="font-sams text-lg text-gray-700 font-semibold">{{$assessment->created_at->format('F j, Y')}}</p>
    <p class="font-sams text-md text-gray-700">{{$assessment->description}}</p>
</div>

<form action="/classrooms/{{$assessment->classroom->code}}/assessments/builder/preview" method="POST" id="previewForm" target="_blank">
    @csrf
    <input type="text" id="previewData" class="hidden" name="data" value="{{$assessment->data}}">
    <input type="text" id="previewTitle" class="hidden" name="title" value="{{$assessment->title}}">
    <input type="text" id="previewDescription" class="hidden" name="description" value="{{$assessment->description}}">
</form>

<form action="/assessment/delete" method="POST" id="deleteForm">
    @csrf
    <input type="text" id="id" name="id" class="hidden" value="{{$assessment->id}}">
</form>

<div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-5 w-full justify-center items-start">
    {{-- Average Score per Section --}}
    <div class="grid lg:col-span-3 bg-white shadow-[0_2px_15px_-6px_rgba(0,0,0,0.2)] px-6 py-8 w-full min-h-96 rounded-lg font-[sans-serif] overflow-hidden mt-4">
        <input type="text" class="hidden" id="sectionAverage" value="{{json_encode($assessment->getSectionAverage())}}">
        <canvas id="sectionAverageChart"></canvas>
    </div>

    {{-- Answers --}}
    <div class="grid lg:col-span-2 bg-white shadow-[0_2px_15px_-6px_rgba(0,0,0,0.2)] px-6 py-8 w-full lg:max-w-sm rounded-lg font-[sans-serif] overflow-y-scroll mt-4">
        <div class="flex items-center">
            <h3 class="text-xl font-bold flex-1 text-black">User Score</h3>
        </div>
        <div class="flex flex-col space-y-2 mt-4 min-h-96">
            @foreach($assessment->classroom->users as $user)
            @if($user->pivot->owner == 0)
                <x-cards.userscore
                    profile="{{$user->profile}}"
                    name="{{$user->name}}"
                    section="{{$user->section->name}}"
                    status="{{$assessment->getStatusByUser($user->id) == 'Marked' ? $assessment->getScoreByUser($user->id).' / '.$assessment->total: $assessment->getStatusByUser($user->id)}}"
                    href="{{'/classrooms/'.$assessment->classroom->code.'/assessments/grade/'.$assessment->id.'/user/'.$user->id}}"
                />
            @endif
        @endforeach
        </div>
    </div>

</div>

<script>
    function previewForm(){
        document.getElementById('previewForm').submit();
    }
    function deleteAssessment(){
        document.getElementById('deleteForm').submit();
    }
</script>


{{-- Modals --}}
<x-modals.confirm 
    trigger="deleteAssessment"
    title="Confirm Delete"
    content="Deleting this will delete the assessment forever. Continue?"
    confirmColor="bg-red-500"
    action="deleteAssessment()"
/>

{{-- <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-5 w-full justify-center items-start">
    <div class="grid lg:col-span-3 bg-white shadow-[0_2px_15px_-6px_rgba(0,0,0,0.2)] px-6 py-8 w-full rounded-lg font-[sans-serif] overflow-hidden mt-4">
        <div class="flex items-center">
            <h3 class="text-xl font-bold flex-1 text-black">Assessments</h3>
        </div>
        <div class="min-h-96 mt-8 space-y-4">
            @if(count($classroom->assessments) == 0)
                <p class="mt-16 text-3xl font-semibold text-gray-700 text-center">No assessments yet</p>
            @endif
            @foreach($classroom->assessments as $assessment)
                <x-cards.assessment
                    href="/classrooms/{{$classroom->code}}/assessments/view/{{$assessment->id}}"
                    title="{{$assessment->title}}"
                    date="{{$assessment->created_at->format('F j, Y')}}"
                    total="{{$assessment->total}}"
                    description="{{$assessment->description}}"
                />
            @endforeach
        </div>
    </div>
    
    <div class="grid lg:col-span-2 bg-white shadow-[0_2px_15px_-6px_rgba(0,0,0,0.2)] px-6 py-8 w-full lg:max-w-sm rounded-lg font-[sans-serif] overflow-y-scroll mt-4">
        <h3 class="text-xl font-bold text-black">Users</h3>
        <div class="flex flex-col mt-8 space-y-4 h-96">
            @foreach ($classroom->users as $user)
                <x-cards.user 
                    profile="https://img.freepik.com/free-psd/3d-render-avatar-character_23-2150611768.jpg" 
                    name="{{$user->name}}" 
                    email="{{$user->email}}" 
                    value="{{$user->section != null ? $user->section->name : ''}}"
                />
            @endforeach
        </div>
    </div>
</div> --}}

@endsection