@if (\App\Rules\Recaptcha::enabled())
    @once
        @push('scripts')
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
    @endonce
    <div>
        <div class="g-recaptcha" data-sitekey="{{ config('captcha.sitekey') }}"></div>
        @error('g-recaptcha-response') <p class="form-error">{{ $message }}</p> @enderror
    </div>
@else
    @error('g-recaptcha-response') <p class="form-error">{{ $message }}</p> @enderror
@endif
