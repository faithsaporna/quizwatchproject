@extends('layouts.app')
@section('title', 'Assessment')

@section('content')

<h3 class="text-xl font-bold text-black">{{$assessment->classroom->name}}</h3>
<p class="text-md font-semibold text-gray-700">{{$assessment->classroom->code}}</p>

<div class="mt-6 flex flex-col space-y-3">
    <p class="font-sans text-lg font-semibold text-gray-800">{{$assessment->title}}</p>
    <p class="font-sams text-md text-gray-700 font-semibold">{{$assessment->created_at->format('F j, Y')}}</p>
    <p class="font-sams text-md text-gray-700">{{$assessment->total}} points</p>
    <p class="font-sams text-md text-gray-700">{{$assessment->description}}</p>
</div>

<div class="flex flex-col justify-between min-w-96 max-w-screen-md min-h-screen mx-auto mt-6 p-4 border border-gray-400 rounded-md shadow-lg">
    <form id="fields" class="flex flex-col">
        @foreach(json_decode($assessment->data) as $node)
        @if($node->type == 'instruction')
            <fieldset data-type="{{$node->type}}" data-text="{{$node->text}}" data-score="{{$node->score}}" data-options="{{$node->options}}">
                <p class="font-sans text-lg font-semibold">Instruction: {{$node->text}}</p>
            </fieldset>
        @elseif($node->type == 'shortText')
            <fieldset data-type="{{$node->type}}" data-text="{{$node->text}}" data-score="{{$node->score}}" data-options="{{$node->options}}">
                <p for="" class="font-sans text-md font-base">{{$node->text}}</p>
                <p class="mt-1 text-sm font-sans">{{$node->score}} points</p>
                <input type="text" placeholder="Enter your answer"
                class="mt-2 px-4 py-1.5 text-sm rounded-md bg-white border border-gray-400 w-full outline-blue-500 md:w-1/2"/>
            </fieldset>
        @elseif($node->type == 'longText')
            <fieldset data-type="{{$node->type}}" data-text="{{$node->text}}" data-score="{{$node->score}}" data-options="{{$node->options}}">
                <p for="" class="font-sans text-md font-base">{{$node->text}}</p>
                <p class="mt-1 text-sm font-sans">{{$node->score}} points</p>
                <textarea placeholder="Enter your answer" class="mt-2 px-4 py-1.5 text-sm rounded-md bg-white border border-gray-400 w-full outline-blue-500 md:w-1/2">
                </textarea>
            </fieldset>
        @elseif($node->type == 'radio')
            <fieldset data-type="{{$node->type}}" data-text="{{$node->text}}" data-score="{{$node->score}}" data-options="{{$node->options}}">
                <p for="" class="font-sans text-md font-base">{{$node->text}}</p>
                <p class="mt-1 text-sm font-sans">{{$node->score}} points</p>
                @foreach(explode(',', $node->options) as $option)
                    <div class="mt-2 flex flex-row items-center space-x-3">
                        <input type="radio" name="{{$node->text}}" value="{{$option}}">
                        <label for="" class="font-sans text-base font-normal text-gray-700">{{$option}}</label>
                    </div>
                @endforeach
            </fieldset>
        @endif
    @endforeach
    </form>

    <div class="flex items-center justify-center">
        <button type="button" id="submitAnswer"
            class="flex flex-row items-center px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-green-700 hover:bg-green-800 active:bg-green-700">
            Submit Answer
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="h-6 w-6 ml-2 inline fill-white">
                <path d="m120-200 180-280-180-280h480q20 0 37.5 9t28.5 25l174 246-174 246q-11 16-28.5 25t-37.5 9H120Zm146-80h334l142-200-142-200H266l130 200-130 200Zm130-200L266-680l130 200-130 200 130-200Z"/>
            </svg>
        </button>
    </div>
</div>

<form action="/answer/create" method="POST" id="answerForm" class="hidden">
    @csrf
    <input type="text" name="user_id" value="{{auth()->user()->id}}" class="hidden">
    <input type="text" name="assessment_id" value="{{$assessment->id}}" class="hidden">
    <input type="text" id="answerData" name="data" class="hidden">
</form>

{{-- Modals --}}
<x-modals.confirm 
    trigger="submitAnswer"
    title="Confirm Submit"
    content="Submitting your answer won't let you modify your answer later. Continue?"
    confirmColor="bg-green-500"
    action="saveFormData()"
/>

<script>
    function saveFormData(){
        var form = document.getElementById('fields');
        var fieldsets = document.querySelectorAll('fieldset', form);
        var formData = [];
        
        fieldsets.forEach(function(element) {
            var type = element.getAttribute('data-type');
            var answer = '';
            if (type === 'shortText') {
                answer = document.querySelector('input', element).value;
            } else if (type === 'longText') {
                answer = document.querySelector('textarea', element).value;
            } else if (type === 'radio') {
                var options = document.querySelectorAll('input[type="radio"]', element);
                for (let option of options) {
                    if (option.checked) {
                        answer = option.value;
                        break;
                    }
                }
            }
            var fieldData = {
                'type': type,
                'text': element.getAttribute('data-text'),
                'options': element.getAttribute('data-options'),
                'score': element.getAttribute('data-score'),
                'answer': answer.trim()
            };
            formData.push(fieldData);
        });

        const answerForm = document.getElementById('answerForm');
        const answerData = document.getElementById('answerData');
        answerData.value = JSON.stringify(formData);
        answerForm.submit();
    }
</script>
@endsection