<x-administrator-app-layout>
    <x-slot name="addOnCss" >
        <style>
            table.dataTable thead tr th:first-child {
	width: 250px !important;
}
        </style>
    </x-slot>

    <x-admin.user-sec :users="$users"/>

    <x-slot name="addOnJs" >
        <script src="{{ asset('admin/assets/js/pages/user-sec.js') }}"></script>
    </x-slot>
</x-administrator-app-layout>