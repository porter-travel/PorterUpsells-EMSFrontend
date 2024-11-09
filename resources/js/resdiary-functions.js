document.addEventListener("DOMContentLoaded", function() {
    // Check if the form component has the "data-requires-resdiary-booking" attribute
    const formComponent = document.querySelector("[data-requires-resdiary-booking]");
    if (formComponent) {
        // Find the input element with the "data-stay-date-selector" attribute
        const stayDateInput = document.querySelector("[data-stay-date-selector]");

        if (stayDateInput) {
            const date = stayDateInput.value;

            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Set the CSRF token as a header in axios
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

            // Make the axios request with the stay date value
            axios.post('/resdiary/get-availability', {
                date: date
            })
                .then(response => {
                    console.log("Response:", response.data);
                    processAvailableTimes(response.data);
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        } else {
            console.error("Input with 'data-stay-date-selector' not found.");
        }
    } else {
        console.log("Form does not require ResDiary booking.");
    }
});

function processAvailableTimes(times) {
    const el = document.querySelector("[data-resdiary-promotion-id]");
    const promotionId = el.dataset.resdiaryPromotionId;
    const availableTimes = [];

    times.TimeSlots.forEach(time => {
        // Check if any promotion in AvailablePromotions matches the promotionId
        const hasMatchingPromotion = time.AvailablePromotions.some(promotion => promotion.Id == promotionId);

        if (hasMatchingPromotion) {
            availableTimes.push(getTimeString(time.TimeSlot));
            console.log(time.TimeSlot);
        }
    });

    let output = '<ul>';
    availableTimes.forEach(time => {
        output += `<li>${time}</li>`;
    })
    output += '</ul>';
    document.getElementById('resdiary_time_selector').innerHTML = output;
}


function getTimeString(dateString){
    // Convert the string to a Date object
    const date = new Date(dateString);

// Extract hours and minutes, and format as HH:MM
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    return `${hours}:${minutes}`;
}



const testData = {
    "TimeSlots": [
        {
            "TimeSlot": "2024-11-25T05:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "06:00:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T05:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "06:15:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T05:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "06:30:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T05:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "06:45:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T06:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "07:00:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T06:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "07:15:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T06:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "07:30:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T06:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "07:45:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T07:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "08:00:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T07:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "08:15:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T07:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "08:30:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T07:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "08:45:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T08:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "09:00:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T08:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "09:15:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T08:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "09:30:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T08:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "09:45:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T09:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "10:00:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T09:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "10:15:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T09:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "10:30:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T09:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "10:45:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T10:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "11:00:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T10:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "11:15:00",
            "ServiceId": 8240,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T12:00:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "13:30:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "13:30:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T12:15:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "13:45:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "13:45:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T12:30:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "14:00:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "14:00:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T12:45:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "14:15:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "14:15:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T13:00:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "14:30:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "14:30:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T13:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "14:45:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "14:45:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T13:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "15:00:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "15:00:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T13:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "15:15:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "15:15:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T14:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "15:30:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "15:30:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T14:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "15:45:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "15:45:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T14:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "16:00:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "16:00:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T14:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "16:15:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "16:15:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T15:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "16:30:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [
                {
                    "Id": 2659,
                    "FeeAmount": 0,
                    "LeaveTime": "16:30:00",
                    "BasePrice": 0
                }
            ],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T15:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "16:45:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T15:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "17:00:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T15:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "17:15:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T16:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "17:30:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T16:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "17:45:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T16:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "18:00:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T16:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "18:15:00",
            "ServiceId": 8241,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T17:30:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "18:30:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T17:45:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "18:45:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T18:00:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "19:00:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T18:15:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "19:15:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T18:30:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "19:30:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T18:45:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "19:45:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T19:00:00.0000000",
            "IsLeaveTimeRequired": true,
            "LeaveTime": "20:00:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T19:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "20:15:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T19:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "20:30:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T19:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "20:45:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T20:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "21:00:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T20:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "21:15:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T20:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "21:30:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T20:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "21:45:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T21:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "22:00:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T21:15:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "22:15:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T21:30:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "22:30:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T21:45:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "22:45:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        },
        {
            "TimeSlot": "2024-11-25T22:00:00.0000000",
            "IsLeaveTimeRequired": false,
            "LeaveTime": "23:00:00",
            "ServiceId": 8242,
            "HasStandardAvailability": true,
            "AvailablePromotions": [],
            "StandardAvailabilityFeeAmount": 0
        }
    ],
    "Promotions": [
        {
            "Id": 2659,
            "Name": "Afternoon Tea",
            "Description": "Tea, cakes etc",
            "MayRequireCreditCard": false,
            "MayRequireDeposit": false,
            "HorizontalImageUrl": "",
            "VerticalImageUrl": "",
            "Translations": [
                {
                    "LanguageCode": "en-GB",
                    "Name": "Afternoon Tea",
                    "Description": "Tea, cakes etc"
                }
            ],
            "PromotionTypeCodes": [],
            "ValidityPeriods": [
                {
                    "StartDate": "2024-10-23T00:00:00.0000000",
                    "EndDate": "2025-10-23T00:00:00.0000000",
                    "StartTime": "12:00:00",
                    "EndTime": "15:00:00",
                    "Frequency": [
                        "Sunday",
                        "Monday",
                        "Tuesday",
                        "Wednesday",
                        "Thursday",
                        "Friday",
                        "Saturday"
                    ],
                    "IsAlwaysApply": false,
                    "DayVariables": []
                }
            ],
            "FullPrice": 0,
            "PartySizeOperator": "DoNotCare",
            "PartySizeLimit": 0,
            "PartySizeMinCovers": 0,
            "PartySizeMaxCovers": 0,
            "LimitType": "None",
            "MaxNumberOfSold": 0,
            "MenuVersionId": null,
            "MenuName": null,
            "TakeawayType": "None",
            "MenuUrl": null,
            "IsInternalOnly": false,
            "AdvertisementPeriod": null
        }
    ],
    "StandardAvailabilityMayRequireCreditCard": false
}

// processAvailableTimes(testData)
