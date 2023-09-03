@extends('aplag::layouts.main',['title=>$title'])

@section('topcontent')
    
        <div class="w-1/3 self-end pb-10">
            <div class="ps-3 text-xl">Compare content of <span class="font-semibold">text A in text B</span></div>
            <div class="text-left ps-10"><span class="font-bold text-4xl">Anty-Plagiarism Checker</span></div>
        </div>
        <div class="w-2/3 text pt-3 ps-5 h-full"></div>
    
@endsection


@section('content')

<div>
    <form action="{{ route('compared') }}" method="POST">
        @csrf
        <div class="flex flex-wrap mt-5">
            <input type="text" name="name" value="{{old('name')}}" placeholder="Your Comparison Name" class="p-2 ps-5 pe-2 w-1/4 border border-gray-300 rounded-md focus:outline-none focus:border-slate-600 text-slate-500 mt-2 mb-2" rows="10" spellcheck="false" required/>
        </div>
        <div class="flex flex-wrap mt-5 ps-5">
            <div class="">(A) <span class="font-bold">TEXT</span> you want to check:</div>
            <div>
                @if($errors->has('text1'))
                    <div class="text-red-500 italic ms-5">{{ $errors->first('text1') }}</div>
                @endif    
            </div>
        </div>
        <textarea name="text1" id="text1" name="text1" placeholder="Heres insert text that you suspect may be plagiarized" class="w-full border border-gray-300 rounded-md focus:outline-none focus:border-slate-600 p-5 scroll-py-5 text-slate-500 mt-2 mb-2" rows="10" spellcheck="false">{{old('text1')}}</textarea>
        
        <div class="flex flex-wrap mt-5 ps-5">
            <div class="">(B) Possible <span class="font-bold">SOURCE</span> text:</div>
            <div>
                @if($errors->has('text2'))
                    <div class="text-red-500 italic ms-5">{{ $errors->first('text2') }}</div>
                @endif
            </div>
        </div>
        <textarea name="text2" id="text2" name="text2" placeholder="Here insert the SOURCE origin text" class="w-full border border-gray-300 rounded-md focus:outline-none focus:border-gray-600 p-5 text-slate-600 mt-2 mb-2" rows="10" spellcheck="false">{{old('text2')}}</textarea>
        <div class="flex flex-wrap ps-5">
            <label for="security">The field below must stay empty</label>
            @if($errors->has('security'))
                <div class="text-red-500 italic ms-2">{{ $errors->first('security') }}</div>
            @endif
        </div>
        <div class="flex flex-rows">
            <div class="w-full ps-5">
                <input type="text" name="security" value="{{old('security')}}" class="w-1/4 py-2 px-4 border border-gray-300 rounded-md focus:outline-none focus:border-slate-600 text-slate-500 mt-2 mb-2" spellcheck="false" />
            </div>
            <div class="w-full text-end">
                <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-0.5 px-2 me-5 border border-gray-400 rounded shadow">Check the Text</button>
            </div>
        </div>
    </form>
</div>

@endsection