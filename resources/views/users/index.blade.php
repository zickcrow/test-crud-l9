<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
        <style>
            [x-cloak] {
                display: none;
            }

            [type="checkbox"] {
                box-sizing: border-box;
                padding: 0;
            }

            .form-checkbox {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                display: inline-block;
                vertical-align: middle;
                background-origin: border-box;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                flex-shrink: 0;
                color: currentColor;
                background-color: #fff;
                border-color: #e2e8f0;
                border-width: 1px;
                border-radius: 0.25rem;
                height: 1.2em;
                width: 1.2em;
            }

            .form-checkbox:checked {
                background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
                border-color: transparent;
                background-color: currentColor;
                background-size: 100% 100%;
                background-position: center;
                background-repeat: no-repeat;
            }
        </style>
        <script>
            function datatables() {
                const users = JSON.parse(@json($users));
                return {
                    headings: [
                        {
                            'key': 'id',
                            'value': 'ID'
                        },
                        {
                            'key': 'name',
                            'value': 'Name'
                        },
                        {
                            'key': 'birthday',
                            'value': 'Birthday'
                        },
                        {
                            'key': 'emailAddress',
                            'value': 'Email'
                        },
                        {
                            'key': 'address',
                            'value': 'Address'
                        },
                        {
                            'key': 'action',
                            'value': 'Action'
                        }
                    ],
                    users: users,
                    selectedRows: [],

                    open: false,

                    toggleColumn(key) {
                        // Note: All td must have the same class name as the headings key!
                        let columns = document.querySelectorAll('.' + key);

                        if (this.$refs[key].classList.contains('hidden') && this.$refs[key].classList.contains(key)) {
                            columns.forEach(column => {
                                column.classList.remove('hidden');
                            });
                        } else {
                            columns.forEach(column => {
                                column.classList.add('hidden');
                            });
                        }
                    },

                    getRowDetail($event, id) {
                        let rows = this.selectedRows;

                        if (rows.includes(id)) {
                            let index = rows.indexOf(id);
                            rows.splice(index, 1);
                        } else {
                            rows.push(id);
                        }
                    },

                    selectAllCheckbox($event) {
                        let columns = document.querySelectorAll('.rowCheckbox');

                        this.selectedRows = [];

                        if ($event.target.checked == true) {
                            columns.forEach(column => {
                                column.checked = true
                                this.selectedRows.push(parseInt(column.name))
                            });
                        } else {
                            columns.forEach(column => {
                                column.checked = false
                            });
                            this.selectedRows = [];
                        }
                    }
                }
            }
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto py-6 px-4" x-data="datatables()" x-cloak>
                    <h1 class="text-3xl py-4 border-b mb-10">
                        <x-nav-link :href="route('users.create')" :active="request()->routeIs('users.create')">
                            {{ __('Create User') }}
                        </x-nav-link>
                    </h1>

                    <div x-show="selectedRows.length" class="bg-teal-200 fixed top-0 left-0 right-0 z-40 w-full shadow">
                        <div class="container mx-auto px-4 py-4">
                            <div class="flex md:items-center">
                                <div class="mr-4 flex-shrink-0">
                                    <svg class="h-8 w-8 text-teal-600"  viewBox="0 0 20 20" fill="currentColor">  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                </div>
                                <div x-html="selectedRows.length + ' rows are selected'" class="text-teal-800 text-lg"></div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative"
                        style="height: 405px;">
                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead>
                                <tr class="text-left">
                                    <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">
                                        <label
                                            class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                            <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" @click="selectAllCheckbox($event);">
                                        </label>
                                    </th>
                                    <template x-for="heading in headings">
                                        <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"
                                            x-text="heading.value" :x-ref="heading.key" :class="{ [heading.key]: true }"></th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="user in users" :key="user.id">
                                    <tr>
                                        <td class="border-dashed border-t border-gray-200 px-3">
                                            <label
                                                class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                                <input type="checkbox" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline" :name="user.id"
                                                        @click="getRowDetail($event, user.id)">
                                            </label>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 id">
                                            <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.id"></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 name">
                                            <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.name"></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 birthday">
                                            <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.birthday"></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 emailAddress">
                                            <span class="text-gray-700 px-6 py-3 flex items-center"
                                                x-text="user.emailAddress"></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 address">
                                            <span class="text-gray-700 px-6 py-3 flex items-center"
                                                x-text="user.address"></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 action">
                                            <x-nav-link x-bind:href="'users/' + user.id + '/edit'" :active="request()->routeIs('users.edit')">
                                                Edit
                                            </x-nav-link>
                                            <x-nav-link x-bind:href="'users/' + user.id " :active="request()->routeIs('users.destroy')">
                                                Delete
                                            </x-nav-link>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
