<div class="form-group">
    <label for="{{ $name }}">{{ __($label) }}</label>
    <input type="date" name="{{ $name }}" value="{{ $value ?? '' }}" class="form-control" />
</div>
