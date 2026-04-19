<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\MeetingDocument;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // DAFTAR LAPORAN RAPAT (untuk halaman Laporan Sekretaris)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Daftar rapat dengan status kelengkapan lampiran.
     *
     * GET /laporan/rapat
     *
     * Query params:
     *  - search   : cari berdasarkan judul rapat atau nama ruangan
     *  - date     : filter tanggal (format: Y-m-d)
     *  - status   : filter status (menunggu, berlangsung, selesai, dibatalkan)
     *  - per_page : jumlah per halaman (default 10)
     *
     * Setiap item mengembalikan:
     *  - data rapat (id, title, organizer, room, start_time, end_time, status)
     *  - lampiran.has_undangan   : bool — ada dokumen type='undangan'
     *  - lampiran.has_notulensi  : bool — ada entry di meeting_minutes
     *  - lampiran.has_dokumentasi: bool — ada dokumen type selain 'undangan'
     */
    public function index(Request $request)
    {
        try {
            // Auto-update statuses sebelum menampilkan
            $this->autoUpdateStatuses();

            $query = Meeting::with([
                'room:id,name,location',
                'documents:id,meeting_id,type',
                'minutes:id,meeting_id',
            ]);

            // Filter: search judul atau nama ruangan
            if ($request->filled('search')) {
                $search = $request->query('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('organizer', 'like', "%{$search}%")
                      ->orWhereHas('room', function ($r) use ($search) {
                          $r->where('name', 'like', "%{$search}%");
                      });
                });
            }

            // Filter: tanggal
            if ($request->filled('date')) {
                $query->whereDate('start_time', $request->query('date'));
            }

            // Filter: status
            if ($request->filled('status')) {
                $query->where('status', $request->query('status'));
            }

            $perPage = (int) $request->query('per_page', 15);
            $meetings = $query->latest('start_time')->paginate($perPage);

            // Transform: tambahkan info lampiran
            $meetings->getCollection()->transform(function ($meeting) {
                // has_undangan: ada dokumen dengan type = 'undangan'
                $hasUndangan = $meeting->documents
                    ->where('type', 'undangan')
                    ->isNotEmpty();

                // has_notulensi: ada baris di meeting_minutes
                $hasNotulensi = $meeting->minutes !== null;

                // has_dokumentasi: ada dokumen dengan type BUKAN 'undangan'
                $hasDokumentasi = $meeting->documents
                    ->whereNotIn('type', ['undangan'])
                    ->isNotEmpty();

                return [
                    'id'         => $meeting->id,
                    'title'      => $meeting->title,
                    'organizer'  => $meeting->organizer,
                    'start_time' => $meeting->start_time,
                    'end_time'   => $meeting->end_time,
                    'status'     => $meeting->status,
                    'room'       => $meeting->room,
                    'lampiran'   => [
                        'has_undangan'    => $hasUndangan,
                        'has_notulensi'   => $hasNotulensi,
                        'has_dokumentasi' => $hasDokumentasi,
                    ],
                ];
            });

            return response()->json([
                'message' => 'Laporan rapat berhasil diambil',
                'data'    => $meetings,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil laporan rapat',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DETAIL LAPORAN SATU RAPAT (untuk aksi "View")
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Detail lengkap laporan satu rapat.
     *
     * GET /laporan/rapat/{id}
     *
     * Mengembalikan:
     *  - data rapat lengkap
     *  - peserta + kehadiran (summary)
     *  - notulensi (konten Quill)
     *  - semua dokumen dengan URL download
     */
    public function show(string $id)
    {
        try {
            $meeting = Meeting::with([
                'room',
                'participants.employee.workUnit',
                'attendances',
                'minutes',
                'documents',
            ])->find($id);

            if (!$meeting) {
                return response()->json(['message' => 'Rapat tidak ditemukan'], 404);
            }

            // Summary kehadiran
            $totalPeserta  = $meeting->participants->count();
            $hadirCount    = $meeting->attendances->where('status', 'hadir')->count();
            $tidakHadir    = $totalPeserta - $hadirCount;

            // Dokumen + URL publik
            $documents = $meeting->documents->map(function ($doc) {
                return [
                    'id'        => $doc->id,
                    'type'      => $doc->type,
                    'file_name' => $doc->file_name,
                    'file_size' => $doc->file_size,
                    'mime_type' => $doc->mime_type,
                    'url'       => Storage::disk('public')->exists($doc->file_path)
                                    ? asset('storage/' . $doc->file_path)
                                    : null,
                    'created_at' => $doc->created_at,
                ];
            });

            return response()->json([
                'message' => 'Detail laporan rapat berhasil diambil',
                'data'    => [
                    'meeting'            => $meeting->only([
                        'id', 'title', 'organizer', 'start_time', 'end_time', 'status',
                    ]),
                    'room'               => $meeting->room,
                    'attendance_summary' => [
                        'total'       => $totalPeserta,
                        'hadir'       => $hadirCount,
                        'tidak_hadir' => max(0, $tidakHadir),
                    ],
                    'notulensi'          => $meeting->minutes,
                    'documents'          => $documents,
                    'lampiran'           => [
                        'has_undangan'    => $documents->where('type', 'undangan')->isNotEmpty(),
                        'has_notulensi'   => $meeting->minutes !== null,
                        'has_dokumentasi' => $documents->whereNotIn('type', ['undangan'])->isNotEmpty(),
                    ],
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil detail laporan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EXPORT DATA RAPAT (untuk aksi "Download" — JSON untuk FE generate PDF)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Export data lengkap satu rapat (untuk FE generate PDF).
     *
     * GET /laporan/rapat/{id}/export
     *
     * Mengembalikan semua data yang diperlukan FE untuk membuat PDF:
     *  - info rapat, peserta + kehadiran, notulensi, dokumen
     */
    public function export(string $id)
    {
        try {
            $meeting = Meeting::with([
                'room',
                'participants.employee.workUnit',
                'attendances.employee',
                'minutes',
                'documents',
            ])->find($id);

            if (!$meeting) {
                return response()->json(['message' => 'Rapat tidak ditemukan'], 404);
            }

            // Peserta + status kehadiran
            $peserta = $meeting->participants->map(function ($p) use ($meeting) {
                $attendance = $meeting->attendances
                    ->where('employee_id', $p->employee_id)
                    ->first();

                return [
                    'nama'        => $p->employee?->full_name ?? 'Karyawan (Dihapus)',
                    'nip'         => $p->employee?->nip ?? '-',
                    'unit_kerja'  => $p->employee?->workUnit?->work_unit ?? '-',
                    'status'      => $attendance ? 'Hadir' : 'Tidak Hadir',
                    'check_in'    => $attendance?->check_in_time,
                ];
            });

            // Dokumen + URL
            $documents = $meeting->documents->map(function ($doc) {
                return [
                    'id'        => $doc->id,
                    'type'      => $doc->type,
                    'file_name' => $doc->file_name,
                    'mime_type' => $doc->mime_type,
                    'url'       => Storage::disk('public')->exists($doc->file_path)
                                    ? asset('storage/' . $doc->file_path)
                                    : null,
                ];
            });

            return response()->json([
                'message' => 'Data export rapat berhasil diambil',
                'data'    => [
                    'rapat'       => [
                        'id'         => $meeting->id,
                        'judul'      => $meeting->title,
                        'penyelenggara' => $meeting->organizer,
                        'ruangan'    => $meeting->room?->name,
                        'lokasi'     => $meeting->room?->location,
                        'tanggal'    => Carbon::parse($meeting->start_time)->translatedFormat('d F Y'),
                        'waktu_mulai'  => Carbon::parse($meeting->start_time)->format('H:i'),
                        'waktu_selesai' => Carbon::parse($meeting->end_time)->format('H:i'),
                        'status'     => $meeting->status,
                    ],
                    'ringkasan_kehadiran' => [
                        'total'       => $meeting->participants->count(),
                        'hadir'       => $meeting->attendances->where('status', 'hadir')->count(),
                        'tidak_hadir' => max(0, $meeting->participants->count() - $meeting->attendances->where('status', 'hadir')->count()),
                    ],
                    'peserta'     => $peserta,
                    'notulensi'   => $meeting->minutes ? [
                        'content'          => $meeting->minutes->content,
                        'notulis_name'     => $meeting->minutes->notulis_name,
                        'notulis_position' => $meeting->minutes->notulis_position,
                        'director_name'     => $meeting->minutes->director_name,
                        'director_position' => $meeting->minutes->director_position,
                    ] : null,
                    'dokumen'     => $documents,
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat export laporan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // HELPER
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Auto-update semua status rapat berdasarkan waktu sekarang.
     */
    private function autoUpdateStatuses(): void
    {
        $now = Carbon::now();

        Meeting::where('status', '!=', 'dibatalkan')->get()->each(function ($meeting) use ($now) {
            if ($now->greaterThan($meeting->end_time)) {
                $newStatus = 'selesai';
            } elseif ($now->greaterThanOrEqualTo($meeting->start_time) && $now->lessThanOrEqualTo($meeting->end_time)) {
                $newStatus = 'berlangsung';
            } else {
                $newStatus = 'menunggu';
            }

            if ($newStatus !== $meeting->status) {
                $meeting->update(['status' => $newStatus]);
            }
        });
    }
}
