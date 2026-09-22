<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'কোনো ইউজারকে ইমেইল দিয়ে অ্যাডমিন বানায়';

    public function handle(): int
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("এই ইমেইলে কোনো ইউজার পাওয়া যায়নি: {$email}");
            return self::FAILURE;
        }

        $user->update(['role' => 'admin']);
        $this->info("সফল! {$user->name} ({$email}) এখন অ্যাডমিন।");

        return self::SUCCESS;
    }
}
