<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;

class ExpireReservationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire reservations that have passed their expiry date and return book copies to available status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredReservations = Reservation::where('status', 'pending')
            ->whereNotNull('allocated_copy_id')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', Carbon::now())
            ->get();

        if ($expiredReservations->isEmpty()) {
            $this->info('Tidak ada reservasi yang kedaluwarsa.');
            return 0;
        }

        $count = 0;
        foreach ($expiredReservations as $reservation) {
            // Return the book copy to available
            if ($reservation->allocatedCopy) {
                $reservation->allocatedCopy->update(['status' => 'available']);
            }

            $reservation->update(['status' => 'expired']);
            $count++;

            $this->line("Reservasi #{$reservation->id} untuk member {$reservation->member->name} telah di-expired.");
        }

        $this->info("Selesai. {$count} reservasi telah diubah menjadi expired.");
        return 0;
    }
}
