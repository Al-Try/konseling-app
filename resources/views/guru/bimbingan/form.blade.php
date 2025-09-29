@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
  <form method="POST" action="{{ route('guru.bimbingan.store') }}">
    @csrf
    <label class="block mb-2">Siswa</label>
    <select id="siswa-select" name="siswa_id" class="input w-full" required></select>

    <label class="block mt-4 mb-2">Jenis</label>
    <select name="jenis_id" class="input w-full" required>
      @foreach($jenis as $j)
        <option value="{{ $j->id }}">{{ $j->nama_jenis }} ({{ $j->poin }})</option>
      @endforeach
    </select>

    <div class="grid grid-cols-2 gap-3 mt-4">
      <div>
        <label class="block mb-2">Tanggal</label>
        <input type="date" name="tanggal" class="input w-full" required value="{{ date('Y-m-d') }}">
      </div>
      <div>
        <label class="block mb-2">Jam</label>
        <input type="time" name="jam" class="input w-full" value="{{ date('H:i') }}">
      </div>
    </div>

    <label class="block mt-4 mb-2">Catatan</label>
    <textarea name="catatan" class="input w-full" rows="4"></textarea>

    <div class="mt-6"><button class="btn-primary">Simpan</button></div>
  </form>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$('#siswa-select').select2({
  placeholder: 'Cari siswa...',
  ajax: {
    url: "{{ route('guru.bimbingan.siswa.search') }}",
    dataType: 'json',
    delay: 250,
    data: params => ({ q: params.term }),
    processResults: data => ({ results: data })
  },
  minimumInputLength: 1,
});
</script>
@endpush
