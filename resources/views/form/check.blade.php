<div class="form-group">
<label>{{ __($name) }}</label>
    @foreach ($options as $val => $label)
    <div>
        <label>
            <input type="checkbox" name="{{ $name }}[]" value="{{ $val }}" @if (in_array($val, $value ?? [])) checked @endif>
            {{ __($label) }}
        </label>
    </div>
    @endforeach
</div>
