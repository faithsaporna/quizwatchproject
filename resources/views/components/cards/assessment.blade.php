@props([
    'title' => 'Assessment Title',
    'date' => 'January 01, 2000',
    'total' => '0',
    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
    'href' => '#',
    'status' => 'Unanswered',
    'score' => null
])

<div onclick="window.location.href = '{{$href}}'"
    class="flex flex-wrap items-center cursor-pointer shadow-[0_0px_8px_-3px_rgba(6,81,237,0.3)] rounded-lg w-full px-4 py-4 hover:bg-gray-200">
    <div class="ml-4 flex-1">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start">
            <p class="text-lg text-black font-semibold">{{$title}}</p>
            <p class="text-sm text-gray-700 font-semibold">{{$date}}</p>
        </div>
        <p class="text-xs text-gray-500 mt-0.5">{{$total}} points</p>
        <div class="flex flex-col md:flex-row md:justify-between md:items-start">
            <p class="mt-4 text-gray-800 text-sm">{{$status}}</p>
            @if($score != null)
            <p class="mt-4 text-gray-800 text-sm font-semibold">{{$score}}</p>
            @endif
        </div>
        <p class="mt-4 text-md text-gray-500">{{$description}}</p>
    </div>
</div>