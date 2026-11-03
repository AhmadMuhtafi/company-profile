<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->get();

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $filePath = $request->file('file')
            ->store('documents', 'public');

        Document::create([
            'title' => $validated['title'],
            'file_path' => $filePath,
        ]);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $document->title = $validated['title'];

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->file_path = $request->file('file')
                ->store('documents', 'public');
        }

        $document->save();

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}
