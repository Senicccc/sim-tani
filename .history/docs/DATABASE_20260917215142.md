# SIM-TANI Database Design

## Users

- `id`
- `nomor_anggota` (unique)
- `nama_lengkap`
- `foto`
- `nomor_wa`
- `email` (unique)
- `password`
- `role` (`admin`, `anggota`)
- `status_aktif`
- timestamps

## jenis_pekerjaan

- `id`
- `nama_pekerjaan`
- `deskripsi`
- `satuan`
- `tarif_default`
- `status_aktif`
- `created_by` -> users.id
- timestamps

## anggota_jenis_pekerjaan

- `id`
- `anggota_id` -> users.id
- `jenis_pekerjaan_id` -> jenis_pekerjaan.id
- `tingkat_kemampuan`
- timestamps

## kegiatan

- `id`
- `nama_kegiatan`
- `deskripsi`
- `lokasi`
- `tanggal_mulai`
- `tanggal_selesai`
- `status`
- `metode_penjadwalan`
- `created_by` -> users.id
- timestamps

## kegiatan_pekerjaan

- `id`
- `kegiatan_id` -> kegiatan.id
- `jenis_pekerjaan_id` -> jenis_pekerjaan.id
- `jumlah_orang_dibutuhkan`
- `jumlah_satuan`
- `tarif_per_satuan`
- `tingkat_kemampuan_minimal`
- `catatan`
- timestamps

## penugasan

- `id`
- `kegiatan_pekerjaan_id` -> kegiatan_pekerjaan.id
- `anggota_id` -> users.id
- `status`
- `sumber_penugasan`
- `assigned_at`
- `started_at`
- `completed_at`
- `catatan_penyelesaian`
- `bukti_selesai`
- `verified_by` -> users.id
- `verified_at`
- `catatan_verifikasi`
- timestamps

## presensi

- `id`
- `penugasan_id` -> penugasan.id
- `waktu_check_in`
- `waktu_check_out`
- `status`
- `catatan`
- timestamps

## upah

- `id`
- `penugasan_id` -> penugasan.id
- `mode_perhitungan`
- `tarif_per_satuan`
- `jumlah_satuan`
- `jumlah_upah`
- `status_pembayaran`
- `tanggal_pembayaran`
- `dibayar_oleh` -> users.id
- `catatan`
- timestamps

## permintaan_perubahan

- `id`
- `penugasan_id` -> penugasan.id
- `diajukan_oleh` -> users.id
- `jenis_permintaan`
- `target_penugasan_id` -> penugasan.id
- `target_anggota_id` -> users.id
- `alasan`
- `status`
- `diproses_oleh` -> users.id
- `diproses_at`
- `catatan_admin`
- timestamps
