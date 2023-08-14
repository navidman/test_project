$(document).ready(function () {
    $('.select-all').click(function () {
        $('.delete-checkbox').prop('checked', this.checked);
    });

    var $chkboxes = $('.delete-checkbox');
    var lastChecked = null;

    $chkboxes.click(function (e) {
        if (!lastChecked) {
            lastChecked = this;
            return;
        }

        if (e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);

            $chkboxes.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', lastChecked.checked);
        }

        lastChecked = this;
    });

    $(".menu-admin .child-menu a").click(function (e) {
        $(this).toggleClass('active-sub-menu');
        $(this).parent().find('.sub-menu-1', this).slideToggle(300);
    });
    $(".menu-admin .child-menu-2 a").click(function (e) {
        $(this).parent().find('.sub-menu-2', this).slideToggle(300);
    });


    $('.header-btn').click(function () {
        $('.active-menu').not(this).removeClass('active-menu');
        $(this).toggleClass('active-menu');
    });
});

/* Chosen JS */
$(".select").chosen({
    width: "100%",
});
