<x-administrator-app-layout>
    <x-slot name="addOnCss" >
        <style>
  
.actionBtn {
	display: flex;
	align-items: center;
	height: 100%;
	min-height: 50px;
}
.responsive-Table {
	overflow-x:auto;
}
table.dataTable thead tr th:first-child {
	width: 180px !important;
}
        </style>
    </x-slot>

    <x-admin.product-list-sec :clubs="$clubs"/>

    <x-slot name="addOnJs" >
        <script src="{{ asset('admin/assets/js/pages/product.js') }}"></script>
    </x-slot>
</x-administrator-app-layout>