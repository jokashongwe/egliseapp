$(document).ready(function () {
    $('#departementSelect').change(function () {
        var departementId = $(this).val();
        $.ajax({
            url: '/get-sous-departements/' + departementId,


            type: 'GET',


            dataType: 'json',


            success: function (data) {


                var sousDepartementSelect = $('#sousDepartementSelect');
                sousDepartementSelect.
                    sousDepartementSelec


                empty();
                $.

                    each(data, function (key, value) {
                        sousDepartementSelect.
                            sousDepa


                        append('<option value="' + value.id + '">' + value.nom + '</option>');
                    });
            }
        });
    });
});