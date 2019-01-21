(function( $ ) {
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.color-field').wpColorPicker();
        $('.clockpicker').clockpicker({
            donetext: 'OK'
        });

        $('.add-button').on('click',buildNewTrainerInput);

        function buildNewTrainerInput( event ) {
            var target = $(event.target);
            // build new trainers input field

            var trainerOptions = getTrainerSelectOptions();
            console.log(trainerOptions);

            var trainerFieldset = $('<div>').attr('class', 'sdrost_class_trainer_fieldset');

            var trainerInputField = $('<select>').attr('id', 'sdrost_class_trainer_data')
                .attr('name', 'sdrost_class_trainer_data[]');

            var addButton = $('<button>').attr('type', 'button')
                .attr('class', 'add-button')
                .on('click', buildNewTrainerInput);

            var removeButton = $('<button>').attr('type', 'button')
                .attr('class', 'remove-button')
                .on('click', removeTrainerLine);

            for (var i = 0; i < trainerOptions.length; i++) {
                var optionField = $('<option>').val(trainerOptions[i].id)
                    .html(trainerOptions[i].name);
                trainerInputField.append(optionField);
            }

            trainerFieldset.append(
                trainerInputField,
                removeButton,
                addButton
            );

            target.parent().parent().append(trainerFieldset);
        }

        function removeTrainerLine( event ) {
            var target = $(event.target);
            console.log(target);
            target.parent().remove();
        }

        function getTrainerSelectOptions() {
            var trainers = [];

            $.ajax({
                type: 'POST',
                async: false,
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'sdrost_classes_get_trainers_ajax' //this is the name of the AJAX method called in WordPress
                }, success: function (result) {
                    trainers = result;
                },
                error: function () {
                    return [];
                }
            });

            return trainers;
        }
    });
})( jQuery );