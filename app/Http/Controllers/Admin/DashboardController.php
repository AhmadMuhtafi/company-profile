<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Document;
use App\Models\Message;
use App\Models\Project;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'clients' => Client::count(),
            'services' => Service::count(),
            'categories' => Category::count(),
            'documents' => Document::count(),
            'messages' => Message::count(),
            'unread_messages' => Message::where('is_read', false)->count(),
            'featured_projects' => Project::where('is_featured', true)->count(),
        ];

        $recentMessages = Message::latest()
            ->take(5)
            ->get();

        $recentProjects = Project::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentMessages',
            'recentProjects'
        ));
    }
}