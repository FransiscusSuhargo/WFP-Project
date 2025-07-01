@extends('employee.layouts.app')
@section('pageName', 'Order Detail Page')

@section('style')
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div id="orderDetail">
                    <h2>Order: {{ $order->queue_number }} - ({{ $order->type }})</h2>
                    <table>
                        <tr>
                            <th width="60%">Cashier</th>
                            <td> :&nbsp;&nbsp;</td>
                            <td>{{ auth()->user()->employee->name }}</td>
                        </tr>
                        <tr>
                            <th width="60%">Payment Method</th>
                            <td> :&nbsp;&nbsp;</td>
                            <td>{{ ucwords(str_replace("_", " ", $order->payment_type)) }}</td>
                        </tr>
                        <tr>
                            <th width="60%">Order Date</th>
                            <td> :&nbsp;&nbsp;</td>
                            <td>{{ $order->created_at->timezone('Asia/Jakarta')->format('F j, Y g:i A') }}</td>
                        </tr>
                    </table>
                    <table class="table table-striped mt-4">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center text-white">Name</th>
                                <th class="text-center text-white">Price</th>
                                <th class="text-center text-white">Note</th>
                                <th class="text-center text-white">Modifiers</th>
                                <th class="text-center text-white">Addons</th>
                                <th class="text-center text-white">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderDetails as $orderDetails)
                                @php
//                                    $orderDetails = $order->orderDetails;
                                    $food = $orderDetails->food;
                                    $modifiers = $orderDetails->modifiers;
                                    $addons = $orderDetails->addons;
                                    $subtotal = $orderDetails->subtotal
                                @endphp
                                <tr>
                                    <td>{{ $food->name }}</td>
                                    <td>{{ $food->price }}</td>
                                    <td>{{ $orderDetails->note }}</td>
                                    <td class="@if(count($modifiers) == 0) text-center @endif">
                                        @if(count($modifiers) > 0)
                                            <ul>
                                                @foreach($modifiers as $modifier)
                                                    <li>{{ $modifier->name }} {{ ($modifier->price) }}</li>
                                                    @php($subtotal += $modifier->price)
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="@if(count($addons) == 0) text-center @endif">
                                        @if(count($addons) > 0)
                                            <ul>
                                                @foreach($addons as $addon)
                                                    <li>{{ $modifier->name }} {{($addon->price) }}</li>
                                                    @php($subtotal += $addon->price)
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr class="fw-bold">
                                <td colspan="5" class="text-center">Total</td>
                                <td class="text-center">{{ $total  }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <button onclick="printPdf()" class="btn btn-primary mt-2">Download PDF</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        async function printPdf() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const table = document.getElementById("orderDetail");

            await html2canvas(table).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const imgProps= doc.getImageProperties(imgData);
                const pdfWidth = doc.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                doc.addImage(imgData, 'PNG', 0, 10, pdfWidth, pdfHeight);
                doc.save("order.pdf");
            });
        }
    </script>
@endsection
