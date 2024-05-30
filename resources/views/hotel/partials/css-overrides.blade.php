<style>

    body{
        background-color: {{$hotel->page_background_color ?? '#ffffff'}};
    }

    .hotel-main-box-color{
        background-color: {{$hotel->main_box_color ?? '#F5D6E1'}};
    }

    .hotel-main-box-text-color{
        color: {{$hotel->main_box_text_color ?? '#000000'}};
    }

    .hotel-button-color{
        background-color: {{$hotel->button_color ?? '#D4F6D1'}};
    }

    .hotel-accent-color{
        background-color: {{$hotel->accent_color ?? '#C7EDF2'}};
    }

    .hotel-accent-color-50{
        background-color: {{substr_replace($hotel->accent_color, '80', 1, 0) ?? '#80C7EDF2'}};
    }

    .hotel-text-color{
        color: {{$hotel->text_color ?? '#000000'}};
    }

    .hotel-button-text-color{
        color: {{$hotel->button_text_color ?? '#000000'}};
    }
</style>
