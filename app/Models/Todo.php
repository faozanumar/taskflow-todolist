<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'prioritas',
        'tags',
        'is_penting',
        'tanggal_deadline',
        'status',
    ];

    protected $casts = [
        'tags'        => 'array',
        'is_penting'  => 'boolean',
        'tanggal_deadline' => 'date',
    ];

    // Konstanta pilihan
    public static array $kategoriOptions = [
        'pekerjaan'  => 'Pekerjaan',
        'pribadi'    => 'Pribadi',
        'belanja'    => 'Belanja',
        'kesehatan'  => 'Kesehatan',
        'pendidikan' => 'Pendidikan',
        'lainnya'    => 'Lainnya',
    ];

    public static array $prioritasOptions = [
        'rendah'  => 'Rendah',
        'sedang'  => 'Sedang',
        'tinggi'  => 'Tinggi',
        'kritis'  => 'Kritis',
    ];

    public static array $tagsOptions = [
        'rumah'      => 'Rumah',
        'kantor'     => 'Kantor',
        'segera'     => 'Segera',
        'menunggu'   => 'Menunggu',
        'delegasi'   => 'Delegasi',
        'review'     => 'Review',
    ];

    public static array $statusOptions = [
        'belum'       => 'Belum Dikerjakan',
        'proses'      => 'Sedang Dikerjakan',
        'selesai'     => 'Selesai',
        'dibatalkan'  => 'Dibatalkan',
    ];

    public function getPrioritasColorAttribute(): string
    {
        return match($this->prioritas) {
            'rendah'  => 'success',
            'sedang'  => 'warning',
            'tinggi'  => 'danger',
            'kritis'  => 'dark',
            default   => 'secondary',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'belum'      => 'secondary',
            'proses'     => 'primary',
            'selesai'    => 'success',
            'dibatalkan' => 'danger',
            default      => 'secondary',
        };
    }

    public function isOverdue(): bool
    {
        return $this->status !== 'selesai'
            && $this->status !== 'dibatalkan'
            && $this->tanggal_deadline->isPast();
    }
}
