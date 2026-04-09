@extends('admin.layouts.admin')

@section('title', 'Articles - INSPIN Admin')
@section('page-title', 'Articles')
@section('breadcrumb')
    <span>Articles</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Articles</h2>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M12 4v16m8-8H4"/></svg>
            New Article
        </a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="search-bar">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search articles by title...">
            <button type="submit" class="btn btn-primary">Search</button>
            @if($search)<a href="{{ route('admin.articles.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Sport</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Premium</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                    <tr>
                        <td style="color:#94a3b8;">{{ $article->id }}</td>
                        <td>
                            <div style="font-weight:600;">{{ Str::limit($article->title, 50) }}</div>
                            <div style="font-size:12px;color:#94a3b8;">{{ $article->published_at?->format('M d, Y') ?? 'Draft' }}</div>
                        </td>
                        <td><span class="badge badge-{{ strtolower($article->sport ?? 'neutral') }}">{{ $article->sport ?? '-' }}</span></td>
                        <td><span class="badge badge-{{ $article->category }}">{{ ucfirst($article->category) }}</span></td>
                        <td>
                            @if($article->is_published)
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-neutral">Draft</span>
                            @endif
                        </td>
                        <td>
                            @if($article->is_premium)
                                <span class="badge badge-warning">Premium</span>
                            @else
                                <span class="badge badge-neutral">Free</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-ghost btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" style="display:inline;" onsubmit="return confirm('Delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                <h3>No articles yet</h3>
                                <p>Create your first article to get started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($articles->hasPages())
    <div class="card-footer">
        {{ $articles->links() }}
    </div>
    @endif
</div>
@endsection
