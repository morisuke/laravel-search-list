<div class="form-group">
    <label for="{{ $name }}">{{ __($label) }}</label>
    <select class="form-control" name="{{ $name }}">
    @foreach ($options as $val => $label)

        <option value="{{ $val }}" @if ($val == $value) selected @endif>{{ $label }}</option>

    @endforeach
    </select>
</div>
