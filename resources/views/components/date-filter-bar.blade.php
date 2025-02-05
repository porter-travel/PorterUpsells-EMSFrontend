<form id="filterBarForm" method="get">
    <div class="flex items-end justify-between">
        <div class="flex items-end pb-6">
            <div>
                <label><span class="font-bold block">Start Date</span>
                    <x-text-input id="startDatePicker" type="date" name="start_date" value="{{$startDate}}"/>
                </label>
            </div>

            <div class="mx-4">
                <label><span class="font-bold block">End Date</span>
                    <x-text-input id="endDatePicker" type="date" name="end_date" value="{{$endDate}}"/>
                </label>
            </div>
            @if(isset($status))
                <div class="mr-4">
                    <label><span class="font-bold block">Status</span>
                        <select name="status" class="order-status-select rounded-lg">
                            <option value="all">All</option>

                            @foreach(\App\Enums\OrderStatus::getValues() as $value)
                                @if($value == 'complete')
                                    @continue
                                @endif
                                <option @if($status == $value) selected
                                        @endif value="{{$value}}">{{ucfirst($value)}}</option>
                            @endforeach
                        </select></label>
                </div>
            @endif
            <div>
                <x-primary-button type="submit">Filter</x-primary-button>
            </div>
        </div>
        @if(isset($exportLink))
            <div class="pb-6">
                <a id="exportLink" href="{{$exportLink}}">
                    <x-secondary-button type="button">Export</x-secondary-button>
                </a>

            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const form = document.querySelector("#filterBarForm");
                    const exportButton = document.getElementById("exportLink");

                    form.addEventListener("submit", function (event) {
                        const formData = new FormData(form);
                        const params = new URLSearchParams(formData).toString();
                        exportButton.href = "{{$exportLink}}?" + params;
                    });

                    // Ensure the export button URL is updated on page load
                    const initialParams = new URLSearchParams(new FormData(form)).toString();
                    exportButton.href = "{{$exportLink}}?" + initialParams;
                });

            </script>
        @endif
    </div>
</form>


