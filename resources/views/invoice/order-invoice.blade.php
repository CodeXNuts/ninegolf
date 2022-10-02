<x-app-layout>
    <x-slot name="addOnCss">
        <style>
            .invoice {
                background: #fff;
                padding: 20px
            }

            .invoice-company {
                font-size: 20px
            }

            .invoice-header {
                margin: 0 -20px;
                background: #f0f3f4;
                padding: 20px
            }

            .invoice-date,
            .invoice-from,
            .invoice-to {
                display: table-cell;
                width: 1%
            }

            .invoice-from,
            .invoice-to {
                padding-right: 20px
            }

            .invoice-date .date,
            .invoice-from strong,
            .invoice-to strong {
                font-size: 16px;
                font-weight: 600
            }

            .invoice-date {
                text-align: right;
                padding-left: 20px
            }

            .invoice-price {
                background: #f0f3f4;
                display: table;
                width: 100%
            }

            .invoice-price .invoice-price-left,
            .invoice-price .invoice-price-right {
                display: table-cell;
                padding: 20px;
                font-size: 20px;
                font-weight: 600;
                width: 75%;
                position: relative;
                vertical-align: middle
            }

            .invoice-price .invoice-price-left .sub-price {
                display: table-cell;
                vertical-align: middle;
                padding: 0 20px
            }

            .invoice-price small {
                font-size: 12px;
                font-weight: 400;
                display: block
            }

            .invoice-price .invoice-price-row {
                display: table;
                float: left
            }

            .invoice-price .invoice-price-right {
                width: 25%;
                background: #2d353c;
                color: #fff;
                font-size: 28px;
                text-align: right;
                vertical-align: bottom;
                font-weight: 300
            }

            .invoice-price .invoice-price-right small {
                display: block;
                opacity: .6;
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 12px
            }

            .invoice-footer {
                border-top: 1px solid #ddd;
                padding-top: 10px;
                font-size: 10px
            }

            .invoice-note {
                color: #999;
                margin-top: 80px;
                font-size: 85%
            }

            .invoice>div:not(.invoice-footer) {
                margin-bottom: 20px
            }

            .btn.btn-white,
            .btn.btn-white.disabled,
            .btn.btn-white.disabled:focus,
            .btn.btn-white.disabled:hover,
            .btn.btn-white[disabled],
            .btn.btn-white[disabled]:focus,
            .btn.btn-white[disabled]:hover {
                color: #2d353c;
                background: #fff;
                border-color: #d9dfe3;
            }
        </style>

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    </x-slot>
    
    <x-order.invoice-blade-sec :orderData="$orderData" />

    <x-slot name="addOnJs">

    </x-slot>
</x-app-layout>
