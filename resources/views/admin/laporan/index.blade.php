@extends('admin.layouts.app')

@section('title', 'Manajemen Laporan HIMANIKKA')
@section('pageTitle', 'Laporan')

@section('content')
<div class="space-y-6" x-data="{
    search: @js(request('search')),
    filterJenis: @js(request('jenis')),
    filterStatus: @js(request('status')),
    applyFilters() { const p=new URLSearchParams(); if(this.search) p.set('search',this.search); if(this.filterJenis) p.set('jenis',this.filterJenis); if(this.filterStatus) p.set('status',this.filterStatus); window.location='{{ route('admin.laporan.index') }}?'+p.toString(); },
    resetFilters() { window.location='{{ route('admin.laporan.index') }}'; }
}">
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-xl sm:p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-white/80 ring-1 ring-white/15">Manajemen Dokumen HIMANIKKA</div>
                <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Kelola Laporan</h1>
                <p class="mt-3 text-sm leading-6 text-white/75 sm:text-base">Kelola Proposal, LPJ, dan Surat Keputusan kegiatan HIMANIKKA. Pantau status persetujuan dan unduh dokumen PDF.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button type="button" @click="$store.modal.open({mode:'form',title:'Tambah Laporan',formAction:'{{ route('admin.laporan.store') }}',method:'POST',fields:[{name:'acaras_id',label:'Acara',type:'select',options:[{value:'',label:'Pilih Acara'}@foreach($acaras as $a),{value:'{{$a->id}}',label:'{{$a->name_acara}}'}@endforeach]},{name:'jenis',label:'Jenis',type:'select',options:[{value:'',label:'Pilih Jenis'},{value:'proposal',label:'Proposal'},{value:'lpj',label:'LPJ'},{value:'sk',label:'SK'},{value:'lengkap',label:'Lengkap'}]},{name:'nama_laporan',label:'Nama Laporan',type:'text'},{name:'tanggal',label:'Tanggal',type:'date'}],data:{acaras_id:'',jenis:'',nama_laporan:'',tanggal:''}})" class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-900 dark:text-slate-100 shadow-lg transition-all hover:-translate-y-0.5 hover:bg-slate-100 dark:bg-slate-800">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Tambah Laporan
                </button>
            </div>
        </div>
    </div>        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-7">
        <div class="card p-4 sm:p-5"><div class="flex items-center justify-between"><div><p class="text-xs font-medium text-slate-500 dark:text-slate-400">Total Laporan</p><p class="mt-1 text-2xl font-bold text-slate-900 dark:text-slate-100">{{$totalLaporan??0}}</p></div><div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div></div></div>
        <div class="card p-4 sm:p-5"><div class="flex items-center justify-between"><div><p class="text-xs font-medium text-slate-500 dark:text-slate-400">Proposal</p><p class="mt-1 text-2xl font-bold text-blue-600">{{$totalProposal??0}}</p></div><div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div></div></div>
        <div class="card p-4 sm:p-5"><div class="flex items-center justify-between"><div><p class="text-xs font-medium text-slate-500 dark:text-slate-400">LPJ</p><p class="mt-1 text-2xl font-bold text-emerald-600">{{$totalLpj??0}}</p></div><div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div></div></div>
        <div class="card p-4 sm:p-5"><div class="flex items-center justify-between"><div><p class="text-xs font-medium text-slate-500 dark:text-slate-400">SK</p><p class="mt-1 text-2xl font-bold text-purple-600">{{$totalSk??0}}</p></div><div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div></div></div>
        <div class="card p-4 sm:p-5"><div class="flex items-center justify-between"><div><p class="text-xs font-medium text-slate-500 dark:text-slate-400">Lengkap</p><p class="mt-1 text-2xl font-bold text-amber-600">{{$totalLengkap??0}}</p></div><div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg></div></div></div>
        <div class="card p-4 sm:p-5"><div class="flex items-center justify-between"><div><p class="text-xs font-medium text-slate-500 dark:text-slate-400">Menunggu ACC</p><p class="mt-1 text-2xl font-bold text-amber-600">{{$pendingApproval??0}}</p></div><div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div></div></div>
        <div class="card p-4 sm:p-5"><div class="flex items-center justify-between"><div><p class="text-xs font-medium text-slate-500 dark:text-slate-400">Disetujui</p><p class="mt-1 text-2xl font-bold text-emerald-600">{{$approvedCount??0}}</p></div><div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div></div></div>
    </div>

    <div class="card p-4 sm:p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex flex-1 flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1"><label class="mb-1 block text-xs font-semibold text-slate-500 dark:text-slate-400">Cari</label><input type="text" x-model="search" @keyup.enter="applyFilters" placeholder="Cari nama laporan..." class="form-input w-full"></div>
                <div class="w-full sm:w-40"><label class="mb-1 block text-xs font-semibold text-slate-500 dark:text-slate-400">Jenis</label><select x-model="filterJenis" @change="applyFilters" class="form-input w-full"><option value="">Semua</option><option value="proposal">Proposal</option><option value="lpj">LPJ</option><option value="sk">SK</option><option value="lengkap">Lengkap</option></select></div>
                <div class="w-full sm:w-40"><label class="mb-1 block text-xs font-semibold text-slate-500 dark:text-slate-400">Status</label><select x-model="filterStatus" @change="applyFilters" class="form-input w-full"><option value="">Semua</option><option value="diajukan">Diajukan</option><option value="approved">Disetujui</option><option value="rejected">Ditolak</option></select></div>
                <button @click="applyFilters" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">Cari</button>
                <button @click="resetFilters" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 dark:bg-slate-950/40">Reset</button>
            </div>
            <div class="flex gap-2">
                <a href="{{route('admin.export.laporan.csv')}}" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-3.5 py-2.5 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-emerald-700">CSV</a>
                <a href="{{route('admin.export.laporan.xls')}}" class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-3.5 py-2.5 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-blue-700">Excel</a>
                <a href="{{route('admin.export.laporan.pdf')}}" class="inline-flex items-center gap-1.5 rounded-xl bg-red-600 px-3.5 py-2.5 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-red-700">PDF</a>
            </div>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="border-b border-slate-200 dark:border-slate-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Daftar Laporan</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">@if(request('search')||request('jenis')||request('status'))Hasil: {{$laporans->total()}} @else Total: {{$laporans->total()}} @endif</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-950/40">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Nama Laporan</th><th class="px-6 py-4">Acara</th><th class="px-6 py-4">Jenis</th><th class="px-6 py-4">Tanggal</th><th class="px-6 py-4">Status</th><th class="px-6 py-4">File</th><th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($laporans as $item)
                    @php
                    $jnsLbl=match($item->jenis){'proposal'=>'Proposal','lpj'=>'LPJ','sk'=>'SK','lengkap'=>'Lengkap',default=>ucfirst($item->jenis??'-')};
                    $jnsClr=match($item->jenis){'proposal'=>'bg-blue-50 text-blue-700','lpj'=>'bg-emerald-50 text-emerald-700','sk'=>'bg-purple-50 text-purple-700','lengkap'=>'bg-amber-50 text-amber-700',default=>'bg-slate-50 dark:bg-slate-950/40 text-slate-700'};
                    $sttsClr=match($item->status){'approved'=>'bg-emerald-100 text-emerald-700','rejected'=>'bg-red-100 text-red-700','diajukan'=>'bg-amber-100 text-amber-700',default=>'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400'};
                    $sttsIcn=match($item->status){'approved'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','rejected'=>'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z','diajukan'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',default=>''};
                    $sttsLbl=match($item->status){'approved'=>'Disetujui','rejected'=>'Ditolak','diajukan'=>'Diajukan',default=>ucfirst($item->status??'-')};
                    $pdfBtn=match($item->jenis){'proposal'=>['l'=>'Proposal','c'=>'bg-blue-600'],'lpj'=>['l'=>'LPJ','c'=>'bg-emerald-600'],'sk'=>['l'=>'SK','c'=>'bg-purple-600'],'lengkap'=>['l'=>'Lengkap','c'=>'bg-amber-600'],default=>['l'=>'PDF','c'=>'bg-red-600']};
                    @endphp
                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800 dark:bg-slate-950/40/70">
                        <td class="px-6 py-4"><div class="font-medium text-slate-900 dark:text-slate-100">{{$item->nama_laporan??'-'}}</div><div class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Dibuat {{$item->created_at?$item->created_at->diffForHumans():'-'}}</div></td>
                        <td class="px-6 py-4"><div class="text-sm font-medium text-slate-900 dark:text-slate-100">{{$item->acara?->name_acara??'-'}}</div></td>
                        <td class="px-6 py-4"><span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{$jnsClr}}">{{$jnsLbl}}</span></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">@if($item->tanggal){{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}@else<span class="text-slate-400">-</span>@endif</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-medium {{$sttsClr}}"><svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{$sttsIcn}}"/></svg>{{$sttsLbl}}</span>@if($item->status==='rejected'&&$item->catatan)<div class="mt-1 text-xs text-red-500">{{Str::limit($item->catatan,30)}}</div>@endif</td>
                        <td class="px-6 py-4 text-center">@if($item->status==='approved'&&$item->file)<a href="{{asset('storage/'.$item->file)}}" target="_blank" class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/20 hover:bg-red-100">Unduh</a>@elseif($item->status==='approved')<span class="text-xs text-emerald-600">OK</span>@else<span class="text-xs text-slate-400">-</span>@endif</td>
                        <td class="px-6 py-4"><div class="flex justify-end gap-1">
                            <button type="button" @click="$store.modal.open({mode:'detail',title:'Detail',detail:@js(['nama_laporan'=>$item->nama_laporan??'-','acara'=>$item->acara?->name_acara??'-','jenis'=>$jnsLbl,'status'=>$sttsLbl,'tanggal'=>$item->tanggal??'-','catatan'=>$item->catatan??'-','file'=>$item->file?asset('storage/'.$item->file):'','dibuat'=>$item->created_at?$item->created_at->format('d M Y H:i'):'-']),fields:[{key:'nama_laporan',label:'Nama Laporan',type:'text'},{key:'acara',label:'Acara',type:'text'},{key:'jenis',label:'Jenis',type:'text'},{key:'status',label:'Status',type:'text'},{key:'tanggal',label:'Tanggal',type:'text'},{key:'catatan',label:'Catatan',type:'textarea'},{key:'file',label:'File PDF',type:'link'},{key:'dibuat',label:'Dibuat',type:'text'}]})" class="rounded-xl bg-blue-600 px-2.5 py-2 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-blue-700">Detail</button>
                            <a href="{{route('admin.export.laporan.pdf',$item->id)}}" target="_blank" class="rounded-xl {{$pdfBtn['c']}} px-2.5 py-2 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:brightness-110">{{$pdfBtn['l']}}</a>
                            <button type="button" @click="$store.modal.open({mode:'form',title:'Edit',formAction:'{{route('admin.laporan.update',$item->id)}}',method:'POST',extraMethod:'PUT',fields:[{name:'acaras_id',label:'Acara',type:'select',options:[{value:'',label:'Pilih Acara'}@foreach($acaras as $a),{value:'{{$a->id}}',label:'{{$a->name_acara}}'}@endforeach]},{name:'jenis',label:'Jenis',type:'select',options:[{value:'',label:'Pilih Jenis'},{value:'proposal',label:'Proposal'},{value:'lpj',label:'LPJ'},{value:'sk',label:'SK'},{value:'lengkap',label:'Lengkap'}]},{name:'nama_laporan',label:'Nama Laporan',type:'text'},{name:'tanggal',label:'Tanggal',type:'date'}],data:{acaras_id:@js($item->acaras_id??''),jenis:@js($item->jenis??''),nama_laporan:@js($item->nama_laporan??''),tanggal:@js($item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') : '')}})" class="rounded-xl bg-amber-500 px-2.5 py-2 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-amber-600">Edit</button>
                            <button type="button" @click="$store.modal.open({mode:'confirm',title:'Hapus',message:'Hapus '+@js($item->nama_laporan??'')+'?',action:()=>document.getElementById('df-{{$item->id}}').submit()})" class="rounded-xl bg-red-600 px-2.5 py-2 text-xs font-semibold text-white shadow-sm hover:-translate-y-0.5 hover:bg-red-700">Hapus</button>
                            <form id="df-{{$item->id}}" action="{{route('admin.laporan.destroy',$item->id)}}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                        </div></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center"><p class="text-slate-500 dark:text-slate-400">@if(request('search')||request('jenis')||request('status'))Tidak ditemukan @else Belum ada laporan @endif</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($laporans->hasPages())
        <div class="border-t border-slate-200 dark:border-slate-800 px-6 py-4">{{$laporans->links()}}</div>
        @endif
    </div>
</div>
@endsection