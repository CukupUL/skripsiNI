<div class="form-group">
  <label>{{ $label }}</label>
  <input type="{{ $type ?? 'text' }}" placeholder="{{ $placeholder ?? '' }}" name="{{ $name }}" class="form-control" value="{{ $value ?? '' }}">
  @error($name)
    <small class="text-danger">{{ $message }}</small>
  @enderror
</div>