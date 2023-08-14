<script>
    jQuery(document).ready(function ($) {
        $("#btn-save").click(function (e) {
            jQuery('.message-show').empty();
            $('#btn-save').prop("disabled", true);
            $('#comment-form').addClass("disabled");
            jQuery('#comment-form .site-notification.success').removeClass('show');
            e.preventDefault();
            $.ajax({
                url: "{{ route('user-comment.store') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    name: jQuery('#name').val(),
                    email: jQuery('#email').val(),
                    message: jQuery('#message').val(),
                    post_type: 'blog',
                    post_slug: '{{ $Blog->slug }}',
                },
                cache: false,
                dataType: 'json',
                success: function (dataResult) {
                    $('#commentForm')[0].reset();
                    $('#btn-save').prop("disabled", false);
                    $('#comment-form').removeClass("disabled");
                    jQuery('#comment-form .site-notification.success').addClass('show');
                    jQuery('#comment-form .site-notification .text-message').append(dataResult.message);
                    console.log(dataResult);
                },
                error: function (data) {
                    $('#btn-save').prop("disabled", false);
                    $('#comment-form').removeClass("disabled");

                    if (data.responseJSON.errors) {
                        if (data.responseJSON.errors.name) {
                            jQuery('#validation-name').append(data.responseJSON.errors.name);
                        }
                        if (data.responseJSON.errors.email) {
                            jQuery('#validation-email').append(data.responseJSON.errors.email);
                        }
                        if (data.responseJSON.errors.message) {
                            jQuery('#validation-message').append(data.responseJSON.errors.message);
                        }
                    }

                    console.log(data);
                }
            });
        });
    });
</script>
