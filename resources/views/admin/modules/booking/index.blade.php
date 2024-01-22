@extends('admin.master')
@section('title', 'Admin - Booking')
@section('module', 'Booking')

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        td.off.disabled {
            background-color: rgba(247, 133, 133, 0.256) !important;
            color: rgba(0, 0, 0, 0.264) !important;
        }

        td.active.start-date.available {
            background-color: #164e63 !important;

        }

        td.active.end-date.in-range.available {
            background-color: #164e63 !important;

        }
    </style>
    @if ($error = Session::get('error'))
        <div class="col-span-12 alert alert-error mt-6 alert-block alert-dismissible show flex items-center mb-2 bg-red-200">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong class="ml-3">{{ $error }}</strong>
        </div>
    @endif
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="intro-y col-span-12 flex flex-col items-center justify-center my-2">
            <h2 class="text-3xl text-center font-bold">Create booking for</h2>
            <h3 class="text-xl text-center font-bold">{{ $user->name }}</h3>
            <h3 class="text-xl text-center font-bold">{{ $user->email }}</h3>
        </div>
        <div class="intro-x col-span-12">
            <form class="w-full flex flex-col gap-8" action="{{ route('admin.booking.create') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="text" hidden value="{{ $user->id }}" name="user_id">
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full">
                        <label class="form-label font-semibold">Yachts</label>
                        <select name="yacht_id" class="tom-select w-full">
                            <option value="">Please enter the yacht name</option>
                            @foreach ($yachts as $yacht)
                                <option value="{{ $yacht->id }}" {{ old('yacht') == $yacht->id ? 'selected' : '' }}>
                                    {{ $yacht->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full">
                        <label class="form-label font-semibold">Guests</label>
                        <select name="guests" id="guests" class="w-full">
                        </select>

                    </div>
                    <div class="w-full">
                        <label class="form-label font-semibold">Start date - End date</label>
                        <input type="text" name="dates" class="form-control w-full block mx-auto">
                    </div>
                </div>
                <div class="intro-x w-full flex gap-4 flex-col">
                    <div class="w-full">
                        <h4 class="font-semibold text-xl">Fee detail</h4>
                        <table class="w-1/2 tl:w-full mt-5">
                            <tbody class="flex flex-col gap-4">
                                <tr class="border-b font-bold w-full flex items-center justify-between">
                                    <td>Charter fee :</td>
                                    <td id="charter" class="font-bold"></td>
                                </tr>
                                <tr class="border-b font-bold w-full flex items-center justify-between">
                                    <td>Charter toal :</td>
                                    <td id="charter_total" class="font-bold">$</td>
                                    <td hidden class="font-bold"><input type="text" value="" name="charter"></td>
                                </tr>
                                <tr class="border-b font-bold w-full flex items-center justify-between">
                                    <td>Service fee :</td>
                                    <td id="service" class="font-bold">$</td>
                                    <td hidden class="font-bold"><input type="text" value="" name="service"></td>
                                </tr>
                                <tr class="border-b font-bold w-full flex items-center justify-between">
                                    <td>Tax fee :</td>
                                    <td id="tax" class="font-bold">$</td>
                                    <td hidden class="font-bold"><input type="text" value="" name="tax"></td>
                                </tr>
                                <tr class="border-b font-bold w-full flex items-center justify-between">
                                    <td>Insurance fee :</td>
                                    <td id="insurance" class="font-bold">$</td>
                                    <td hidden class="font-bold"><input type="text" value="" name="insurance"></td>
                                </tr>
                                <tr class="border-b font-bold w-full flex items-center justify-between">
                                    <td>Total :</td>
                                    <td id="total" class="font-bold">$</td>
                                    <td hidden class="font-bold"><input type="text" value="" name="total"></td>
                                </tr>
                                <tr class="border-b font-bold w-full flex items-center justify-between">
                                    <td>Deposit fee :</td>
                                    <td id="deposit" class="font-bold">$</td>
                                    <td hidden class="font-bold"><input type="text" value="" name="deposit"></td>
                                </tr>
                                <tr class="border-b font-bold w-full flex items-center justify-between">
                                    <td>Refund amount :</td>
                                    <td id="refund_amount" class="font-bold">$</td>
                                    <td hidden class="font-bold"><input type="text" value="" name="refund_amount">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="intro-x w-full flex items-center mt-3">
                    <div class="w-full">
                        <button type="submit" class="block w-full btn btn-primary shadow-md mr-2">
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"></script>
    <script>
        let disabledRanges = [];
        let quantityDays = 0;
        let charter = 0;
        let charterTotal = 0;
        let service = 0;
        let tax = 0;
        let insurance = 0;
        let total = 0;
        let deposit = 0;
        let refund_amount = 0;
        let guests = 0;
        let crew = 0;
        let count = 0;

        const calculatorFee = () => {
            charterTotal = parseFloat((charter * quantityDays).toFixed(2));
            service = parseFloat((charterTotal * 0.15).toFixed(2));
            tax = parseFloat(((charterTotal + service) * 0.07).toFixed(2));
            insurance = parseFloat((50 * guests * quantityDays).toFixed(2));
            total = parseFloat((charterTotal + service + tax + insurance).toFixed(2));
            deposit = parseFloat((total * 3).toFixed(2));
            refund_amount = parseFloat((total * 2).toFixed(2));

            $('#charter_total').html(`$${charterTotal}`);
            $('#service').html(`$${service}`);
            $('#tax').html(`$${tax}`);
            $('#insurance').html(`$${insurance}`);
            $('#total').html(`$${total}`);
            $('#deposit').html(`$${deposit}`);
            $('#refund_amount').html(`$${refund_amount}`);

            $('input[name="charter"]').val(charterTotal);
            $('input[name="service"]').val(service);
            $('input[name="tax"]').val(tax);
            $('input[name="insurance"]').val(insurance);
            $('input[name="total"]').val(total);
            $('input[name="deposit"]').val(deposit);
            $('input[name="refund_amount"]').val(refund_amount);

        }

        const getBookingDate = async (id) => {
            try {
                const response = await axios.post("{{ route('getBookingDate') }}", {
                    id
                })
                if (response?.data?.status) {
                    disabledRanges = response?.data?.bookingDates;
                    charter = response?.data?.price_per_day;
                    crew = response.data.crew;
                    $('#charter').html(`$${charter} / day`);
                    let xhtml = '';
                    for (let i = 1; i <= crew; i++) {
                        xhtml += `<option value="${i}">${i}</option>`;
                    }
                    $('#guests').html(xhtml);

                }
            } catch (error) {
                console.log(error)
            }
        };

        $(document).ready(function() {
            $('select[name="yacht_id"]').on('change', function() {
                const yachtId = $(this).val();
                getBookingDate(yachtId);
                guests = 0;
                charterTotal = 0;
                service = 0;
                tax = 0;
                insurance = 0;
                total = 0;
                deposit = 0;
                refund_amount = 0;
                guests = 0;

                $('#charter_total').html(`$${charterTotal}`);
                $('#service').html(`$${service}`);
                $('#tax').html(`$${tax}`);
                $('#insurance').html(`$${insurance}`);
                $('#total').html(`$${total}`);
                $('#deposit').html(`$${deposit}`);
                $('#refund_amount').html(`$${refund_amount}`);

                $('input[name="charter"]').val('');
                $('input[name="service"]').val('');
                $('input[name="tax"]').val('');
                $('input[name="insurance"]').val('');
                $('input[name="total"]').val('');
                $('input[name="deposit"]').val('');
                $('input[name="refund_amount"]').val('');
                if (count >= 1) {
                    $('input[name="dates"]').val('');
                }
                count++;
            });
            $('select[name="guests"]').on('change', function() {
                const val = $(this).val();
                guests = val;
                insurance = parseFloat((50 * guests * quantityDays).toFixed(2));
                insurance = parseFloat((50 * guests * quantityDays).toFixed(2));
                total = parseFloat((charterTotal + service + tax + insurance).toFixed(2));
                deposit = parseFloat((total * 3).toFixed(2));
                refund_amount = parseFloat((total * 2).toFixed(2));

                $('#insurance').html(`$${insurance}`);
                $('#total').html(`$${total}`);
                $('#deposit').html(`$${deposit}`);
                $('#refund_amount').html(`$${refund_amount}`);
                $('input[name="insurance"]').val(insurance);
                $('input[name="total"]').val(total);
                $('input[name="deposit"]').val(deposit);
                $('input[name="refund_amount"]').val(refund_amount);

            });
        });
        $('input[name="dates"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            minDate: new Date(),
            isInvalidDate: function(date) {
                return isDateInRanges(date, disabledRanges);
            }
        }).on('apply.daterangepicker', function(ev, picker) {
            const startDate = picker.startDate.format('YYYY-MM-DD');
            const endDate = picker.endDate.format('YYYY-MM-DD');
            quantityDays = getTotalDate(startDate, endDate) + 1;
            calculatorFee();
        });

        function isDateInRanges(date, ranges) {
            for (var i = 0; i < ranges.length; i++) {
                const range = ranges[i];
                const end = moment(range.endDate).add(2, 'days');
                if (moment(date).isBetween(moment(range.startDate), end, null, '[]')) {
                    return true;
                }
            }
            return false;
        }

        function getTotalDate(startDateStr, endDateStr) {
            const startDate = new Date(startDateStr);
            const endDate = new Date(endDateStr);
            const startTime = startDate.getTime();
            const endTime = endDate.getTime();
            const timeDifference = endTime - startTime;
            const totalDays = Math.ceil(timeDifference / (1000 * 3600 * 24));
            return totalDays;
        }
    </script>
@endsection
