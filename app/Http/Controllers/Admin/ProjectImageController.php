<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    public function index(Project $project)
    {
        $images = $project->images;

        return view('admin.projects.images.index', compact(
            'project',
            'images'
        ));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $lastOrder = $project->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('projects/gallery', 'public');

            $project->images()->create([
                'image_path' => $path,
                'sort_order' => $lastOrder + $index + 1,
            ]);
        }

        return back()->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function update(Request $request, ProjectImage $image)
    {
        $validated = $request->validate([
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $image->update($validated);

        return back()->with('success', 'Informasi foto berhasil diperbarui.');
    }

    public function destroy(ProjectImage $image)
    {
        Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}