<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Document;
use App\Models\Message;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        return view('home', [
            'services' => Service::orderBy('sort_order')->take(6)->get(),
            'featuredProjects' => Project::with('category')
                ->where('is_published', true)
                ->where('is_featured', true)
                ->orderByDesc('year')
                ->take(6)
                ->get(),
            'clients' => Client::whereNotNull('logo')->orderBy('name')->get(),
        ]);
    }

    public function about()
    {
        return view('about', [
            'documents' => Document::latest()->get(),
        ]);
    }

    public function services()
    {
        return view('services', [
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }

    public function portfolio(Request $request)
    {
        $activeCategory = $request->query('kategori');

        $projects = Project::with('category')
            ->where('is_published', true)
            ->when($activeCategory, fn ($q) => $q->whereHas(
                'category', fn ($c) => $c->where('slug', $activeCategory)
            ))
            ->orderByDesc('year')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('portfolio.index', [
            'projects' => $projects,
            'categories' => Category::orderBy('name')->get(),
            'activeCategory' => $activeCategory,
            'clients' => Client::whereNotNull('logo')->orderBy('name')->get(),
        ]);
    }

    public function project(string $slug)
    {
        $project = Project::with([
                'category',
                'client',
                'images' => fn ($q) => $q->orderBy('sort_order'),
            ])
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Project::with('category')
            ->where('is_published', true)
            ->where('id', '!=', $project->id)
            ->when($project->category_id, fn ($q) => $q->where('category_id', $project->category_id))
            ->latest('year')
            ->take(3)
            ->get();

        return view('portfolio.show', compact('project', 'related'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendMessage(Request $request)
    {
        // Kolom jebakan: manusia tidak melihatnya, bot biasanya mengisinya.
        if ($request->filled('website')) {
            return back();
        }

        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'phone_email' => 'required|string|max:150',
            'company'     => 'nullable|string|max:150',
            'message'     => 'required|string|min:10|max:3000',
        ], [
            'name.required'        => 'Nama wajib diisi.',
            'phone_email.required' => 'Telepon atau email wajib diisi.',
            'message.required'     => 'Tulis kebutuhan Anda terlebih dahulu.',
            'message.min'          => 'Pesan terlalu singkat. Tulis minimal 10 karakter.',
        ]);

        Message::create($data + ['is_read' => false]);

        // Opsional: kirim notifikasi email ke admin.
        // \Mail::to(config('mail.from.address'))->send(new \App\Mail\NewMessage($data));

        return back()->with('success', 'Terima kasih, pesan Anda sudah kami terima. Kami akan menghubungi Anda dalam satu hari kerja.');
    }
}
