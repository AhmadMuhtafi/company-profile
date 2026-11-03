<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'show_logo' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('clients', 'public');
        }

        $validated['show_logo'] = $request->boolean('show_logo');

        Client::create($validated);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'show_logo' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('logo')) {
            if ($client->logo) {
                Storage::disk('public')->delete($client->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('clients', 'public');
        }

        $validated['show_logo'] = $request->boolean('show_logo');

        $client->update($validated);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Data klien berhasil diperbarui.');
    }

    public function destroy(Client $client)
    {
        if ($client->logo) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Klien berhasil dihapus.');
    }
}