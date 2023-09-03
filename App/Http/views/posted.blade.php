@extends('aplag::layouts.main')


@section('topcontent')

    <div class="w-1/3 self-end pb-10">
        <div class="ps-3 text-xl">Compare content of <span class="font-semibold">text A in text B</span></div>
        <div class="text-left ps-10"><span class="font-bold text-4xl">Anty-Plagiarism Checker</span></div>
    </div>
    <div class="w-1/3 self-end text-center pb-10">
        <div class="text-xl">{{ $name }}</div>
    </div>
    <div class="w-1/3 self-end pb-2 text-start">
        <div class="flex flex-row">
            <div class="w-2/5">Sentences in total:</div>
            <div class="w-1/5 font-bold text-end">{{$report->getSegsCount()}}</div>
        </div>
        <div class="flex flex-row">
            <div class="w-2/5">Sentences matched <span class="text-green-600 font-bold">&gt;50%</span>:</div>
            <div class="w-1/5 text-end font-bold text-green-600">{{$report->getSegMidCount()}}</div>
        </div>
        <div class="flex flex-row">
            <div class="w-2/5">Sentences matched <span class="text-red-600 font-bold">100%</span>:</div>
            <div class="w-1/5 text-end font-bold text-red-600">{{$report->getSegHighCount()}}</div>
        </div>
        <div class="flex flex-row">
            <div class="w-2/5">Total length:</div>
            <div class="w-1/5 font-bold text-end">{{$report->getTotalWordsLength()}}</div>
            <div class="w-1/5 font-bold text-start ps-2">({{$report->getTotalWordCount()}} words)</div>
        </div>
        <div class="flex flex-row">
            <div class="w-2/5">Total matched length:</div>
            <div class="w-1/5 font-bold text-red-600 text-end">{{$report->getTotalMatchedWordsLength()}}</div>
            <div class="w-1/5 font-bold text-red-600 text-start ps-2"> ({{$report->getTotalMatchedWordCount()}} words)</div>
        </div>
        <div class="flex flex-row mt-2">
            <div class="w-2/5 font-semibold">Found (A)text in (B)text:</div>
            <div class="w-1/5 font-bold text-end">{{$report->getTotalMatch()}}</div>
            <div class="w-1/5 font-bold text-start">%</div>
        </div>
    </div>


@endsection

@section('content')

<div class="w-full flex flex-col pb-1 border border-slate-300 border-b-slate-400 bg-white mt-2">
    <table class="table-fixed">
        <thead>
            <tr class="border border-b-slate-400 bg-slate-200">
                <th class="w-16 px-1 py-1 ps-2">No</th>
                <th class="w-6/12">(A) Text Sentence</th>
                <th class="w-auto">Match</th>
                <th class="w-6/12">
                    <div class="flex flex-row">
                        <div class="text-center w-11/12">(B) Matched Source sentence</div>
                        <div class="text-end w-1/12 me-2">
                            <a href="{{ URL::previous() }}"><button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-0.5 px-2 border border-gray-400 rounded shadow">
                                Back</button></a>
                        </div>
                        <div class="text-end w-2/12">
                            <form action="{{ route('excel') }}" method="POST">
                                @csrf
                                
                                <input type="hidden" name="name" value="{{ $name }}" />

                                @foreach ($tekst->getSegs() as $seg)
                                    <input type="hidden" name="text[]" value="{{$seg['orig']}}" multiple/>
                                    <input type="hidden" name="matchval[]" value="{{$seg['matchVal']}}" multiple/>
                                    <input type="hidden" name="match[]" value="{{$seg['matchedSentence']}}" multiple/>
                                @endforeach


                                <input type="hidden" name="segsCount" value="{{$report->getSegsCount()}}" />
                                <input type="hidden" name="segMidCount" value="{{$report->getSegMidCount()}}" />
                                <input type="hidden" name="segHighCount" value="{{$report->getSegHighCount()}}" />
                                <input type="hidden" name="totalWordCount" value="{{$report->getTotalWordCount()}}" />
                                <input type="hidden" name="matchedWordCount" value="{{$report->getTotalMatchedWordCount()}}" />
                                <input type="hidden" name="totalMatch" value="{{$report->getTotalMatch()}}" />
                                <input type="hidden" name="totalLength" value="{{$report->getTotalWordsLength()}}" />
                                <input type="hidden" name="totalMatchedLength" value="{{$report->getTotalMatchedWordsLength()}}" />

                                <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-0.5 px-2 border border-gray-400 rounded shadow">
                                    Save Excel</button>
                            </form>
                        </div>
                    </div>
                </th>
                <th class="w-10">&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

        @php
            // predefined colors
            $null = 'text-gray-500';
            $fifty = 'text-green-500';
            $hundred = 'text-red-600';

        @endphp

    <div class="overflow-auto md:h-[300px] xl:h-[700px] 2xl:h-[700px]">
        <table class="table-fixed">
            <tbody>

                @foreach ($tekst->getSegs() as $key => $seg)

                    {{-- colors depending on match value --}}
                    @switch(true)
                            @case($seg['matchVal'] < 50)
                            @php
                                $color = $null;
                            @endphp
                            @break

                            @case($seg['matchVal'] > 49 && $seg['matchVal'] < 100)
                            @php
                                $color = $fifty;
                            @endphp
                            @break

                            @case($seg['matchVal'] == 100)
                            @php
                                $color = $hundred;
                            @endphp
                            @break
                    @endswitch
                    
                    <tr class=" odd:bg-slate-50 border-b even:bg-white">
                        <td class="border-e text-right text-sm ps-2 pe-1 w-16">{{$key+1}}</td>
                        <td class="border-e px-5 {{$color}} w-1/2 text-sm">{{$seg['orig']}}</td>
                        <td class="border-e text-end ps-2 pe-1 text-sm {{$color}}">
                            @if (($seg['matchVal']) > 49)
                            {{ number_format($seg['matchVal'],2) }}&nbsp;<span class="text-slate-300">%</span>
                            @endif
                        </td>
                        <td class="text-sm px-5 w-1/2 text-slate-500">
                            @if (($seg['matchVal']) > 49)
                                {{$seg['matchedSentence']}}
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection