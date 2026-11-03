<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['category', 'client'])
            ->latest()
            ->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();

        return view('admin.projects.create', compact(
            'categories',
            'clients'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'digits:4'],
            'value_or_area' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('projects', 'public');
        }

        $validated['slug'] = $this->generateSlug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');

        Project::create($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        $categories = Category::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();

        return view('admin.projects.edit', compact(
            'project',
            'categories',
            'clients'
        ));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'digits:4'],
            'value_or_area' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::disk('public')->delete($project->cover_image);
            }

            $validated['cover_image'] = $request->file('cover_image')
                ->store('projects', 'public');
        }

        $validated['slug'] = $this->generateSlug(
            $validated['title'],
            $project->id
        );

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');

        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        if ($project->cover_image) {
            Storage::disk('public')->delete($project->cover_image);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }

    private function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Project::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }
}