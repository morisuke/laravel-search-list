<div class="form-group">
    <label for="{{ $name }}">{{ __($label) }}</label>
    <div class="form-group row">
        <div class="col-md-6">
            <input type="datetime" name="{{ $name }}[before]" value="{{ $value['before'] ?? '' }}" class="form-control" />
        </div>
        <div class="col-md-6">
            <input type="datetime" name="{{ $name }}[after]" value="{{ $value['after'] ?? '' }}" class="form-control" />
        </div>
    </div>
</div>
