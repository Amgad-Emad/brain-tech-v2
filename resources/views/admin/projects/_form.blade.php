@php
    $featured = $project->getFirstMedia('featured_image');
    $gallery = $project->getMedia('gallery');
    $results = old('results', is_array($project->results) ? array_map(fn ($r) => [
        'metric' => $r['metric'] ?? '',
        'label' => ['en' => $r['label']['en'] ?? '', 'ar' => $r['label']['ar'] ?? ''],
    ], $project->results) : []);
    $services = old('services', is_array($project->services_used) ? array_map(fn ($s) => [
        'en' => $s['en'] ?? '', 'ar' => $s['ar'] ?? '',
    ], $project->services_used) : []);
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-editor-form>
    @csrf
    @if (($method ?? 'POST') === 'PUT')
        @method('PUT')
    @endif

    {{-- ===== Basics ===== --}}
    <div class="bt-card" style="padding:22px;margin-bottom:18px;display:flex;flex-direction:column;gap:18px;">
        <div style="font-weight:700;font-size:15px;">{{ __('admin.projects.s.basics') }}</div>

        @include('admin.projects._i18n', ['name' => 'name', 'label' => __('admin.projects.f.name'), 'value' => $project->name])

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;" class="bt-twocol">
            <div>
                <span class="bt-label">{{ __('admin.projects.f.slug') }}</span>
                <input type="text" name="slug" value="{{ old('slug', $project->slug) }}" dir="ltr" class="bt-input" placeholder="my-project">
                <span style="font-size:11px;color:var(--faint);display:block;margin-top:4px;">{{ __('admin.projects.f.slug_hint') }}</span>
            </div>
            <div>
                <span class="bt-label">{{ __('admin.projects.f.year') }}</span>
                <input type="text" name="year" value="{{ old('year', $project->year) }}" dir="ltr" class="bt-input" placeholder="2025">
            </div>
        </div>

        @include('admin.projects._i18n', ['name' => 'tag', 'label' => __('admin.projects.f.tag'), 'value' => $project->tag])

        <div style="display:grid;grid-template-columns:200px 1fr;gap:12px;" class="bt-twocol">
            <div>
                <span class="bt-label">{{ __('admin.projects.f.metric') }}</span>
                <input type="text" name="metric" value="{{ old('metric', $project->metric) }}" dir="ltr" class="bt-input" placeholder="+212%">
            </div>
            <div></div>
        </div>

        @include('admin.projects._i18n', ['name' => 'metric_label', 'label' => __('admin.projects.f.metric_label'), 'value' => $project->metric_label])

        <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
            <label style="display:inline-flex;align-items:center;gap:9px;cursor:pointer;">
                <input type="hidden" name="is_visible" value="0">
                <input type="checkbox" name="is_visible" value="1" @checked(old('is_visible', $project->id ? $project->is_visible : true)) style="width:16px;height:16px;accent-color:var(--acc);">
                <span style="font-size:13px;font-weight:600;">{{ __('admin.projects.f.visible') }}</span>
            </label>
            <div>
                <span class="bt-label" style="margin:0;">{{ __('admin.projects.f.sort_order') }}</span>
                <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}" min="0" class="bt-input" style="max-width:120px;">
            </div>
        </div>
    </div>

    {{-- ===== Images ===== --}}
    <div class="bt-card" style="padding:22px;margin-bottom:18px;display:flex;flex-direction:column;gap:20px;">
        <div style="font-weight:700;font-size:15px;">{{ __('admin.projects.s.images') }}</div>

        {{-- Featured image --}}
        <div>
            <span class="bt-label">{{ __('admin.projects.f.featured') }}</span>
            <div style="display:flex;align-items:flex-start;gap:16px;flex-wrap:wrap;">
                <div style="width:150px;height:100px;border-radius:12px;overflow:hidden;border:1px solid var(--border);flex:none;background:var(--panel2);background-image:url('{{ $project->imageUrl() }}');background-size:cover;background-position:center;"></div>
                <div style="flex:1;min-width:220px;display:flex;flex-direction:column;gap:10px;">
                    <input type="file" name="featured_image" accept="image/*" class="bt-input" style="padding:9px;">
                    <span style="font-size:11px;color:var(--faint);">{{ __('admin.projects.f.featured_hint') }}</span>
                    @if ($featured)
                        <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-size:12.5px;color:#ef6464;">
                            <input type="checkbox" name="remove_featured" value="1" style="width:15px;height:15px;accent-color:#ef6464;">
                            {{ __('admin.projects.f.remove_featured') }}
                        </label>
                    @endif
                </div>
            </div>
        </div>

        {{-- Gallery --}}
        <div>
            <span class="bt-label">{{ __('admin.projects.f.gallery') }}</span>
            @if ($gallery->isNotEmpty())
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:12px;margin-bottom:12px;">
                    @foreach ($gallery as $media)
                        <label style="position:relative;display:block;cursor:pointer;border-radius:11px;overflow:hidden;border:1px solid var(--border);aspect-ratio:4/3;background:var(--panel2);background-image:url('{{ $media->getUrl() }}');background-size:cover;background-position:center;">
                            <span style="position:absolute;inset:0;background:rgba(0,0,0,0.0);transition:background .15s;"></span>
                            <span style="position:absolute;top:6px;inset-inline-end:6px;display:inline-flex;align-items:center;gap:5px;background:rgba(10,10,15,0.78);color:#fff;font-size:11px;font-weight:600;padding:4px 8px;border-radius:8px;">
                                <input type="checkbox" name="remove_gallery[]" value="{{ $media->id }}" style="width:14px;height:14px;accent-color:#ef6464;">
                                {{ __('admin.projects.f.remove') }}
                            </span>
                        </label>
                    @endforeach
                </div>
            @endif
            <input type="file" name="gallery[]" accept="image/*" multiple class="bt-input" style="padding:9px;">
            <span style="font-size:11px;color:var(--faint);display:block;margin-top:6px;">{{ __('admin.projects.f.gallery_hint') }}</span>
        </div>

        {{-- Optional external image URL (legacy fallback) --}}
        <div>
            <span class="bt-label">{{ __('admin.projects.f.image_url') }}</span>
            <input type="text" name="image_path" value="{{ old('image_path', $project->image_path) }}" dir="ltr" class="bt-input" placeholder="https://…">
            <span style="font-size:11px;color:var(--faint);display:block;margin-top:4px;">{{ __('admin.projects.f.image_url_hint') }}</span>
        </div>
    </div>

    {{-- ===== Case study copy ===== --}}
    <div class="bt-card" style="padding:22px;margin-bottom:18px;display:flex;flex-direction:column;gap:18px;">
        <div style="font-weight:700;font-size:15px;">{{ __('admin.projects.s.case_study') }}</div>
        @include('admin.projects._i18n', ['name' => 'client', 'label' => __('admin.projects.f.client'), 'value' => $project->client])
        @include('admin.projects._i18n', ['name' => 'alt', 'label' => __('admin.projects.f.alt'), 'value' => $project->alt])
        @include('admin.projects._i18n', ['name' => 'summary', 'label' => __('admin.projects.f.summary'), 'value' => $project->summary, 'type' => 'area'])
        @include('admin.projects._i18n', ['name' => 'challenge', 'label' => __('admin.projects.f.challenge'), 'value' => $project->challenge, 'type' => 'area'])
        @include('admin.projects._i18n', ['name' => 'approach', 'label' => __('admin.projects.f.approach'), 'value' => $project->approach, 'type' => 'area'])
    </div>

    {{-- ===== Results (repeater) ===== --}}
    <div class="bt-card" style="padding:22px;margin-bottom:18px;">
        <div style="font-weight:700;font-size:15px;margin-bottom:4px;">{{ __('admin.projects.s.results') }}</div>
        <p style="color:var(--faint);font-size:12.5px;margin:0 0 14px;">{{ __('admin.projects.s.results_hint') }}</p>
        <div data-repeater="results">
            <div data-repeater-items style="display:flex;flex-direction:column;gap:12px;">
                @foreach ($results as $r)
                    @include('admin.projects._result_row', ['metric' => $r['metric'] ?? '', 'labelEn' => $r['label']['en'] ?? '', 'labelAr' => $r['label']['ar'] ?? ''])
                @endforeach
            </div>
            <template data-repeater-template>
                @include('admin.projects._result_row', ['metric' => '', 'labelEn' => '', 'labelAr' => ''])
            </template>
            <button type="button" data-repeater-add style="margin-top:14px;width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;border-radius:12px;background:var(--panel2);border:1px dashed var(--border2);color:var(--fg);font-size:14px;font-weight:600;cursor:pointer;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('admin.projects.s.add_result') }}
            </button>
        </div>
    </div>

    {{-- ===== Services used (repeater) ===== --}}
    <div class="bt-card" style="padding:22px;margin-bottom:18px;">
        <div style="font-weight:700;font-size:15px;margin-bottom:4px;">{{ __('admin.projects.s.services') }}</div>
        <p style="color:var(--faint);font-size:12.5px;margin:0 0 14px;">{{ __('admin.projects.s.services_hint') }}</p>
        <div data-repeater="services">
            <div data-repeater-items style="display:flex;flex-direction:column;gap:12px;">
                @foreach ($services as $s)
                    @include('admin.projects._service_row', ['en' => $s['en'] ?? '', 'ar' => $s['ar'] ?? ''])
                @endforeach
            </div>
            <template data-repeater-template>
                @include('admin.projects._service_row', ['en' => '', 'ar' => ''])
            </template>
            <button type="button" data-repeater-add style="margin-top:14px;width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;border-radius:12px;background:var(--panel2);border:1px dashed var(--border2);color:var(--fg);font-size:14px;font-weight:600;cursor:pointer;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('admin.projects.s.add_service') }}
            </button>
        </div>
    </div>

    <div style="display:flex;align-items:center;gap:12px;margin-top:22px;">
        <button type="submit" class="bt-btn">{{ __('admin.save') }}</button>
        <a href="{{ route('admin.projects.index') }}" class="bt-btn-ghost" style="height:42px;padding:0 18px;border-radius:11px;font-size:14px;font-weight:600;display:inline-flex;align-items:center;text-decoration:none;">{{ __('admin.projects.cancel') }}</a>
    </div>
</form>
