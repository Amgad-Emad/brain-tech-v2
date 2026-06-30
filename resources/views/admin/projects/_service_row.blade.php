{{-- One "service used" tag. JS rewrites data-field into services[i][...] names. --}}
<div data-repeater-row class="bt-card" style="padding:16px;">
    @include('admin.projects._repeater_head')
    <div class="bt-twocol" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
            <span style="font-size:10px;color:var(--faint);">{{ __('admin.editor.english') }}</span>
            <input type="text" data-field="[en]" value="{{ $en ?? '' }}" dir="ltr" class="bt-input">
        </div>
        <div>
            <span style="font-size:10px;color:var(--faint);">{{ __('admin.editor.arabic') }}</span>
            <input type="text" data-field="[ar]" value="{{ $ar ?? '' }}" dir="rtl" class="bt-input bt-ar">
        </div>
    </div>
</div>
