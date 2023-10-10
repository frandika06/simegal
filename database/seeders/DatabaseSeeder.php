<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Simegal Untuk Portal Website
        $this->call(AdminSimegalSeeder::class);
        /*
        | PORTAL APPS
         */
        // general generate
        $this->call(PortalGeneralSeeder::class);
        // generate post by API
        $this->call(PortalPostinganSeeder::class);
        // generate page by API
        $this->call(PortalPageSeeder::class);
        // generate banner by API
        $this->call(PortalBannerSeeder::class);
        // generate galeri dan datanya by API
        $this->call(PortalGaleriSeeder::class);
        // generate video by API
        $this->call(PortalVideoSeeder::class);
        // generate unduhan by API
        $this->call(PortalUnduhanSeeder::class);
        // generate pesan by API
        $this->call(PortalPesanSeeder::class);
        // generate FAQ by API
        $this->call(PortalFAQSeeder::class);
        /*
        | PENJADWALAN DAN PENUGASAN APPS
         */
        // generate perusahaan
        $this->call(PerusahaanSeeder::class);
        // generate alamat perusahaan
        $this->call(AlamatPerusahaanSeeder::class);
        // generate permohonan peneraan
        $this->call(PermohonanPeneraanSeeder::class);
        /*
        | PENGATURAN APPS
         */
        // generate UTTP - jenis pelayanan
        $this->call(MasterUTTPJenisPelayananSeeder::class);
        // generate UTTP - kelompok uttp
        $this->call(MasterUTTPKelompokUTTPSeeder::class);
        // generate UTTP - kategori kelompok
        $this->call(MasterUTTPKategoriKelompokSeeder::class);
        // generate Instrumen UTTP - jenis uttp
        $this->call(MasterInstrumenJenisUttpSeeder::class);
    }
}
