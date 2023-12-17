$(function() {
    $("#form-total").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        stepsOrientation: "vertical",
        autoFocus: true,
        transitionEffectSpeed: 500,
        titleTemplate: '<div class="title">#title#</div>',
        labels: {
            previous: 'Back Step',
            next: '<i class="zmdi zmdi-arrow-right"></i>',
            finish: '<i class="zmdi zmdi-check"></i>',
            current: ''
        },
        onStepChanging: function(event, currentIndex, priorIndex) {
            // The current step container
            let container = $('#form-total-p-' + currentIndex);
            var valid = true;
            $(':input[required]', container).each(function(i, obj) {
                if (obj.value.trim() === '') {
                    alert(`Le champ ${parseName(obj.name)} ne peut pas être vide`);
                    valid = false;
                    return valid;
                }
            });
            return valid;
        },
        onFinished: function(event, currentIndex) {
            if (valider()) {
                $('#inscrit').submit();
                console.log('ok');
            }

        }
    });

    const parseName = function(name) {
        var nameParts = name.split("_");
        var newName = "";
        for (var i = 0; i < nameParts.length; i++) {
            newName += nameParts[i] + " ";
        }
        return newName;
    }

});

function valider() {
    let container = $('#form-total-p-' + 4);
    var valid = true;
    $(':input[required]', container).each(function(i, obj) {
        if (obj.value.trim() === '') {
            alert(`Le champ ${parseName(obj.name)} ne peut pas être vide`);
            valid = false;
            return valid;
        }
    });
    return valid;
}