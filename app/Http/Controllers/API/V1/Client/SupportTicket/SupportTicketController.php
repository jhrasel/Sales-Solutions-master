<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers\API\V1\Client\SupportTicket;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\SupportTicket;
use App\Models\TicketComment;
use App\Traits\sendApiResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class SupportTicketController extends Controller
{
    use sendApiResponse;
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'merchant_id' => 'required'
        ]);
        $tickets = SupportTicket::query()->with('attachment', 'comments', 'comments.user', 'comments.attachment')
            ->where('user_id', $request->input('merchant_id'))
            ->get();

        return $this->sendApiResponse($tickets);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'merchant_id' => 'required',
            'subject' => 'required|min:6',
            'content' => 'required|min:10'
        ]);

        $ticket = SupportTicket::query()->create([
            'user_id' => $request->input('merchant_id'),
            'ticket_id' => mt_rand(11111, 99999),
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
        ]);

        if ($request->hasFile('attachment')) {
            $attachment = $this->uploadAttachment($request);
            $ticket->update(['attachment_id' => $attachment]);
            $ticket->load('attachment');
        }
        return $this->sendApiResponse($ticket, 'Successfully ticket created');
    }

    /**
     * @param $merchant
     * @param $id
     * @return JsonResponse
     */
    public function show($merchant, $id): JsonResponse
    {
        $ticket = SupportTicket::query()->with('attachment')
            ->where('user_id', $merchant)
            ->where('id', $id)
            ->first();
        return $this->sendApiResponse($ticket);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function reply(Request $request, $id): JsonResponse
    {
        $request->validate([
            'merchant_id' => 'required',
            'content' => 'required|min:10',
        ]);
        $ticket = SupportTicket::query()->where('user_id', $request->input('merchant_id'))->where('id', $id)->first();

        if (!$ticket) {
            return response()->json(['message' => 'No Ticket Found, Please Select Valid Ticket Id']);
        }

        $comment = TicketComment::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->input('merchant_id'),
            'content' => $request->input('content'),
        ]);

        if ($request->hasFile('attachment')) {
            $attachment = $this->uploadAttachment($request);
            $comment->update(['attachment_id' => $attachment]);
        }

        $comment->load(['attachment', 'user']);

        return $this->sendApiResponse($comment, 'Reply has been sent successfully');
    }

    public function uploadAttachment($request)
    {
        $fileExt = $request->file('attachment')->getClientOriginalExtension();
        $size = $request->file('attachment')->getSize();
        $type = $request->file('attachment')->getMimeType();

        $path = '/upload/support-ticket';
        $name = Carbon::now()->format('YmdHis') . '-' . uniqid() . '.' . $fileExt;
        $image = $request->file('attachment')->storeAs($path, $name, 'local');

        $attachment = Attachment::query()->create([
            'name' => $name,
            'type' => $type,
            'size' => $size,
            'path' => $image,
        ]);

        return $attachment->id;
    }
}
