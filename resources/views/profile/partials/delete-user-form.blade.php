<section>
    <header>
        <h2 class="account-heading">{{ __('Delete Account') }}</h2>
        <p class="account-copy">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="account-form">
        @csrf
        @method('delete')

        <div class="form-group">
            <x-input-label for="password" value="{{ __('Password') }}" />
            <x-text-input id="password" name="password" type="password" placeholder="{{ __('Password') }}" />
            <x-input-error :messages="$errors->userDeletion->get('password')" />
        </div>

        <div class="account-actions">
            <x-danger-button>
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </form>
</section>
