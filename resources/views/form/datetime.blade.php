<div class="form-group">
    <label for="{{ $name }}">{{ __($label) }}</label>
    <input type="datetime" name="{{ $name }}" value="{{ $value ?? '' }}" class="form-control" />
</div>
