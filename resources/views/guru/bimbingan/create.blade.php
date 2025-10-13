@extends('layouts.app')
@section('page_title','Tambah Bimbingan')

@section('content')
<div class="container-fluid" style="max-width:720px">
  <h5 class="mb-3">Tambah Bimbingan</h5>

  <form method="POST" action="{{ route('guru.bimbingan.store') }}" class="card card-body">
    @csrf
    <div class="mb-3">
      <label class="form-label">Tanggal</label>
      <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="form-control" required>
      @error('tanggal') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Cari Siswa</label>
      <input type="text" id="cari-siswa" class="form-control" placeholder="Ketik nama siswa...">
      <input type="hidden" name="siswa_id" id="siswa_id" value="{{ old('siswa_id') }}" required>
      <div id="hint-siswa" class="list-group position-absolute shadow" style="z-index:1000"></div>
      @error('siswa_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Jenis</label>
      <select name="jenis_id" class="form-select" required>
        <option value="">-- pilih --</option>
        @foreach($jenis as $j)
          <option value="{{ $j->id }}" @selected(old('jenis_id')==$j->id)>
            {{ $j->nama_jenis }} ({{ $j->poin }})
          </option>
        @endforeach
      </select>
      @error('jenis_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Catatan</label>
      <textarea name="catatan" rows="4" class="form-control">{{ old('catatan') }}</textarea>
      @error('catatan') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('guru.bimbingan.index') }}" class="btn btn-light">Batal</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  const input = document.getElementById('cari-siswa');
  const hint  = document.getElementById('hint-siswa');
  const hid   = document.getElementById('siswa_id');

  let lastQ  = '';
  let timer  = null;

  input.addEventListener('input', function() {
    const q = this.value.trim();
    if (q.length < 2) { hint.innerHTML=''; hint.style.display='none'; return; }
    clearTimeout(timer);
    timer = setTimeout(() => fetchSiswa(q), 250);
  });

  function fetchSiswa(q) {
    if (q === lastQ) return;
    lastQ = q;
    fetch(`{{ route('guru.bimbingan.siswa.search') }}?q=${encodeURIComponent(q)}`)
      .then(r => r.json())
      .then(rows => {
        hint.innerHTML = '';
        rows.forEach(r => {
          const a = document.createElement('a');
          a.href = '#'; a.className = 'list-group-item list-group-item-action';
          a.textContent = r.text;
          a.onclick = (e) => { e.preventDefault(); input.value = r.text; hid.value = r.id; hint.innerHTML=''; hint.style.display='none'; }
          hint.appendChild(a);
        });
        hint.style.display = rows.length ? 'block' : 'none';
      })
      .catch(() => { hint.innerHTML=''; hint.style.display='none'; });
  }

  document.addEventListener('click', (e) => {
    if (!hint.contains(e.target) && e.target !== input) {
      hint.innerHTML=''; hint.style.display='none';
    }
  });
</script>
@endpush


<input id="cari-siswa" class="form-control" placeholder="Cari siswa...">
<input type="hidden" name="siswa_id" id="siswa_id">

@push('scripts')
<script>
const box  = document.getElementById('cari-siswa');
const hid  = document.getElementById('siswa_id');
let timer=null;

box.addEventListener('input', () => {
  clearTimeout(timer);
  timer=setTimeout(async()=>{
    const q = box.value.trim();
    if(!q){ return; }
    const url = "{{ route('guru.bimbingan.siswa.search') }}?q="+encodeURIComponent(q);
    const res = await fetch(url);
    const data = await res.json();
    if(data.results?.length){
      const pick = data.results[0]; // ambil yang pertama (sederhana)
      box.value = pick.text;
      hid.value = pick.id;
    }
  }, 300);
});
</script>
@endpush

