<div class="form-group">
<label>{{ __($name) }}</label>
    @foreach ($options as $val => $label)
    <div>
        <label>
            <input type="radio" name="{{ $name }}" value="{{ $val }}" @if ($val == $value) checked @endif>
            {{ __($label) }}
        </label>
    </div>
    @endforeach
</div>
