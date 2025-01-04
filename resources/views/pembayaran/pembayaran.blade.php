<x-layouts>
  <x-slot:title>{{ $title }}</x-slot:title>

  <div class="bg-[#2D3748] py-16 sm:py-20">
    <div class="container mx-auto px-6 lg:px-8 w-full">

      <!-- Tombol untuk menambah group -->
      <div class="text-right mb-8">
        <a href="/" class="px-6 py-3 bg-[#3182CE] text-white rounded-lg hover:bg-[#003366] transition-all">
          Tambah Group
        </a>
      </div>

      <!-- Menampilkan Grup dalam bentuk card -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($groups as $group)
        <div class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg hover:shadow-xl transition-all">
          <!-- Bagian atas card -->
          <div class="p-6">
            <!-- Nama Grup -->
            <h3 class="text-2xl font-bold text-[#F7FAFC] mb-3">{{ $group->name }}</h3>
            
            <!-- Separator dengan garis tebal -->
            <hr class="border-[#FF6347] border-4 rounded mb-3">

            <!-- Deskripsi Grup -->
            <p class="text-sm text-[#E2E8F0] leading-relaxed">{{ $group->description }}</p>

            <!-- Tanggal Dibuat -->
            <p class="text-xs text-[#A0AEC0] mt-4">
              Dibuat pada: 
              {{ $group->created_at ? $group->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
            </p>
          </div>

          <!-- Bagian bawah card -->
          <div class="p-6 bg-[#2D3748] text-right">
            <a href="{{ route('List Admin', ['group' => $group->name]) }}" class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#003366] transition-all no-underline">
              Lihat Group
            </a>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>
</x-layouts>
