import axios from "axios";
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('.order-status-select');

    if(!selects.length) {
        return;
    }
    selects.forEach(select => {
        select.addEventListener('change', function() {
            const form = this.closest('form');
            const actionUrl = form.action;
            const formData = new FormData(form);

            console.log(form);

            axios.post(actionUrl, formData)
                .then(response => {
                    // Handle success - you can show a message or update the UI as needed
                    console.log('Order status updated successfully:', response.data);
                    const tdElement = this.closest('td');
                    this.className = response.data.className;
                })
                .catch(error => {
                    // Handle error - you can show an error message
                    console.error('Error updating order status:', error);
                });
        });
    });
});
