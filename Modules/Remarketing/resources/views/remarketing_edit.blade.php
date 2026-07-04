@extends('layouts.manage')
@section('title', 'Remarketing Schedules')

@push('css-links')
@include('stacks.css.manage.datatables')
@endpush
@push('style-css')
<style>
    .invalid-feedback {
        display: block;
    }

    .schedule-row {
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('breadcrumb-title')
<h3>Remarketing Schedules ({{ $product->product_title }})</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.remarketing.schedule.index') }}">Remarketing Schedules</a></li>
<li class="breadcrumb-item active">Edit Times</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">Whatsapp</h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-outline-info" id="addMoreWhatsapp">
                                <i class="fa fa-plus-square"></i>
                            </button>
                        </div>
                    </div>
                    <hr/>

                    <form method="POST" id="whatsappRemarketingUpdateForm" action="{{ route('manage.remarketing.schedule.update') }}">
                        @csrf
                        <input type="hidden" name="deleted_ids" id="whatsappDeletedIds" value="">
                        <input type="hidden" name="type" value="1">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-md-4"><p class="mb-0"><strong>Day</strong></p></div>
                            <div class="col-md-4"><p class="mb-0"><strong>Time</strong></p></div>
                            <div class="col-md-4"><p class="mb-0"><strong>Action</strong></p></div>
                        </div>

                        <div id="whatsappScheduleWrapper"></div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('manage.remarketing.schedule.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" id="whatsappUpdateBtn" class="btn btn-outline-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">SMS</h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-outline-info" id="addMoreSms">
                                <i class="fa fa-plus-square"></i>
                            </button>
                        </div>
                    </div>
                    <hr/>

                    <form method="POST" id="RemarketingScheduleUpdateForm" action="{{ route('manage.remarketing.schedule.update') }}">
                        @csrf
                        <input type="hidden" name="deleted_ids" id="smsDeletedIds" value="">
                        <input type="hidden" name="type" value="2">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row g-3 mb-2 align-items-center">
                            <div class="col-md-4"><p class="mb-0"><strong>Day</strong></p></div>
                            <div class="col-md-4"><p class="mb-0"><strong>Time</strong></p></div>
                            <div class="col-md-4"><p class="mb-0"><strong>Action</strong></p></div>
                        </div>

                        <div id="smsScheduleWrapper"></div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('manage.remarketing.schedule.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" id="smsUpdateBtn" class="btn btn-outline-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-src')
@endpush
@push('script-tag')
@if(Session::has('success'))
<script>
    toastr.success('{{Session::get('success')}}')
</script>
@endif
@if(session('error'))
<script>
    toastr.error('{{Session::get('error')}}')
</script>
@endif
<script>
    @php
        $errorBag = $errors ?? new \Illuminate\Support\ViewErrorBag();

        $formatSchedule = function ($schedule) {
            return [
                'id' => $schedule->id ?? null,
                'day' => (string) ($schedule->day ?? ''),
                'time' => $schedule->time ? \Carbon\Carbon::parse($schedule->time)->format('H:i') : '',
                'is_active' => (string) ($schedule->is_active ?? '1'),
            ];
        };

        $submittedType = old('type');

        $whatsappInitialSchedules = ($submittedType == '1' || $submittedType == 1)
            ? old('schedules', [])
            : ($whatsappSchedules ?? collect())->map($formatSchedule)->values()->all();

        $smsInitialSchedules = ($submittedType == '2' || $submittedType == 2)
            ? old('schedules', [])
            : ($smsSchedules ?? collect())->map($formatSchedule)->values()->all();
    @endphp

    const whatsappInitialSchedules = @json($whatsappInitialSchedules);
    const smsInitialSchedules = @json($smsInitialSchedules);
    const allErrors = @json($errorBag->toArray());
    const oldType = @json(old('type', null));
    const whatsappErrors = (oldType == 1 || oldType == '1') ? allErrors : {};
    const smsErrors = (oldType == 2 || oldType == '2') ? allErrors : {};
    const whatsappWrapper = document.getElementById('whatsappScheduleWrapper');
    const smsWrapper = document.getElementById('smsScheduleWrapper');

    let whatsappRowIndex = 0;
    let smsRowIndex = 0;

    function getError(errors, index, field) {
        const key = `schedules.${index}.${field}`;
        return errors[key] ? errors[key][0] : '';
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function addRow(wrapper, rowIndex, errors, day = '', time = '', isActive = '1', id = null, deletedInputId = null) {
        const currentIndex = rowIndex;
        const dayError = getError(errors, currentIndex, 'day');
        const timeError = getError(errors, currentIndex, 'time');

        const div = document.createElement('div');
        div.classList.add('schedule-row');

        div.innerHTML = `
            <div class="row g-3 mb-3 align-items-start">
                ${id ? `<input type="hidden" name="schedules[${currentIndex}][id]" value="${escapeHtml(id)}">` : ''}
                <div class="col-md-4">
                    <input
                        type="number"
                        class="form-control ${dayError ? 'is-invalid' : ''}"
                        name="schedules[${currentIndex}][day]"
                        placeholder="Day"
                        value="${escapeHtml(day)}"
                        min="0"
                        required
                    >
                    ${dayError ? `<div class="invalid-feedback d-block">${escapeHtml(dayError)}</div>` : ''}
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa fa-clock"></i>
                        </span>
                        <input
                            type="time"
                            class="form-control send_time ${timeError ? 'is-invalid' : ''}"
                            name="schedules[${currentIndex}][time]"
                            value="${escapeHtml(time)}"
                            required
                        >
                    </div>
                    ${timeError ? `<div class="invalid-feedback d-block">${escapeHtml(timeError)}</div>` : ''}
                </div>
                <div class="col-md-4 d-flex align-items-center gap-2">
                    <select class="form-control" name="schedules[${currentIndex}][is_active]">
                        <option value="1" ${isActive === '1' ? 'selected' : ''}>Active</option>
                        <option value="0" ${isActive === '0' ? 'selected' : ''}>Inactive</option>
                    </select>
                    <div class="text-end">
                        <span class="btn btn-outline-danger deleteRow" role="button">
                            <i class="fa fa-trash"></i>
                        </span>
                    </div>
                </div>
            </div>`;

        wrapper.appendChild(div);

        div.querySelector('.deleteRow').addEventListener('click', function () {
            if (id && deletedInputId) {
                const deletedIdsInput = document.getElementById(deletedInputId);
                const deletedIds = deletedIdsInput.value ? deletedIdsInput.value.split(',').filter(Boolean) : [];

                if (!deletedIds.includes(String(id))) {
                    deletedIds.push(String(id));
                    deletedIdsInput.value = deletedIds.join(',');
                }
            }
            div.remove();
        });

        flatpickr(div.querySelector('.send_time'), {
            enableTime: true,
            noCalendar: true,
            dateFormat: 'H:i',
            time_24hr: true,
            minuteIncrement: 15,
            allowInput: false
        });

        return currentIndex;
    }

    function initRows(wrapper, initialSchedules, errors, rowIndex, deletedInputId) {
        if (Array.isArray(initialSchedules) && initialSchedules.length) {
            initialSchedules.forEach((schedule) => {
                addRow(wrapper, rowIndex, errors, schedule.day ?? '', schedule.time ?? '', schedule.is_active ?? '1', schedule.id ?? null, deletedInputId);
                rowIndex++;
            });

            return rowIndex;
        }

        addRow(wrapper, rowIndex, errors, '', '', '1', null, deletedInputId);
        return rowIndex + 1;
    }

    document.getElementById('addMoreWhatsapp').addEventListener('click', function () {
        addRow(whatsappWrapper, whatsappRowIndex, whatsappErrors, '', '', '1', null, 'whatsappDeletedIds');
        whatsappRowIndex++;
    });

    document.getElementById('addMoreSms').addEventListener('click', function () {
        addRow(smsWrapper, smsRowIndex, smsErrors, '', '', '1', null, 'smsDeletedIds');
        smsRowIndex++;
    });

    whatsappRowIndex = initRows(whatsappWrapper, whatsappInitialSchedules, whatsappErrors, whatsappRowIndex, 'whatsappDeletedIds');
    smsRowIndex = initRows(smsWrapper, smsInitialSchedules, smsErrors, smsRowIndex, 'smsDeletedIds');

    document.addEventListener('DOMContentLoaded', function () {
        const forms = [document.getElementById('whatsappRemarketingUpdateForm'), document.getElementById('RemarketingScheduleUpdateForm')];

        forms.forEach(function (form) {
            if (!form) {
                return;
            }

            const button = form.querySelector('button[type="submit"]');
            form.addEventListener('submit', function () {
                if (button) {
                    button.disabled = true;
                    button.innerHTML = 'Updating <i class="fa fa-spinner fa-spin"></i>';
                }
            });
        });
    });
</script>
@endpush
