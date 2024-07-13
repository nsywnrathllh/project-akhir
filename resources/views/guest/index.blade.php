@extends('layouts.template-mazer')
@section('content')
    <div class="page-heading">
        <h3>Data Tamu</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="ml-2">
                    <div id="rangeDateFilter" class="btn btn-primary" style="cursor: pointer;">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-chevron-down"></i>
                    </div>
                </div>
                <table class="table responsive" id="table1">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">QR</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nomor Telepon</th>
                            <th scope="col">Asal</th>
                            <th scope="col">Tujuan Destinasi</th>
                            <th scope="col">Tujuan Berkunjung</th>
                            <th scope="col">Kendaraan</th>
                            <th scope="col">Jenis Kendaraan</th>
                            <th scope="col">Plat Nomor</th>
                            <th scope="col">Jam Masuk</th>
                            <th scope="col">Jam Keluar</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Status</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guest as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><img src="{{ (new \chillerlan\QRCode\QRCode())->render(json_encode($item->id ?? null)) }}"
                                        alt="QR" style="width: 100px; height: 100px;">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->alliance }}</td>
                                <td>{{ $item->destination }}</td>
                                <td>{{ $item->purpose }}</td>
                                <td>{{ $item->has_vehicle }}</td>
                                <td>
                                    @foreach ($item->vehicles as $vehicle)
                                        {{ $vehicle->type }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->vehicles as $vehicle)
                                        {{ $vehicle->license_plate }}
                                    @endforeach
                                </td>
                                <td>{{ $item->checkin }}</td>
                                <td>{{ $item->checkout }}</td>
                                <td>
                                    @if ($item->image_path)
                                        <img src="{{ asset($item->image_path) }}"
                                            style="max-width: 100px; max-height: 100px;" alt="Guest Image">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->scan }}</td>
                                <td>
                                    <div class="d-flex">
                                        @if ($item->status == 'Still Inside')
                                            <a href="{{ route('guest.scan', $item->id) }}" class="btn btn-info me-2"><i
                                                    class="bi bi-camera"></i></a>
                                        @else
                                            <button class="btn btn-secondary me-2" disabled><i
                                                    class="bi bi-camera"></i></button>
                                        @endif
                                        <form action="{{ route('guests.destroy', $item->id) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/table-datatable.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@push('js')
    <script src="{{ asset('mazer/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('mazer/assets/static/js/pages/simple-datatables.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {
            let dateRangeSelected = false;

            function cb(start, end) {
                let selectedRange = start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY');
                $('#rangeDateFilter span').html(selectedRange);
                let params = new URLSearchParams();

                let currentUrlParams = new URLSearchParams(window.location.search);
                if (currentUrlParams.has('branch')) {
                    params.append('branch', currentUrlParams.get('branch'));
                }

                if (start && end) {
                    params.append('start', start.format('YYYY-MM-DD'));
                    params.append('end', end.format('YYYY-MM-DD'));
                }

                let urlParams = params.toString();

                let baseUrl = window.location.origin + window.location.pathname;
                let newUrl = baseUrl;
                if (urlParams) {
                    newUrl += '?' + urlParams;
                }

                if (!dateRangeSelected) {
                    dateRangeSelected = true;
                } else {
                    window.location.href = newUrl;
                }
            }

            let currentUrlParams = new URLSearchParams(window.location.search);
            let startDateParam = currentUrlParams.get('start');
            let endDateParam = currentUrlParams.get('end');
            let startDate = startDateParam ? moment(startDateParam) : moment();
            let endDate = endDateParam ? moment(endDateParam) : moment();

            $('#rangeDateFilter').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(startDate, endDate);

            let isValidDateRange = startDate.isValid() && endDate.isValid();
            if (!dateRangeSelected && isValidDateRange) {
                let baseUrl = window.location.origin + window.location.pathname;
                let newUrl = baseUrl;
                if (startDate && endDate) {
                    let params = new URLSearchParams(window.location.search);
                    params.set('start', startDate.format('YYYY-MM-DD'));
                    params.set('end', endDate.format('YYYY-MM-DD'));
                    newUrl += '?' + params.toString();
                }
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
@endpush
