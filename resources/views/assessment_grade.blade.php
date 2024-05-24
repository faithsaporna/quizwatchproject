@extends('layouts.app')
@section('title', 'Grade Assessment')

@section('content')

<h3 class="text-xl font-bold text-black">{{$answer->assessment->classroom->name}}</h3>
<p class="text-md font-semibold text-gray-700">{{$answer->assessment->classroom->code}}</p>

<div class="mt-6 flex flex-col space-y-3">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <p class="font-sans text-xl font-semibold text-gray-800">{{$answer->assessment->title}}</p>
        <div class="flex flex-row space-x-4 mt-2 md:mt-0">
            <button type="button" id="gradeAssessment"
                class="flex flex-row items-center px-2.5 lg:px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-green-600 hover:bg-green-700 active:bg-green-600">
                Grade assessment
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="h-6 w-6 ml-2 inline fill-white">
                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="flex flex-row justify-between items-center">
        <p class="font-sams text-lg text-gray-700 font-semibold">{{$answer->assessment->created_at->format('F j, Y')}}</p>
        <p class="font-sans text-xl font-semibold text-gray-700">Score: {{$answer->score}} / {{$answer->assessment->total}}</p>
    </div>
    <p class="font-sams text-md text-gray-700">{{$answer->assessment->description}}</p>
</div>

<div class="flex flex-col justify-between min-w-96 max-w-screen-md min-h-screen mx-auto mt-6 p-4 border border-gray-400 rounded-md shadow-lg">
    <form id="fields" class="flex flex-col">
        @foreach(json_decode($answer->data) as $node)
        @if($node->type == 'instruction')
            <fieldset data-type="{{$node->type}}" data-text="{{$node->text}}" data-score="{{$node->score}}" data-options="{{$node->options}}">
                <p class="font-sans text-lg font-semibold">Instruction: {{$node->text}}</p>
            </fieldset>
        @elseif($node->type == 'shortText')
            <fieldset data-type="{{$node->type}}" data-text="{{$node->text}}" data-score="{{$node->score}}" data-options="{{$node->options}}">
                <p for="" class="font-sans text-md font-base">{{$node->text}}</p>
                <p class="mt-1 text-sm font-sans">{{$node->score}} points</p>
                <input type="text" placeholder="Enter your answer" value="{{trim($node->answer)}}" readonly
                class="mt-2 px-4 py-1.5 text-sm rounded-md bg-white border border-gray-400 w-full outline-blue-500 md:w-1/2"/>
            </fieldset>
        @elseif($node->type == 'longText')
            <fieldset data-type="{{$node->type}}" data-text="{{$node->text}}" data-score="{{$node->score}}" data-options="{{$node->options}}">
                <p for="" class="font-sans text-md font-base">{{$node->text}}</p>
                <p class="mt-1 text-sm font-sans">{{$node->score}} points</p>
                <textarea placeholder="Enter your answer" readonly class="mt-2 px-4 py-1.5 text-sm rounded-md bg-white border border-gray-400 w-full outline-blue-500 md:w-1/2">{{trim($node->answer)}}</textarea>
            </fieldset>
        @elseif($node->type == 'radio')
            <fieldset data-type="{{$node->type}}" data-text="{{$node->text}}" data-score="{{$node->score}}" data-options="{{$node->options}}">
                <p for="" class="font-sans text-md font-base">{{$node->text}}</p>
                <p class="mt-1 text-sm font-sans">{{$node->score}} points</p>
                @foreach(explode(',', $node->options) as $option)
                    <div class="mt-2 flex flex-row items-center space-x-3">
                        <input type="radio" name="{{$node->text}}" value="{{$option}}" {{$node->answer == $option ? "checked" : "disabled"}}>
                        <label for="" class="font-sans text-base font-normal text-gray-700">{{$option}}</label>
                    </div>
                @endforeach
            </fieldset>
        @endif
    @endforeach
    </form>
</div>

{{-- Modals --}}
<x-modals.gradeassessment id="{{$answer->id}}"/>

@endsection