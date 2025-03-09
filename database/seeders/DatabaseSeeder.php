<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First batch: Base tables with no dependencies
        Schema::disableForeignKeyConstraints();
        $this->call(UserSeeder::class);
        $this->call(GedungSeeder::class);
        $this->call(FasilitasSeeder::class);
        $this->call(KbkSeeder::class);
        $this->call(BidangSeeder::class);
        $this->call(ProdiSeeder::class);
        $this->call(PeriodePengajuanSeeder::class);
        $this->call(SubKategoriSeeder::class);
        $this->call(AmbangBatasSeeder::class);
        Schema::enableForeignKeyConstraints();

        // Second batch: First level dependencies
        Schema::disableForeignKeyConstraints();
        $this->call(DosenSeeder::class); // depends on User, KBK
        $this->call(RuanganSeeder::class); // depends on Gedung
        $this->call(KotaSeeder::class); // depends on Bidang
        Schema::enableForeignKeyConstraints();

        // Third batch: Second level dependencies
        Schema::disableForeignKeyConstraints();
        $this->call(MahasiswaSeeder::class); // depends on User, Prodi, Kota
        $this->call(KaprodiSeeder::class); // depends on Dosen, Prodi
        $this->call(JadwalDosenPembimbingSeeder::class); // depends on Dosen
        $this->call(KetertarikanBidangSeeder::class); // depends on Dosen, Bidang
        $this->call(RuangFasilitasSeeder::class); // depends on Fasilitas, Ruangan
        $this->call(LabelSeeder::class); // depends on Kota
        Schema::enableForeignKeyConstraints();

        // Fourth batch: Higher level dependencies
        Schema::disableForeignKeyConstraints();
        $this->call(PengajuanPembimbingSeeder::class); // depends on Kota
        $this->call(PrioritasPembimbingSeeder::class); // depends on PengajuanPembimbing, Dosen
        $this->call(AlokasiPembimbingSeeder::class); // depends on PengajuanPembimbing, Dosen
        $this->call(PengajuanPisahKotaSeeder::class); // depends on Mahasiswa, Kota
        Schema::enableForeignKeyConstraints();

        // Fifth batch: Assessment related
        Schema::disableForeignKeyConstraints();
        $this->call(FormPenilaianSeeder::class); // depends on Dosen
        $this->call(KategoriPenilaianSeeder::class); // depends on FormPenilaian
        $this->call(RubrikPenilaianSeeder::class); // depends on KategoriPenilaian
        $this->call(PenilaianRubrikSeeder::class); // depends on Mahasiswa, Dosen, RubrikPenilaian
        $this->call(PenilaianKategoriSeeder::class); // depends on Mahasiswa
        Schema::enableForeignKeyConstraints();

        // Sixth batch: Document related
        Schema::disableForeignKeyConstraints();
        $this->call(DokumenSeeder::class); // depends on Kota, Label, SubKategori, User
        $this->call(ListJurnalPlagiarismeSeeder::class); // no dependencies
        $this->call(ListKalimatPlagiarismeSeeder::class); // depends on Dokumen, ListJurnalPlagiarisme
        $this->call(MahasiswaDosenDokumenSeeder::class); // depends on Dosen, Mahasiswa, Dokumen
        Schema::enableForeignKeyConstraints();

        // Seventh batch: Scheduling related
        Schema::disableForeignKeyConstraints();
        $this->call(PenjadwalanSeeder::class); // depends on Ruangan, Kota, Dosen
        $this->call(KehadiranSeeder::class); // depends on Penjadwalan, User
        $this->call(KonfirmasiSeeder::class); // depends on Penjadwalan, Dosen
        Schema::enableForeignKeyConstraints();

        // Eighth batch: Notification related
        Schema::disableForeignKeyConstraints();
        $this->call(NotifikasiSeeder::class); // no dependencies
        $this->call(NotifikasiKirimSeeder::class); // depends on Notifikasi, User
        $this->call(PreferensiNotifikasiSeeder::class); // depends on User
        Schema::enableForeignKeyConstraints();

        // Ninth batch: Logs (should be last as they depend on many entities)
        Schema::disableForeignKeyConstraints();
        $this->call(LogAktivitasSeeder::class); // depends on Kota, User, Dokumen
        Schema::enableForeignKeyConstraints();
    }
}