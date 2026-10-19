@foreach (['success', 'error', 'info'] as $flashType)
    @if (session($flashType))
        <meta name="flash-{{ $flashType }}" content="{{ session($flashType) }}">
    @endif
@endforeach
