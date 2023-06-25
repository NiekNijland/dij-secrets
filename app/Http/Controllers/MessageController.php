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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class MessageController extends Controller
{
    public function create(Request $request): Renderable
    {
        if ($request->session()->get('messageRouteKey') !== null) {
            return view('share');
        }

        $colleagues = Cache::remember('colleagues', 3600, static function () {
            return (new FetchColleaguesAction())->handle();
        });

        return view('create', ['colleagues' => $colleagues]);
    }

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (!is_array($validated)) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        [$message, $password] = (new StoreMessageAction(
            message: $validated['message'],
            colleagueEmail: $validated['colleague_email'] ?? null,
        ))->handle();

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
                'message' => $message,
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
