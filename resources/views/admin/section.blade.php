@extends('admin.layout')
@section('title', tr($section['label']))

@php
    $id = $section['id'];
    $hidden = ($section['hideable'] ?? false) && ! setting_raw("visibility.$id", true);
    $collection = $section['collection'] ?? null;
@endphp

@section('content')
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:8px;">
        <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3vw,30px);letter-spacing:-0.02em;margin:0;">{{ tr($section['label']) }}</h1>
        @if ($section['hideable'])
            <span style="font-size:11.5px;font-weight:700;padding:5px 11px;border-radius:99px;border:1px solid var(--border);{{ $hidden ? 'color:var(--faint);background:var(--panel2);' : 'color:var(--acc);background:rgba(var(--accRGB),0.12);' }}">
                {{ $hidden ? __('admin.editor.hidden_on_site') : __('admin.editor.show_on_site') }}
            </span>
        @endif
    </div>
    <p style="color:var(--muted);font-size:14px;margin:0 0 6px;line-height:1.6;">{{ tr($section['desc']) }}</p>
    <p style="color:var(--faint);font-size:12.5px;margin:0 0 18px;">{{ __('admin.editor.affects') }}</p>

    @include('admin.partials.preview', ['section' => $section, 'settingValues' => $settingValues, 'rows' => $rows])

    <form method="POST" action="{{ route('admin.section.update', $id) }}" data-editor-form>
        @csrf @method('PUT')

        {{-- ===== settings fields ===== --}}
        @if (! empty($section['settings']))
            <div class="bt-card" style="padding:22px;margin-bottom:18px;display:flex;flex-direction:column;gap:18px;">
                @foreach ($section['settings'] as [$key, $type, $label])
                    @php $val = $settingValues[$key] ?? null; @endphp
                    <div>
                        <span class="bt-label">{{ $label }}</span>
                        @if (in_array($type, ['text', 'area'], true))
                            <div class="bt-twocol" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                                <div>
                                    <span style="font-size:10px;color:var(--faint);">{{ __('admin.editor.english') }}</span>
                                    @if ($type === 'area')
                                        <textarea name="s[{{ $key }}][en]" data-preview="{{ $key }}" rows="3" class="bt-input">{{ is_array($val) ? ($val['en'] ?? '') : '' }}</textarea>
                                    @else
                                        <input type="text" name="s[{{ $key }}][en]" data-preview="{{ $key }}" value="{{ is_array($val) ? ($val['en'] ?? '') : '' }}" class="bt-input">
                                    @endif
                                </div>
                                <div>
                                    <span style="font-size:10px;color:var(--faint);">{{ __('admin.editor.arabic') }}</span>
                                    @if ($type === 'area')
                                        <textarea name="s[{{ $key }}][ar]" data-preview="{{ $key }}" rows="3" dir="rtl" class="bt-input bt-ar">{{ is_array($val) ? ($val['ar'] ?? '') : '' }}</textarea>
                                    @else
                                        <input type="text" name="s[{{ $key }}][ar]" data-preview="{{ $key }}" value="{{ is_array($val) ? ($val['ar'] ?? '') : '' }}" dir="rtl" class="bt-input bt-ar">
                                    @endif
                                </div>
                            </div>
                        @else
                            <input type="text" name="s[{{ $key }}]" value="{{ is_array($val) ? implode(', ', $val) : $val }}" class="bt-input" style="max-width:420px;">
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ===== collection rows ===== --}}
        @if ($collection)
            @php $dynamic = (bool) ($collection['dynamic'] ?? false); @endphp
            <div data-repeater="items">
                <div style="display:flex;align-items:center;justify-content:space-between;margin:6px 0 12px;">
                    <span class="bt-label" style="margin:0;">{{ $collection['label'] }}</span>
                </div>
                <div data-repeater-items style="display:flex;flex-direction:column;gap:14px;">
                    @foreach ($rows as $row)
                        @include('admin.partials.row', ['fields' => $collection['fields'], 'rowId' => $row['key'], 'values' => $row['values'], 'dynamic' => $dynamic])
                    @endforeach
                </div>

                @if ($dynamic)
                    <template data-repeater-template>
                        @include('admin.partials.row', ['fields' => $collection['fields'], 'rowId' => '', 'values' => [], 'dynamic' => true])
                    </template>
                    <button type="button" data-repeater-add style="margin-top:16px;width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:14px;border-radius:12px;background:var(--panel2);border:1px dashed var(--border2);color:var(--fg);font-size:14px;font-weight:600;cursor:pointer;">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        + {{ $collection['label'] }}
                    </button>
                @endif
            </div>
        @endif

        <div style="margin-top:22px;">
            <button type="submit" class="bt-btn">{{ __('admin.save') }}</button>
        </div>
    </form>
@endsection
