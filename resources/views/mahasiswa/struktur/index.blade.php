@extends('Mahasiswa.layouts.app')

@section('title', 'Struktur HIMANIKKA')

@section('content')
<main class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-950 dark:to-slate-900 text-slate-900 dark:text-white">

    <!-- Struktur Grid -->
    <section class="max-w-6xl mx-auto px-4 pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-16 text-center">
        <h2 class="text-4xl font-black text-slate-900 dark:text-white">
            Struktur <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">HIMANIKKA</span>
        </h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-500 dark:text-slate-400">
            Diagram struktur organisasi Himpunan Mahasiswa Teknik Informatika Universitas Pahlawan Tuanku Tambusai
        </p>
        <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500"></div>
    </div>

    @php
        $jabatanColors = [
            1 => 'from-amber-500 to-orange-600',
            2 => 'from-indigo-600 to-purple-700',
            3 => 'from-blue-600 to-indigo-700',
            4 => 'from-emerald-500 to-teal-600',
            5 => 'from-rose-500 to-pink-600',
        ];
        $placeholderSvg = '<svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>';

        function orgCardDetail($item, $title) {
            return [
                'name' => $item->user->name ?? '-',
                'jabatan' => $item->jabatan->name_jabatan ?? $title,
                'devisi' => $item->devisi->name_devisi ?? '-',
                'masa_jabatan' => $item->masa_jabatan ?? '-',
                'foto' => $item->foto ? Storage::url($item->foto) : '',
            ];
        }

        function orgCardHtml($item, $colorIdx, $title) {
            $colors = ['from-amber-500 to-orange-600','from-indigo-600 to-purple-700','from-blue-600 to-indigo-700','from-emerald-500 to-teal-600','from-rose-500 to-pink-600'];
            $grad = $colors[$colorIdx - 1] ?? 'from-indigo-600 to-purple-700';
            $foto = e($item->foto ? Storage::url($item->foto) : asset('images/placeholder.svg'));
            $name = e($item->user->name ?? '-');
            $masa = e($item->masa_jabatan ?? '-');
            $pl = asset('images/placeholder.svg');
            $json = json_encode(orgCardDetail($item, $title), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP);
            return '<button type="button" x-data=\'{ member: '.$json.' }\' @click="$store.modal.open({mode:\'detail\',title:\'Detail '.$title.'\',detail:member,fields:[{key:\'foto\',label:\'Foto\',type:\'image\'},{key:\'name\',label:\'Nama\',type:\'text\'},{key:\'jabatan\',label:\'Jabatan\',type:\'text\'},{key:\'devisi\',label:\'Divisi\',type:\'text\'},{key:\'masa_jabatan\',label:\'Masa Jabatan\',type:\'text\'}]})" class="group relative overflow-hidden rounded-2xl bg-white/95 shadow-lg shadow-slate-200/50 transition-all hover:shadow-xl hover:-translate-y-1 dark:bg-slate-800/95 dark:shadow-slate-900/50 w-64"><div class="h-1.5 w-full bg-gradient-to-r '.$grad.'"></div><div class="p-5 text-center"><div class="relative mx-auto mb-3 h-20 w-20 overflow-hidden rounded-full ring-4 ring-white shadow-md dark:ring-slate-700"><img src="'.$foto.'" alt="'.$name.'" class="h-full w-full object-cover" loading="lazy" onerror="this.src=\''.$pl.'\'"></div><h3 class="text-base font-bold text-slate-900 dark:text-white truncate">'.$name.'</h3><span class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r '.$grad.' px-3 py-1 text-xs font-semibold text-white shadow-sm">'.$title.'</span><p class="mt-2 text-xs text-slate-400 dark:text-slate-500">'.$masa.'</p></div></button>';
        }

        function placeholderHtml($title) {
            return '<div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white/50 p-5 text-center dark:border-slate-600 dark:bg-slate-800/50 w-64"><div class="mx-auto mb-3 flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700"><svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div><h3 class="text-base font-bold text-slate-500 dark:text-slate-400">'.$title.'</h3><p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Belum ditentukan</p></div>';
        }
    @endphp

    <div class="org-chart-wrapper relative">

        {{-- LEVEL 1: PEMBINA --}}
        <div class="relative z-10 flex justify-center mb-2">
            @php $pembina = $leadershipByJabatan->get(1)?->first(); @endphp
            @if($pembina)
                {!! orgCardHtml($pembina, 1, 'Pembina') !!}
            @else
                {!! placeholderHtml('Pembina') !!}
            @endif
        </div>

        <div class="relative z-10 flex justify-center">
            <div class="h-8 w-0.5 bg-gradient-to-b from-indigo-400/60 to-indigo-300/20"></div>
        </div>

        {{-- LEVEL 2: KAHIM --}}
        <div class="relative z-10 flex justify-center mb-2">
            @php $kahim = $leadershipByJabatan->get(2)?->first(); @endphp
            @if($kahim)
                {!! orgCardHtml($kahim, 2, 'Kahim') !!}
            @else
                {!! placeholderHtml('Kahim') !!}
            @endif
        </div>

        <div class="relative z-10 flex justify-center">
            <div class="h-8 w-0.5 bg-gradient-to-b from-purple-400/60 to-purple-300/20"></div>
        </div>

        {{-- LEVEL 3: WAKAHIM --}}
        <div class="relative z-10 flex justify-center mb-2">
            @php $wakahim = $leadershipByJabatan->get(3)?->first(); @endphp
            @if($wakahim)
                {!! orgCardHtml($wakahim, 3, 'Wakahim') !!}
            @else
                {!! placeholderHtml('Wakahim') !!}
            @endif
        </div>

        {{-- Fork connector: Wakahim -> Sekretaris & Bendahara --}}
        <div class="relative z-10 flex justify-center">
            <div class="relative" style="height:48px; width:1px;">
                <div class="absolute inset-x-0 top-0 h-1/2 w-px mx-auto bg-gradient-to-b from-blue-400/60 to-blue-300/20"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 w-16 sm:w-24 h-px bg-gradient-to-r from-transparent via-blue-300/50 to-transparent"></div>
                <div class="absolute top-1/2 bottom-0 w-px bg-gradient-to-b from-blue-300/40 to-transparent" style="left: calc(50% - 32px);"></div>
                <div class="absolute top-1/2 bottom-0 w-px bg-gradient-to-b from-blue-300/40 to-transparent" style="left: calc(50% + 32px);"></div>
            </div>
        </div>

        {{-- LEVEL 4: SEKRETARIS & BENDAHARA --}}
        <div class="relative z-10 flex justify-center gap-6 sm:gap-16 flex-wrap">
            <div class="flex flex-col items-center gap-3">
                @php $sekretaris = $leadershipByJabatan->get(4); @endphp
                @forelse($sekretaris ?? collect() as $sek)
                    {!! orgCardHtml($sek, 4, 'Sekretaris') !!}
                @empty
                    {!! placeholderHtml('Sekretaris') !!}
                @endforelse
            </div>
            <div class="flex flex-col items-center gap-3">
                @php $bendahara = $leadershipByJabatan->get(5); @endphp
                @forelse($bendahara ?? collect() as $ben)
                    {!! orgCardHtml($ben, 5, 'Bendahara') !!}
                @empty
                    {!! placeholderHtml('Bendahara') !!}
                @endforelse
            </div>
        </div>

        {{-- Connector to divisions --}}
        <div class="relative z-10 flex justify-center mt-2">
            <div class="h-8 w-0.5 bg-gradient-to-b from-indigo-300/40 to-transparent"></div>
        </div>

        {{-- LEVEL 5: DIVISIONS --}}
        <div class="relative z-10 mt-8">
            <div class="mb-8 text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-5 py-2 text-sm font-semibold text-indigo-700 ring-1 ring-indigo-200 dark:bg-indigo-950/40 dark:text-indigo-300 dark:ring-indigo-800">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    DIVISI KEPENGURUSAN
                </span>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($devisiByGroup ?? collect() as $devisi_id => $groupDevisi)
                    @php
                        $devisiData = $groupDevisi->first()->devisi;
                        $koordinator = $groupDevisi->firstWhere('posisi', 'Koordinator');
                        $anggota = $groupDevisi->where('posisi', 'Anggota');
                    @endphp

                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-sm transition-all hover:shadow-lg hover:-translate-y-1 dark:border-slate-700/50 dark:bg-slate-900/90">
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-4 py-3">
                            <h3 class="text-base font-bold text-white">{{ $devisiData->name_devisi ?? 'Divisi' }}</h3>
                            <p class="text-xs text-indigo-200">{{ $groupDevisi->count() }} Anggota</p>
                        </div>

                        <div class="p-4 space-y-3">
                            @if($koordinator)
                                @php $memberDetail = json_encode(['name' => $koordinator->user->name ?? '-', 'posisi' => 'Koordinator ' . ($devisiData->name_devisi ?? ''), 'masa_jabatan' => $koordinator->masa_jabatan ?? '-', 'foto' => $koordinator->foto ? Storage::url($koordinator->foto) : '']) @endphp
                                <button type="button"
                                    x-data='{ member: {!! $memberDetail !!} }'
                                    @click="$store.modal.open({mode:'detail',title:'Detail Koordinator',detail:member,fields:[{key:'foto',label:'Foto',type:'image'},{key:'name',label:'Nama',type:'text'},{key:'posisi',label:'Posisi',type:'text'},{key:'masa_jabatan',label:'Masa Jabatan',type:'text'}]})"
                                    class="flex w-full items-center gap-3 rounded-xl bg-amber-50 p-3 text-left transition hover:bg-amber-100 dark:bg-amber-950/30 dark:hover:bg-amber-950/50">
                                    <img src="{{ $koordinator->foto ? Storage::url($koordinator->foto) : asset('images/placeholder.svg') }}" alt="" class="h-10 w-10 flex-shrink-0 rounded-full object-cover ring-2 ring-amber-400">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-semibold text-amber-700 dark:text-amber-400">Koordinator</p>
                                        <p class="truncate text-sm font-medium text-slate-900 dark:text-slate-100">{{ $koordinator->user->name ?? '-' }}</p>
                                    </div>
                                </button>
                            @endif

                            <div class="space-y-2">
                                @forelse($anggota as $ang)
                                    @php $memberDetailAng = json_encode(['name' => $ang->user->name ?? '-', 'posisi' => 'Anggota ' . ($devisiData->name_devisi ?? ''), 'masa_jabatan' => $ang->masa_jabatan ?? '-', 'foto' => $ang->foto ? Storage::url($ang->foto) : '']) @endphp
                                    <button type="button"
                                        x-data='{ member: {!! $memberDetailAng !!} }'
                                        @click="$store.modal.open({mode:'detail',title:'Detail Anggota',detail:member,fields:[{key:'foto',label:'Foto',type:'image'},{key:'name',label:'Nama',type:'text'},{key:'posisi',label:'Posisi',type:'text'},{key:'masa_jabatan',label:'Masa Jabatan',type:'text'}]})"
                                        class="flex w-full items-center gap-3 rounded-xl bg-slate-50 p-2.5 text-left transition hover:bg-slate-100 dark:bg-slate-800/50 dark:hover:bg-slate-800">
                                        <img src="{{ $ang->foto ? Storage::url($ang->foto) : asset('images/placeholder.svg') }}" alt="" class="h-8 w-8 flex-shrink-0 rounded-full object-cover ring-2 ring-slate-300 dark:ring-slate-600">
                                        <div class="min-w-0 flex-1"><p class="truncate text-sm font-medium text-slate-800 dark:text-slate-200">{{ $ang->user->name ?? '-' }}</p></div>
                                        <svg class="h-4 w-4 flex-shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                @empty
                                    <p class="text-center text-sm text-slate-400 dark:text-slate-500">Belum ada anggota</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 py-16 text-slate-400 dark:border-slate-700">
                        <svg class="mb-4 h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                        </svg>
                        <p class="text-sm font-medium">Belum ada data divisi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
    </section>

    <!-- Keterangan -->
    <section class="max-w-6xl mx-auto px-4 pb-16">
        <div class="grid md:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                <h3 class="font-bold text-lg">Jabatan</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Menunjukkan peran utama seperti pembina, kahim, wakahim, sekretaris, dan bendahara.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                <h3 class="font-bold text-lg">Posisi</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Menandai apakah anggota berkedudukan sebagai anggota atau koordinator.
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                <h3 class="font-bold text-lg">Devisi</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Membagi tugas pengurus berdasarkan bidang kerja yang ada di HIMANIKKA.
                </p>
            </div>
        </div>
    </section>


</main>
@endsection