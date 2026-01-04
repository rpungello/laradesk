<?php

namespace App\Http\Controllers;

use App\Enums\TicketType;
use App\Enums\Visibility;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PostmarkController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $ticket = Ticket::create([
            'title' => $request->input('Subject'),
            'type' => TicketType::Question,
            'user_id' => $this->getRequestingUser($request)->getKey(),
            'assigned_user_id' => User::whereEmailWebhook($request->input('From'))->value('id'),
        ]);

        $ticket->comments()->create([
            'visibility' => Visibility::Public,
            'user_id' => $ticket->user_id,
            'content' => $request->input('TextBody'),
        ]);

        return response('Created', Response::HTTP_CREATED);
    }

    private function getRequestingUser(Request $request): User
    {
        $textBody = $request->input('TextBody');
        $name = null;
        $email = null;

        // Attempt to extract original sender from a forwarded email in the body.
        if (is_string($textBody) && preg_match('/^From:\s*(.+?)\s*<([^>]+)>/mi', $textBody, $matches)) {
            $name = trim($matches[1], "\"'");
            $email = trim($matches[2]);
        }

        // Fallback to the webhook's From and FromName fields.
        if (empty($email)) {
            $email = $request->input('From');
            $name = $request->input('FromName') ?? null;
        }

        $email = strtolower($email);

        // Locate or create the user based on the determined email.
        return User::firstOrCreate(
            ['email' => $email],
            ['name' => $name ?? $email, 'password' => Str::random()]
        );
    }
}
