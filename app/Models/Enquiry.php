<?php
// ====================================================
// FILE 1: app/Models/Enquiry.php
// ====================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'address',
        'type_of_enquiry',
        'date_of_requirement',
        'message',
        'status',
    ];

    protected $dates = ['date_of_requirement'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


// ====================================================
// FILE 2: database/migrations/xxxx_create_enquiries_table.php
// ====================================================
// php artisan make:migration create_enquiries_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('mobile', 10);
            $table->text('address');
            $table->enum('type_of_enquiry', [
                'Bus Booking',
                'Sleeper Coach Booking',
                'Package Tours',
                'Bus Rental'
            ]);
            $table->date('date_of_requirement')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'resolved'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};


// ====================================================
// FILE 3: routes/web.php  (add these routes)
// ====================================================

use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/enquiry', [DashboardController::class, 'storeEnquiry'])->name('enquiry.store');
});