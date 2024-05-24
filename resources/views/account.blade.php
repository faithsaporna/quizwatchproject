@extends('layouts.app')
@section('title', 'Account')

@section('content')
<form action="/account/update" method="POST" class="flex flex-col justify-between w-full h-full">
    @csrf
    <div class="flex flex-col space-y-4 items-center w-full">
        <img src="{{ asset(auth()->user()->profile) }}" id="profilePicture" alt="" class="h-24 w-24 rounded-full lg:h-32 lg:w-32">
        <button type="button" id="openProfileModalButton"
            class="mt-4 px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-blue-600 hover:bg-blue-700 active:bg-blue-600">
            Change Profile
        </button>
        <input type="text" class="hidden" name="profile" id="selectedProfileImage" value="{{ asset('/images/profiles/1.jpg') }}">
        <div class="relative flex items-center w-full md:w-1/2">
            <input type="text" placeholder="Enter name" name="name" value="{{auth()->user()->name}}" required
            class="px-4 py-3 bg-white text-[#333] w-full text-sm border-2 outline-[#007bff] rounded-lg" />
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="#bbb" stroke="#bbb" class="w-8 h-8 absolute right-2">
                <path d="M480-504q-48.38 0-82.65-34.27t-34.27-82.65q0-48.39 34.27-82.66 34.27-34.27 82.65-34.27t82.65 34.27q34.27 34.27 34.27 82.66 0 48.38-34.27 82.65T480-504ZM205.54-223.38v-62.16q0-24.23 13.86-44.95 13.86-20.72 38.07-32.36 56.25-26.57 111.87-40.11 55.62-13.54 110.67-13.54 55.05 0 110.75 13.52t111.86 40.1q24.18 11.64 38.01 32.37 13.83 20.73 13.83 44.97v62.16H205.54Zm36.92-36.93h475.08v-25.13q0-13.6-8.58-25.25-8.58-11.66-23.84-20.12-49.37-23.81-100.99-36.29t-104.18-12.48q-52.91 0-104.35 12.48-51.45 12.48-100.33 36.29-15.65 8.46-24.23 20.19t-8.58 25.08v25.23ZM480-540.92q33 0 56.5-23.5t23.5-56.5q0-33-23.5-56.5t-56.5-23.5q-33 0-56.5 23.5t-23.5 56.5q0 33 23.5 56.5t56.5 23.5Zm0-80Zm0 360.61Z"/>
            </svg>
        </div>
        <div class="relative flex items-center w-full md:w-1/2">
            <input type="email" placeholder="Enter Email" name="email" value="{{auth()->user()->email}}" required
            class="px-4 py-3 bg-white text-[#333] w-full text-sm border-2 outline-[#007bff] rounded-lg" />
            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4"
            viewBox="0 0 682.667 682.667">
            <defs>
                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                <path d="M0 512h512V0H0Z" data-original="#000000"></path>
                </clipPath>
            </defs>
            <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                <path fill="none" stroke-miterlimit="10" stroke-width="40"
                d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z"
                data-original="#000000"></path>
                <path
                d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z"
                data-original="#000000"></path>
            </g>
            </svg>
        </div>
        <div class="relative flex justify-between items-center w-full md:w-1/2">
            <p class="font-sans font-semibold text-md text-gray-800">Password: </p>
            <button type="button" id="resetPassword"
                class="px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-red-500 hover:bg-red-600 active:bg-red-500">
                Reset Password
            </button>
        </div>
    </div>
    
    <div class="flex items-center justify-center">
        <button type="submit"
            class="flex flex-row items-center px-2.5 lg:px-6 py-2.5 rounded text-white text-sm tracking-wider font-semibold border-none outline-none bg-green-600 hover:bg-green-700 active:bg-green-600">
            Submit
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="h-6 w-6 ml-2 inline fill-white">
                <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
            </svg>
        </button>
    </div>

</form>

<script>
    function changePicture(image) {
        const selectedProfileImage = document.getElementById('selectedProfileImage');
        selectedProfileImage.value = image;
        document.getElementById('profilePicture').src = image;
    }
</script>

<x-modals.profiles callback="changePicture"/>
<x-modals.resetpassword/>

@endsection