{{-- One "result" stat. JS rewrites data-field into results[i][...] names. --}}
<div data-repeater-row class="bt-card" style="padding:16px;">
    @include('admin.projects._repeater_head')
    <div class="bt-result-cols" style="display:grid;grid-template-columns:170px 1fr;gap:12px;align-items:start;">
        <div>
            <span class="bt-label">{{ __('admin.projects.f.result_metric') }}</span>
            <input type="text" data-field="[metric]" value="{{ $metric ?? '' }}" dir="ltr" class="bt-input" placeholder="+212%">
        </div>
        <div>
            <span class="bt-label">{{ __('admin.projects.f.result_label') }}</span>
            <div class="bt-twocol" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <span style="font-size:10px;color:var(--faint);">{{ __('admin.editor.english') }}</span>
                    <input type="text" data-field="[label][en]" value="{{ $labelEn ?? '' }}" dir="ltr" class="bt-input">
                </div>
                <div>
                    <span style="font-size:10px;color:var(--faint);">{{ __('admin.editor.arabic') }}</span>
                    <input type="text" data-field="[label][ar]" value="{{ $labelAr ?? '' }}" dir="rtl" class="bt-input bt-ar">
                </div>
            </div>
        </div>
    </div>
</div>
