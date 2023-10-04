<div class="page-section">
    @isset ($icon)
        <div class="page-section__icon">
            @if ($icon === 'graph')
                <svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M11,2V22C5.9,21.5 2,17.2 2,12C2,6.8 5.9,2.5 11,2M13,2V11H22C21.5,6.2 17.8,2.5 13,2M13,13V22C17.7,21.5 21.5,17.8 22,13H13Z"></path>
                </svg>
            @endif
        </div>
    @endisset

    <h2 class="page-section__title">{{ $title }}</h2>
</div>
