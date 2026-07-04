@extends('layouts.manage')
@section('title', 'Remarketing Schedules')

@push('css-links')
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
<h3>Remarketing Schedules (Weight loss Program)</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('manage.remarketing.schedule.index') }}">Remarketing Schedules</a></li>
<li class="breadcrumb-item active">Set Schedules</li>
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

                    <form method="POST" id="whatsappRemarketingForm" action="{{ route('manage.remarketing.schedule.store') }}">
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <input type="hidden" name="product_id" value="1">                    

                        <div id="whatsappScheduleWrapper"></div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('manage.remarketing.schedule.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                                <button type="submit" id="whatsappSaveBtn" class="btn btn-outline-primary">Save</button>
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
                    <form method="POST" id="RemarketingScheduleForm" action="{{ route('manage.remarketing.schedule.store') }}">
                        @csrf
                        <input type="hidden" name="type" value="2">
                        <input type="hidden" name="product_id" value="1">

                        <div id="smsScheduleWrapper"></div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('manage.remarketing.schedule.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                                <button type="submit" id="smsSaveBtn" class="btn btn-outline-primary">Save</button>
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
<script>
    const allErrors = @json($errors->toArray());
    const oldType = @json(old('type', null));
    // Only attach error bag to the form that was submitted (old('type'))
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

    function addRow(wrapper, rowIndex, type, day = '', time = '', errors = {}) {
        const currentIndex = rowIndex;
        const dayError = getError(errors, currentIndex, 'day');
        const timeError = getError(errors, currentIndex, 'time');

        const div = document.createElement('div');
        div.classList.add('schedule-row');

        div.innerHTML = `
            <div class="row g-3 mb-3 align-items-start">
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

                <div class="col-md-4 text-end">
                    <span class="btn btn-outline-danger deleteRow" role="button">
                        <i class="fa fa-trash"></i>
                    </span>
                </div>
            </div>`;

        wrapper.appendChild(div);

        div.querySelector('.deleteRow').addEventListener('click', function () {
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

    document.getElementById('addMoreWhatsapp').addEventListener('click', function () {
        addRow(whatsappWrapper, whatsappRowIndex, 1, '', '', whatsappErrors);
        whatsappRowIndex++;
    });

    document.getElementById('addMoreSms').addEventListener('click', function () {
        addRow(smsWrapper, smsRowIndex, 2, '', '', smsErrors);
        smsRowIndex++;
    });

    const whatsappOldSchedules = @json(old('type') == '1' ? old('schedules', []) : []);
    const smsOldSchedules = @json(old('type') == '2' ? old('schedules', []) : []);

    if (whatsappOldSchedules.length) {
        whatsappOldSchedules.forEach((schedule) => {
            addRow(whatsappWrapper, whatsappRowIndex, 1, schedule.day ?? '', schedule.time ?? '', whatsappErrors);
            whatsappRowIndex++;
        });
    } else {
        addRow(whatsappWrapper, whatsappRowIndex, 1, '', '', whatsappErrors);
        whatsappRowIndex++;
    }

    if (smsOldSchedules.length) {
        smsOldSchedules.forEach((schedule) => {
            addRow(smsWrapper, smsRowIndex, 2, schedule.day ?? '', schedule.time ?? '', smsErrors);
            smsRowIndex++;
        });
    } else {
        addRow(smsWrapper, smsRowIndex, 2, '', '', smsErrors);
        smsRowIndex++;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const forms = [document.getElementById('whatsappRemarketingForm'), document.getElementById('RemarketingScheduleForm')];

        forms.forEach(function (form) {
            if (!form) {
                return;
            }

            const button = form.querySelector('button[type="submit"]');
            form.addEventListener('submit', function () {
                if (button) {
                    button.disabled = true;
                    button.innerHTML = 'Saving <i class="fa fa-spinner fa-spin"></i>';
                }
            });
        });
    });
</script>
@endpush
