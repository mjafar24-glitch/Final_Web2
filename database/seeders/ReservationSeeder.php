<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\BookCopy;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 Pending Reservations
        Reservation::factory(5)->create();

        // 5 Fulfilled Reservations
        $copies = BookCopy::inRandomOrder()->limit(5)->get();
        foreach ($copies as $copy) {
            Reservation::factory()->create([
                'book_id' => $copy->book_id,
                'allocated_copy_id' => $copy->id,
                'status' => 'fulfilled',
            ]);
        }

        // 5 Expired Reservations
        Reservation::factory(5)->create([
            'status' => 'expired',
            'expiry_date' => Carbon::now()->subDays(1),
        ]);
        
        // 2 Pending but Allocated Reservations (Waiting to be picked up)
        $waitingCopies = BookCopy::where('status', 'available')->inRandomOrder()->limit(2)->get();
        foreach ($waitingCopies as $copy) {
            Reservation::factory()->create([
                'book_id' => $copy->book_id,
                'allocated_copy_id' => $copy->id,
                'status' => 'pending',
                'expiry_date' => Carbon::now()->addDays(2),
            ]);
            $copy->update(['status' => 'reserved']);
        }
    }
}
