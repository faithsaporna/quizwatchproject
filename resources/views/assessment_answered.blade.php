@extends('layouts.app')
@section('title', 'Assessment')

@section('content')

<h3 class="text-xl font-bold text-black">{{$answer->assessment->classroom->name}}</h3>
<p class="text-md font-semibold text-gray-700">{{$answer->assessment->classroom->code}}</p>

<div class="mt-6 flex flex-col space-y-3">
    <p class="font-sans text-lg font-semibold text-gray-800">{{$answer->assessment->title}}</p>
    <p class="font-sams text-md text-gray-700 font-semibold">{{$answer->assessment->created_at->format('F j, Y')}}</p>
    <p class="font-sams text-md text-gray-700">{{$answer->assessment->total}} points</p>
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

@endsection