@extends('admin.layouts.admin')
@section('title', ($article->exists ? 'Edit Article' : 'New Article') . ' - INSPIN Admin')
@section('page-title', $article->exists ? 'Edit Article' : 'New Article')

@section('content')
<div style="max-width:900px;">
    <form method="POST"
          action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($article->exists) @method('PUT') @endif

        {{-- ✨ AI Article Generator --}}
        <div class="card" style="margin-bottom:20px;border:2px solid #7c3aed22;background:linear-gradient(135deg,#faf5ff,#fff);">
            <div class="card-header" style="background:linear-gradient(135deg,#7c3aed08,transparent);">
                <h2 style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:16px;">✨</span> AI Article Generator
                </h2>
                <span style="font-size:12px;color:#94a3b8;">Claude writes a full article — title, excerpt & content</span>
            </div>
            <div class="card-body">
                <div class="form-grid-3" style="margin-bottom:14px;">
                    <div class="form-group">
                        <label>Sport</label>
                        <select id="ai_sport" class="form-control">
                            <option value="">— Select —</option>
                            @foreach(['NFL','NCAAF','NBA','NCAAB','MLB','NHL'] as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Teams / Matchup</label>
                        <input type="text" id="ai_teams" class="form-control" placeholder="e.g. Lakers vs Celtics">
                    </div>
                    <div class="form-group">
                        <label>Pick / Bet Type</label>
                        <input type="text" id="ai_pick" class="form-control" placeholder="e.g. Under 215.5 (-110)">
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                    <button type="button" onclick="generateArticle()" class="btn btn-primary" id="generateBtn" style="background:linear-gradient(135deg,#7c3aed,#6d28d9);">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Generate with Claude
                    </button>
                    <div id="aiGenerateStatus" style="display:none;font-size:13px;color:#7c3aed;"></div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Article Info</h2></div>
            <div class="card-body">
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Title <span class="required">*</span></label>
                    <input type="text" name="title" id="articleTitle" class="form-control" value="{{ old('title', $article->title) }}" placeholder="Article title">
                    @error('title')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grid-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label>Category <span class="required">*</span></label>
                        <input type="text" name="category" class="form-control" value="{{ old('category', $article->category) }}" placeholder="e.g. Analysis, News, Tips">
                        @error('category')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Sport</label>
                        <select name="sport" id="articleSport" class="form-control">
                            <option value="">— All Sports —</option>
                            @foreach(['NFL','NCAAF','NBA','NCAAB','MLB','NHL'] as $s)
                                <option value="{{ $s }}" {{ old('sport', $article->sport) === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $article->author) }}" placeholder="Author name">
                    </div>
                    <div class="form-group">
                        <label>Expert Name</label>
                        <input type="text" name="expert_name" id="articleExpert" class="form-control" value="{{ old('expert_name', $article->expert_name) }}" placeholder="Expert display name">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Excerpt <span style="color:#94a3b8;font-weight:400;font-size:12px;">(auto-generated by Claude if left blank)</span></label>
                    <textarea name="excerpt" id="articleExcerpt" class="form-control" rows="2" placeholder="Short summary shown in article cards…">{{ old('excerpt', $article->excerpt) }}</textarea>
                </div>
                <div class="form-group">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <label style="margin:0;">Content <span class="required">*</span></label>
                        <label style="display:inline-flex;align-items:center;gap:7px;cursor:pointer;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:8px;padding:6px 14px;font-size:13px;font-weight:600;color:#374151;transition:all 0.15s;" onmouseover="this.style.borderColor='#2563eb'" onmouseout="this.style.borderColor='#e2e8f0'">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:15px;height:15px;"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Import from PDF
                            <input type="file" id="pdfUpload" accept=".pdf" style="display:none;" onchange="importPdf(this.files[0])">
                        </label>
                    </div>
                    <div id="pdfStatus" style="display:none;font-size:13px;margin-bottom:6px;padding:8px 12px;border-radius:6px;border:1px solid;"></div>

                    {{-- Drop zone --}}
                    <div id="pdfDropZone" style="position:relative;">
                        <div id="pdfDropOverlay" style="display:none;position:absolute;inset:0;z-index:10;background:rgba(37,99,235,0.06);border:2px dashed #2563eb;border-radius:8px;flex-direction:column;align-items:center;justify-content:center;gap:8px;pointer-events:none;">
                            <svg fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24" style="width:32px;height:32px;"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span style="font-size:15px;font-weight:700;color:#2563eb;">Drop PDF to import</span>
                            <span style="font-size:12px;color:#64748b;">Claude will format the content automatically</span>
                        </div>
                        <textarea name="content" id="articleContent" class="form-control" rows="14" placeholder="Full article content… or drop a .pdf file here">{{ old('content', $article->content) }}</textarea>
                    </div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:4px;">Drag &amp; drop a .pdf directly onto the content box, or use "Import from PDF". Claude will reformat with proper headings, paragraphs, and tables.</div>
                    @error('content')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Related Pick</h2></div>
            <div class="card-body">
                <div class="form-group">
                    <label>Link a Pick to this Article</label>
                    <select name="related_pick_id" class="form-control">
                        <option value="">— No pick linked —</option>
                        @foreach($picks as $pick)
                        @php $linkedPickId = $article->exists ? optional($article->relatedPicks->first())->id : null; @endphp
                        <option value="{{ $pick->id }}" {{ old('related_pick_id', $linkedPickId) == $pick->id ? 'selected' : '' }}>
                            [{{ $pick->sport }}] {{ $pick->team1_name }} vs {{ $pick->team2_name }} — {{ $pick->game_date?->format('M d, Y') }} — {{ $pick->pick }}
                        </option>
                        @endforeach
                    </select>
                    <div style="font-size:12px;color:#94a3b8;margin-top:4px;">Only one pick will be shown on the article. Changing this will unlink the previous pick.</div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Featured Image & Publishing</h2></div>
            <div class="card-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Featured Image</label>
                        <input type="file" name="featured_image" class="form-control" accept="image/*" onchange="previewImg(this,'featuredPreview')">
                        <div style="font-size:12px;color:#94a3b8;margin-top:4px;">Recommended: 1200×675px · Max 2MB (JPG or PNG)</div>
                        @if($article->featured_image)
                            <img id="featuredPreview" src="{{ asset('storage/'.$article->featured_image) }}" style="margin-top:8px;max-width:200px;border-radius:8px;border:1px solid #e2e8f0;">
                        @else
                            <img id="featuredPreview" src="" style="margin-top:8px;max-width:200px;border-radius:8px;border:1px solid #e2e8f0;display:none;">
                        @endif
                        @error('featured_image')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label>Published At</label>
                            <input type="datetime-local" name="published_at" class="form-control"
                                   value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}">
                        </div>
                        <div style="display:flex;flex-direction:column;gap:12px;margin-top:8px;">
                            <label class="form-check">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                                Published (visible on site)
                            </label>
                            <label class="form-check">
                                <input type="checkbox" name="is_premium" value="1" {{ old('is_premium', $article->is_premium) ? 'checked' : '' }}>
                                Premium (members only)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                {{ $article->exists ? 'Update Article' : 'Create Article' }}
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>

    {{-- ── NotebookLM Supplemental Content (only shown when editing existing article) ── --}}
    @if($article->exists)
    <div class="card" style="margin-top:28px;">
        <div class="card-header">
            <h2>📚 Supplemental Content <span style="font-size:13px;color:#64748b;font-weight:400;">(NotebookLM / Right Sidebar)</span></h2>
        </div>
        <div class="card-body">
            <p style="color:#64748b;font-size:13px;margin-bottom:20px;">Add NotebookLM-generated content here. Each item appears stacked in the right sidebar on the article page. Note: NotebookLM has no public API — paste embed codes or URLs manually.</p>

            {{-- Existing supplements --}}
            @if($article->supplements->count() > 0)
            <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
                <thead>
                    <tr style="background:#f8fafc;border-bottom:2px solid #e2e8f0;">
                        <th style="padding:10px 12px;text-align:left;font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;">Type</th>
                        <th style="padding:10px 12px;text-align:left;font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;">Title</th>
                        <th style="padding:10px 12px;text-align:left;font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;">Order</th>
                        <th style="padding:10px 12px;text-align:left;font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($article->supplements as $sup)
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:10px 12px;font-size:13px;">{{ $sup->type_icon }} {{ ucfirst($sup->type) }}</td>
                        <td style="padding:10px 12px;font-size:13px;color:#374151;">{{ $sup->title ?: '—' }}</td>
                        <td style="padding:10px 12px;font-size:13px;color:#64748b;">{{ $sup->sort_order }}</td>
                        <td style="padding:10px 12px;">
                            <form method="POST" action="{{ route('admin.articles.supplements.destroy', [$article, $sup]) }}" onsubmit="return confirm('Remove this supplement?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:#fee2e2;color:#dc2626;border:none;border-radius:6px;padding:4px 12px;font-size:12px;font-weight:600;cursor:pointer;">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="color:#94a3b8;font-size:13px;margin-bottom:20px;">No supplemental content yet. Add items below.</p>
            @endif

            {{-- Add new supplement --}}
            <form method="POST" action="{{ route('admin.articles.supplements.store', $article) }}" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:20px;">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 2fr auto auto;gap:12px;align-items:end;flex-wrap:wrap;">
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Type</label>
                        <select name="type" class="form-control" style="font-size:13px;">
                            <option value="video">📺 Video Show</option>
                            <option value="debate">💬 Debate</option>
                            <option value="infographic">📊 Infographic</option>
                            <option value="flashcard">🃏 Flashcards</option>
                            <option value="audio">🎧 Audio</option>
                            <option value="other">📎 Other</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Title (optional)</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Game Preview Video" style="font-size:13px;">
                    </div>
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ $article->supplements->count() }}" style="font-size:13px;width:70px;">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" style="white-space:nowrap;">+ Add</button>
                    </div>
                </div>
                <div style="margin-top:12px;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Embed Code <span style="font-weight:400;color:#64748b;">(paste iframe or script from NotebookLM)</span></label>
                    <textarea name="embed_code" class="form-control" rows="3" placeholder='e.g. <iframe src="..." ...></iframe>' style="font-size:13px;font-family:monospace;"></textarea>
                </div>
                <div style="margin-top:10px;">
                    <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Or External URL <span style="font-weight:400;color:#64748b;">(link to content)</span></label>
                    <input type="url" name="external_url" class="form-control" placeholder="https://..." style="font-size:13px;">
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
let ckEditor = null;

