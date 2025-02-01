<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_group_id',
        'name',
        'description',
        'loan_date',
        'total_amount',
        'total_payment',
        'outstanding_amount',
        'phone',
        'codes_id',
    ];
    protected static function booted()
    {
        // Event ketika Loan diubah
        static::updated(function ($loan) {
            // Cek apakah total_amount atau pembayaran telah berubah untuk menghindari update yang tidak perlu
            if ($loan->isDirty('total_amount') || $loan->payments->isNotEmpty() && $loan->payments->some(fn($payment) => $payment->isDirty('amount'))) {
                // Panggil method untuk memperbarui jumlah pembayaran dan jumlah pinjaman
                self::updatePaymentAndLoanAmounts($loan);
            }
        });

        // Event ketika Loan dibuat
        static::created(function ($loan) {
            // Cek apakah Loan memiliki relasi ke adminGroup
            $adminGroup = $loan->adminGroup;
            if ($adminGroup) {
                // Ambil admin yang terkait dengan adminGroup
                $admin = Admin::find($adminGroup->admin_id); // Ambil admin pertama yang terkait
                $manager = Manager::find($admin->manager_id);

                // Pastikan admin memiliki bonus yang terkait
                if ($admin) {
                    // Ambil bonus yang terkait dengan admin
                    $bonus = Bonuses::find($admin->bonus_id);
                    $bonusM = Bonuses::find($manager->bonus_id);
                    // Cek apakah bonus ditemukan
                    if ($bonus) {
                        // Ambil kode yang terkait dengan loan untuk menghitung bonus
                        $code = $loan->code;

                        if ($code) {
                            // Tambahkan bonus yang ada di kode ke bonus admin
                            $bonus->total_amount += $code->admin_bonuses;  // Menambahkan bonus amount dari kode ke bonus yang ada
                            $bonus->save(); // Simpan perubahan bonus ke database
                            $bonusM->total_amount += $code->manager_bonuses;
                            $bonusM->save();
                        }
                    }
                }
            }
        });
        // Event ketika Loan diperbarui
        static::updated(function ($loan) {
            // Cek apakah Loan memiliki relasi ke adminGroup
            $adminGroup = $loan->adminGroup;
            if ($adminGroup) {
                // Ambil admin yang terkait dengan adminGroup
                $admin = Admin::find($adminGroup->admin_id); // Ambil admin pertama yang terkait
                $manager = Manager::find($admin->manager_id);

                // Pastikan admin memiliki bonus yang terkait
                if ($admin) {
                    // Ambil bonus yang terkait dengan admin
                    $bonus = Bonuses::find($admin->bonus_id);
                    $bonusM = Bonuses::find($manager->bonus_id);
                    // Cek apakah bonus ditemukan
                    if ($bonus) {
                        // Ambil kode yang terkait dengan loan untuk menghitung bonus
                        $code = Code::find($loan->codes_id); // Gunakan codes_id yang terbaru

                        $previousCode = Code::find($loan->getOriginal('codes_id')); // Ambil kode sebelumnya menggunakan getOriginal
                        if ($previousCode) {
                            // Kurangi bonus berdasarkan kode sebelumnya
                            $previousBonus = $previousCode->admin_bonuses; // Bonus yang diberikan oleh kode sebelumnya
                            $bonus->total_amount -= $previousBonus;
                            $previousBonus = $previousCode->manager_bonuses;
                            $bonusM->total_amount -= $previousBonus; // Kurangi bonus sebelumnya
                        }

                        // Tambahkan bonus yang ada di kode baru
                        $bonus->total_amount += $code->admin_bonuses; // Menambahkan bonus amount dari kode baru ke bonus yang ada
                        // Simpan perubahan bonus ke database
                        $bonus->save();
                        $bonusM->total_amount += $code->manager_bonuses;
                        $bonusM->save();
                    }
                }
            }
        });
    }


    // Fungsi untuk memperbarui total_payment dan outstanding_amount
    private static function updatePaymentAndLoanAmounts($loan)
    {
        // Hanya hitung ulang jika ada perubahan yang relevan
        $totalPayment = $loan->payments->sum('amount');

        // Hanya lakukan update jika ada perubahan pada total_payment atau outstanding_amount
        if ($loan->total_payment !== $totalPayment || $loan->outstanding_amount !== ($loan->total_amount - $totalPayment)) {
            $loan->update([
                'total_payment' => $totalPayment,
                'outstanding_amount' => $loan->total_amount - $totalPayment,
            ]);
        }
    }

    /**
     * Relationship: Loan belongs to an Admin.
     */
    public function adminGroup(): BelongsTo
    {
        return $this->belongsTo(AdminGroups::class, 'admin_group_id');
    }

    /**
     * Relationship: Loan has many payments.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'loan_id');
    }

    /**
     * Relationship: Loan belongs to a Code.
     */
    public function code(): BelongsTo
    {
        return $this->belongsTo(Code::class, 'codes_id');
    }
    protected $with = ['code'];
}
