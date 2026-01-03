<?php

namespace App\Http\Controllers;

use App\Enums\TicketType;
use App\Enums\Visibility;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostmarkController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $ticket = Ticket::create([
            'title' => $request->input('Subject'),
            'type' => TicketType::Question,
            'user_id' => User::whereEmail($request->input('From'))->value('id'),
            'assigned_user_id' => User::whereEmail($request->input('From'))->value('id'),
        ]);

        $ticket->comments()->create([
            'visibility' => Visibility::Public,
            'user_id' => $ticket->user_id,
            'content' => $request->input('TextBody'),
        ]);

        return response('Created', Response::HTTP_CREATED);
    }
}
