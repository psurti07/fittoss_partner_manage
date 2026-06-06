<label class="form-label" for="event_id">Event</label>
<select class="form-control" id="event_id" name="event_id">
    <option value="">All</option>
    @foreach($events as $event)
    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
        {{ $event->title }}
    </option>
    @endforeach
</select>
