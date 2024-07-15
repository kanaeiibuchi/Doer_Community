<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if(auth()->user()->roll_flg == 1)
            {{ __('オーナー管理') }}
            @else
            {{ __('チーム情報') }}
            @endif
        </h2>
    </x-slot>
    
    <!--チーム作成画面（オーナー限定表示）-->
    @if(auth()->user()->roll_flg == 1)
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("チーム作成") }}
                    <form action="{{route('teams.store')}}" method="POST">
                        @csrf
                        <input type="text" name="team">
                        <button>作成</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{__("チーム")}}
                    <div class="team-container bg-gray-200 mt-4 rounded-lg p-4 h-96 overflow-y-auto">
                    @foreach($teams as $team)
                           @if($team->user_id == auth()->user()->id)
                            <div class="flex gap-4 bg-blue-200 text-black rounded-lg mt-4 p-4">
                                <div>
                                    <p> NO.{{ $team->id }}  {{ $team->team }}</p>
                                    <p> 作成者：{{ $team->user->name }} / 作成日時：{{ $team->updated_at }}</p>
                                    <p> メンバー）</p>
                                     <ul>
                                    @foreach($team->members as $member)
                                    <li>&nbsp;{{ $member->nickname }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                                <div class="flex gap-4">
                                    <a href="{{route('teams.edit',$team)}}">編集</a>
                                    <form action="{{route('teams.destroy',$team)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button>削除</button>
                                    </form>
                                </div>
                            </div>
                           @endif
                    @endforeach
                    @foreach($teams as $team)
                            @if(in_array(auth()->user()->id, [$team->user_id_1, $team->user_id_2, $team->user_id_3, $team->user_id_4, $team->user_id_5]))
                                <div class="flex gap-4 bg-blue-200 text-black rounded-lg mt-4 p-4">
                                 <div>
                                    <p class="font-bold text-xl"> {{ $team->team }}チーム</p>
                                     <div>
                                        @foreach($team->members as $member)
                                            <p class="text-gray-800 text-s bg-gray-100 rounded-lg mt-2 p-2">&nbsp;{{ $member->nickname }}★{{ $member->bio }}</p>
                                        @endforeach
                                     </div>
                                 </div>
                                </div>
                            @endif
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>
</x-app-layout>