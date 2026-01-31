<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class DeleteInactiveUsers extends Command
{
    protected $signature = 'users:cleanup';
    protected $description = 'Delete users without role or member_code after 1 month';

    public function handle()
    {
        $date = Carbon::now()->subMonth();

        $deleted = User::whereNull('role')
            ->whereNull('member_code')
            ->where('created_at', '<=', $date)
            ->delete();

        $this->info("Deleted {$deleted} inactive users.");
    }
}
