# SIM-TANI Business Rules

## Role Rules

- Hanya terdapat dua role: `admin` dan `anggota`.
- Endpoint admin hanya dapat diakses oleh user dengan role `admin`.
- Endpoint anggota hanya dapat diakses oleh user yang sedang login dan memiliki role `anggota`.

## User Rules

- `nomor_anggota` bersifat unik.
- Setiap anggota harus punya `status_aktif` yang benar.
- User non-aktif tidak boleh menerima tugas baru.

## Job Competency Rules

- Jenis pekerjaan didefinisikan di tabel `jenis_pekerjaan`.
- Kompetensi anggota disimpan pada tabel `anggota_jenis_pekerjaan`.
- Penjadwalan hanya mempertimbangkan anggota yang sesuai jenis pekerjaan dan tingkat kemampuan.

## Scheduling Rules

- Jadwal kegiatan menggunakan metode `otomatis` atau `manual`.
- Scheduler otomatis memilih anggota yang paling layak berdasarkan jumlah tugas selesai dan kelayakan kompetensi.
- Jika kuota tidak terpenuhi, sistem mengembalikan warning dan tetap menyimpan hasil partial schedule.

## Assignment Rules

- Status tugas dapat berupa `assigned`, `in_progress`, `waiting_verification`, `completed`, atau `cancelled`.
- Anggota hanya dapat mulai dan menyelesaikan tugas miliknya sendiri.
- Admin melakukan verifikasi tugas sebelum status final `completed`.

## Attendance Rules

- Presensi terkait satu penugasan tertentu.
- Check-in dan check-out harus dinilai valid agar status attendance dapat digunakan untuk laporan.

## Wage Rules

- Upah dapat dihitung otomatis atau manual.
- Pembayaran dinilai dengan status `belum_dibayar` atau `sudah_dibayar`.

## Change Request Rules

- Permintaan perubahan dapat berupa `tukar` atau `sanggah`.
- Admin memproses dengan status `pending`, `approved`, atau `rejected`.
