<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\Shop;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class MerchantController extends AdminBaseController
{
    public function index()
    {
        return view('panel.merchants.index');
    }

    public function show($id)
    {
        $merchant = User::query()
            ->withCount(['support_ticket as total_opened_tickets' => function ($query) {
                $query->where('status', SupportTicket::OPENED);
            }, 'support_ticket as total_closed_tickets' => function ($query) {
                $query->where('status', SupportTicket::CLOSED);
            }, 'support_ticket as total_processing_tickets' => function ($query) {
                $query->where('status', SupportTicket::PROCESSING);
            }, 'support_ticket as total_solved_tickets' => function ($query) {
                $query->where('status', SupportTicket::SOLVED);
            }
            ])
            ->withCount('support_ticket')
            ->with('support_ticket', 'merchantinfo', 'shop')
            ->find($id);

        return view('panel.merchants.details', compact('merchant'));
    }

    public function changeStatus(Request $request, User $merchant): JsonResponse
    {
        if ($request->filled('status') == User::STATUS_ACTIVE) {
            $merchant->update(['status' => User::STATUS_ACTIVE]);
        }
        if ($request->input('status') == User::STATUS_INACTIVE) {
            $merchant->update(['status' => User::STATUS_INACTIVE]);
        }
        if ($request->input('status') == User::STATUS_BLOCKED) {
            $merchant->update(['status' => User::STATUS_BLOCKED]);
        }

        return response()->json(['success' => 'Status Updated Successfully']);
    }

    public function merchants(Request $request): JsonResponse
    {
        $query = User::query()->with('shop')
            ->where('role', 'merchant')
            ->latest();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->input('search') . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('joining_date')) {
            $query->whereDate('created_at', $request->input('joining_date'));
        }
        $merchants = $query->paginate($this->limit());
        return response()->json($merchants);
    }

    public function statuses(): JsonResponse
    {
        $statuses = User::listStatus();

        return response()->json($statuses);
    }

    public function destroy(User $merchant)
    {
        $shop = Shop::query()->where('user_id', $merchant->id)->first();
        if($shop) {
            $shop->delete();
        }
        $merchant->delete();

        return response()->json('Merchant Deleted');
    }
}