// ── CKEditor init ────────────────────────────────────────────
ClassicEditor.create(document.getElementById('articleContent'), {
    toolbar: ['heading','|','bold','italic','underline','|','bulletedList','numberedList','|','blockQuote','link','|','undo','redo'],
    heading: { options: [
        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
    ]}
}).then(editor => { ckEditor = editor; }).catch(console.error);

function setEditorContent(html) {
    if (ckEditor) ckEditor.setData(html);
    else document.getElementById('articleContent').value = html;
}

// ── Shared status helper ─────────────────────────────────────
function showStatus(elId, msg, type) {
    const el = document.getElementById(elId);
    el.style.display = 'block';
    el.textContent = msg;
    const colors = {
        info:    { bg:'#eff6ff', color:'#2563eb', border:'#bfdbfe' },
        success: { bg:'#f0fdf4', color:'#16a34a', border:'#bbf7d0' },
        error:   { bg:'#fef2f2', color:'#dc2626', border:'#fecaca' },
        loading: { bg:'#faf5ff', color:'#7c3aed', border:'#ddd6fe' },
    };
    const c = colors[type] || colors.info;
    el.style.background = c.bg; el.style.color = c.color; el.style.borderColor = c.border;
}

// ── PDF Import ───────────────────────────────────────────────
function importPdf(file) {
    if (!file) return;
    showStatus('pdfStatus', '⏳ Uploading and formatting PDF with Claude…', 'loading');

    const formData = new FormData();
    formData.append('pdf', file);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route('admin.ai.parse-pdf') }}', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
            if (data.error) {
                showStatus('pdfStatus', '✗ ' + data.error, 'error');
            } else {
                setEditorContent(data.html);
                showStatus('pdfStatus', '✓ PDF imported and formatted by Claude. Review the content below.', 'success');
            }
            document.getElementById('pdfUpload').value = '';
        })
        .catch(() => showStatus('pdfStatus', '✗ Upload failed. Please try again.', 'error'));
}

