<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index(): View
    {
        return view('admin.subscribers.index', [
            'subscribers' => Subscriber::latest()->paginate(30),
        ]);
    }

    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')->with('status', 'Subscriber removed.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'subscribers-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () {
            try {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['email', 'locale', 'subscribed_at']);
                Subscriber::orderBy('email')->chunk(200, function ($rows) use ($out) {
                    foreach ($rows as $row) {
                        fputcsv($out, [$row->email, $row->locale, $row->created_at]);
                    }
                });
                fclose($out);
            } catch (\Throwable $e) {
                Log::error('[subscribers] CSV export failed mid-stream.', ['exception' => $e]);
            }
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
