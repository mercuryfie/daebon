$(document).ready(function() {


    $('.period').click(function(e) {
        e.preventDefault();
        $('.period').removeClass('active');
        $(this).addClass('active');

        const today = new Date();
        let startDate = new Date();
        let endDate = new Date();

        const periodText = $(this).text();

        switch (periodText) {
            case '오늘':
                startDate = today;
                endDate = today;
                break;
            case '1주일':
                startDate = new Date(today);
                startDate.setDate(today.getDate() - 6);
                endDate = today;
                break;
            case '1개월':
                startDate = new Date(today);
                startDate.setMonth(today.getMonth() - 1);
                startDate.setDate(startDate.getDate() + 1);
                endDate = today;
                break;
            case '3개월':
                startDate = new Date(today);
                startDate.setMonth(today.getMonth() - 3);
                startDate.setDate(startDate.getDate() + 1);
                endDate = today;
                break;
            default:
                startDate = today;
                endDate = today;
        }

        $('#s_date').val(formatDate(startDate));
        $('#e_date').val(formatDate(endDate));

    });

    $('.datepicker').each(function(index, elem) {
        const fp = flatpickr(elem, {
            dateFormat: "Y-m-d",
            minDate: "2024-01-01",
            static: true,
            appendTo: elem.parentNode,
            onClose: function(selectedDates, dateStr, instance) {
                instance.element.blur();
            }
        });

        $('.calicon').eq(index).on('click', function(e) {
            e.preventDefault();
            fp.open();
        });


    });


});


function formatDate(d) {
    const year = d.getFullYear();
    const month = ('0' + (d.getMonth() + 1)).slice(-2);
    const day = ('0' + d.getDate()).slice(-2);
    return `${year}/${month}/${day}`;
}