// ── Drag & Drop on content area ──────────────────────────────
const dropZone = document.getElementById('pdfDropZone');
const dropOverlay = document.getElementById('pdfDropOverlay');
let dragCounter = 0;

dropZone.addEventListener('dragenter', e => {
    e.preventDefault();
    if ([...e.dataTransfer.items].some(i => i.type === 'application/pdf')) {
        dragCounter++;
        dropOverlay.style.display = 'flex';
    }
});
dropZone.addEventListener('dragleave', () => {
    dragCounter--;
    if (dragCounter <= 0) { dragCounter = 0; dropOverlay.style.display = 'none'; }
});
dropZone.addEventListener('dragover', e => e.preventDefault());
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dragCounter = 0;
    dropOverlay.style.display = 'none';
    const file = [...e.dataTransfer.files].find(f => f.type === 'application/pdf');
    if (file) importPdf(file);
});

// ── AI Article Generator ─────────────────────────────────────
function generateArticle() {
    const sport  = document.getElementById('ai_sport').value;
    const teams  = document.getElementById('ai_teams').value.trim();
    const pick   = document.getElementById('ai_pick').value.trim();
    const expert = document.querySelector('[name="expert_name"]')?.value.trim() || '';

    if (!sport || !teams || !pick) {
        alert('Please fill in Sport, Teams, and Pick Type before generating.');
        return;
    }

    const btn = document.getElementById('generateBtn');
    btn.disabled = true;
    btn.textContent = '⏳ Generating…';
    showStatus('aiGenerateStatus', 'Claude is writing your article…', 'loading');

    fetch('{{ route('admin.ai.generate-article') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ sport, teams, pick_type: pick, expert_name: expert }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.error) {
            showStatus('aiGenerateStatus', '✗ ' + data.error, 'error');
        } else {
            document.getElementById('articleTitle').value = data.title || '';
            if (data.excerpt) document.getElementById('articleExcerpt').value = data.excerpt;
            if (data.content) setEditorContent(data.content);
            // Auto-select sport in article form
            if (sport) document.getElementById('articleSport').value = sport;
            showStatus('aiGenerateStatus', '✓ Article generated! Review and edit before saving.', 'success');
        }
    })
    .catch(() => showStatus('aiGenerateStatus', '✗ Generation failed. Please try again.', 'error'))
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Generate with Claude';
    });
}

// ── Image preview ─────────────────────────────────────────────
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
