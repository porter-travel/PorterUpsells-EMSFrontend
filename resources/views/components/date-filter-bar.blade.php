<form method="get">
    <div class="flex items-center pb-6">
        <div>
            <label>Start Date
                <input type="date" name="start_date" value="{{$startDate}}"></label>
        </div>

        <div class="mx-4">
            <label>End Date
                <input type="date" name="end_date" value="{{$endDate}}"></label>
        </div>
        <div>
            <x-secondary-button type="submit">Filter</x-secondary-button>
        </div>
    </div>
</form>
