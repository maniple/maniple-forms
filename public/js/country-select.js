var countrySelect = function (selector) { // {{{
    var $ = window.jQuery,
        placeholder = {
            validOrEmpty: 'Enter a country name...',
            invalid: 'Enter a valid country name...'
        };
    return $.fn.selectToAutocomplete && $(selector).each(function () {
            var $this = $(this),
                input,
                initialValue;

            function setPlaceholder(placeholder) {
                if (input) {
                    input.attr('placeholder', placeholder);
                    $.fn.placeholder && input.placeholder(placeholder);
                }
            }

            $this.selectToAutocomplete({
                handle_invalid_input: function (context) {
                    context.$select_field.find('option[value=""]').select();
                    context.$text_field.addClass('invalid-value');

                    if (context.$text_field.val().length) {
                        setPlaceholder(placeholder.invalid);
                    } else {
                        setPlaceholder(placeholder.validOrEmpty);
                    }
                },
                handle_valid_values: function (context) {
                    context.$text_field.removeClass('invalid-value');
                    setPlaceholder(placeholder.validOrEmpty);
                },
                blur: function () {
                    var $this = $(this);
                    if ($this.hasClass('invalid-value')) {
                        $this.val('');
                    }
                }
            });

            input = $this.data('selectToAutocomplete').$text_field;
            initialValue = $this.find('option:selected:first');

            if (initialValue.size() == 0 || initialValue.attr('value') == '') {
                input.val('');
            }

            input.attr('placeholder', placeholder.validOrEmpty);
            $.fn.placeholder && input.placeholder();

            $this.nextAll('.ui-helper-hidden-accessible').hide();
        });
} // }}}
