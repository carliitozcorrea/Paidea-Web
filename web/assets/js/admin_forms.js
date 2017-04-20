$(function () {
     $('[data-ajax-remove]').click(function (e) {
        e.preventDefault();
        var $this = $(this);
        acepted = true,
        $parent = $this.closest('tr');
        $this.prop('disabled', true).attr('disabled', true);
        
        if ($this.hasClass('delete')) {
            acepted = confirm('¿Estas Seguro?');
        }
        if (acepted != true) {
            $this.prop('disabled', false).attr('disabled', false);
            return false;
        }
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: $this.data('ajax-remove'),
            success: function (data) {
                if (data.status === 'updated' || data.status === 'delete') {
                    $parent.fadeOut(500, function () {
                        $parent.remove();
                    });
                } else {
                    alert('Error: #1255');
                    $this.prop('disabled', false).attr('disabled', false);
                }
            },
            error: function () {
                alert('Error: #1254');
                $this.prop('disabled', false).attr('disabled', false);
            }
        });
        
     })
});