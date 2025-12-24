<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:token
                            {email? : The email of the user (defaults to test@example.com)}
                            {--name=api-token : The name of the token}
                            {--abilities=* : Abilities for the token (defaults to all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Sanctum API token for a user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email') ?? 'test@example.com';
        $tokenName = $this->option('name');
        $abilities = $this->option('abilities');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User with email '{$email}' not found.");

            return self::FAILURE;
        }

        // If no abilities specified, grant all abilities (*)
        $tokenAbilities = empty($abilities) ? ['*'] : $abilities;

        $token = $user->createToken($tokenName, $tokenAbilities);

        $this->info("Token created successfully for user: {$user->name} ({$user->email})");
        $this->line('');
        $this->line('Token:');
        $this->line($token->plainTextToken);
        $this->line('');
        $this->info('Use this token in your API requests with the Authorization header:');
        $this->line('Authorization: Bearer '.$token->plainTextToken);

        return self::SUCCESS;
    }
}
