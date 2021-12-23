<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <form class="card card-md" method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Login to your account</h2>
          <div class="mb-3">
            <x-label for="email" class="form-label" :value="__('Email')" />
            <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
          </div>
          <div class="mb-2">
            <x-label for="password" class="form-label" :value="__('Password')" />
            <div class="input-group input-group-flat">
                <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
              <span class="input-group-text">
                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                </a>
              </span>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <span class="form-check-label">{{ __('Remember me') }}</span>
            </label>
          </div>
          <div class="form-footer">
            <x-button class="btn btn-primary w-100">
                {{ __('Log in') }}
            </x-button>
          </div>
        </div>
        <div class="hr-text">ou</div>
        <div class="card-body">
          <div class="row">
            <div class="col"><a href="#" class="btn btn-white w-100">
                <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-google" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M17.788 5.108a9 9 0 1 0 3.212 6.892h-8"></path>
                 </svg>
                Login Google
              </a>
            </div>
          </div>
        </div>
      </form>
      <div class="text-center text-muted mt-3">
        @if (Route::has('password.request'))
            <a class="" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
    </div>
</x-guest-layout>