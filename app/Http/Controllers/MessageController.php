<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Action\FetchColleaguesAction;
use App\Action\StoreMessageAction;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Hash;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use RuntimeException;

class MessageController extends Controller
{
    public function create(Request $request): Renderable
    {
        if ($request->session()->has('messageRouteKey')) {
            return view('share');
        }

        $colleagues = (new FetchColleaguesAction())->handle();

        return view('create', ['colleagues' => $colleagues]);
    }

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (!is_array($validated)) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        try {
            [$message, $password] = (new StoreMessageAction(
                message: $validated['message'],
                colleagueEmail: $validated['colleague_email'] ?? null,
            ))->handle();
        } catch (RuntimeException $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }


        return back()
            ->with('messageRouteKey', $message->getRouteKey())
            ->with('hasEmail', $message->colleague_email !== null)
            ->with('password', $password);
    }

    public function show(Request $request, Message $message): Renderable
    {
        if ($message->isExpired()) {
            $message->delete();
            return view('expired');
        }

        if (Hash::check($request->get('password'), $message->password_hash))
        {
            return view('show', [
                'messageTimestamp' => $message->created_at->format('d/m/Y H:i:s'),
                'messageRouteKey' => $message->getRouteKey(),
                'decryptedContents' => Crypt::decrypt($message->message),
                'password' => $request->get('password')]
            );
        }

        return view('unlock', [
            'messageRouteKey' => $message->getRouteKey(),
            'passwordSubmitted' => $request->has('password'),
        ]);
    }

    public function destroy(Request $request, Message $message): Response
    {
        if (!Hash::check($request->get('password'), $message->password_hash))
        {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        $message->delete();

        return response('Message deleted', 200);
    }
}
