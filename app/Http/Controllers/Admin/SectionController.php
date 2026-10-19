<?php

namespace App\Http\Controllers\Admin;

use App\Cms\ContentWriter;
use App\Cms\Registry;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Dashboard untuk semua halaman konten tunggal.
 * Menggantikan ±30 controller lama yang isinya hampir identik.
 */
class SectionController extends Controller
{
    public function show(string $section): View
    {
        $section = Registry::section($section);

        return view('admin.sections.show', [
            'section' => $section,
            'record' => $section->record(),
            'children' => collect($section->children)->map(fn ($key) => Registry::sections()[$key] ?? Registry::collections()[$key] ?? null)->filter(),
        ]);
    }

    public function edit(string $section): View
    {
        $section = Registry::section($section);

        return view('admin.sections.edit', [
            'section' => $section,
            'record' => $section->record(),
        ]);
    }

    public function update(Request $request, string $section, ContentWriter $writer): RedirectResponse
    {
        $section = Registry::section($section);
        $writer->save($section->record(), $section->fields, $request);

        return redirect()->route('admin.sections.show', $section->key)
            ->with('success', "{$section->label} berhasil diperbarui.");
    }
}
