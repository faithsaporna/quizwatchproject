@props([
    'name' => 'Sample classroom',
    'code' => 'xxxx-xxxx-xx',
    'description' => 'This is a sample classroom',
    'users' => '0',
    'backgroundColor' => 'bg-gray-800',
    'section' => null,
])

<div onclick="window.location.href = '/classrooms/{{$code}}'"
  class="{{$backgroundColor}} cursor-pointer shadow-[0_2px_15px_-6px_rgba(0,0,0,0.2)] p-6 w-full max-w-sm rounded-lg font-[sans-serif] overflow-hidden mx-auto mt-4 hover:brightness-75">
  <div class="flex items-center">
    <h3 class="text-3xl font-bold text-white flex-1">{{$name}}</h3>
  </div>
  <p class="font-sans text-md font-medium text-slate-50">{{$code}}</p>
  <p class="text-sm text-white mt-8 mb-6">{{$description}}</p>

  @if ($section != null)
    <p class="mb-2 font-sans text-md font-medium text-slate-50">Section: {{$section}}</p>
  @endif

  <div class="flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="h-6 w-6 fill-white mr-4">
        <path d="M680-360q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM480-160v-56q0-24 12.5-44.5T528-290q36-15 74.5-22.5T680-320q39 0 77.5 7.5T832-290q23 9 35.5 29.5T880-216v56H480Zm-80-320q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm0-160ZM80-160v-112q0-34 17-62.5t47-43.5q60-30 124.5-46T400-440q35 0 70 6t70 14l-34 34-34 34q-18-5-36-6.5t-36-1.5q-58 0-113.5 14T180-306q-10 5-15 14t-5 20v32h240v80H80Zm320-80Zm0-320q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Z"/>
    </svg>    
    <h3 class="text-lg font-bold text-white flex-1">{{$users}} users</h3>
  </div>
</div>